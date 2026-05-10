<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Notification;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use App\Mail\ReportStatusUpdated;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware(\Illuminate\Auth\Middleware\Authenticate::class);
    }

    public function index(Request $request)
    {
        $query = Report::with('reporter', 'responder', 'attachments');

        // Handle show_resolved parameter
        if ($request->has('show_resolved')) {
            $query->where('status', 'resolved');
        } else {
            $query->where('status', '!=', 'resolved');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter by verification status
        if ($request->filled('verification')) {
            $query->where('verification_status', $request->verification);
        }

        $reports = $query->latest()->paginate(15)->appends($request->query());

        // Enhanced stats with verification counts
        $stats = [
            'total'      => Report::count(),
            'pending'    => Report::where('status', 'pending')->count(),
            'verifying'  => Report::where('status', 'verifying')->count(),
            'responding' => Report::where('status', 'responding')->count(),
            'resolved'   => Report::where('status', 'resolved')->count(),
            'rejected'   => Report::where('status', 'rejected')->count(),
            'unverified' => Report::where('verification_status', 'unverified')->count(),
            'legit'      => Report::where('verification_status', 'legit')->count(),
            'scam'       => Report::where('verification_status', 'scam')->count(),
        ];

        // Unread notification data for the admin
        $unreadReportIds = Notification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->where('type', 'new_report')
            ->pluck('report_id')
            ->toArray();

        $unreadCount = count($unreadReportIds);

        return view('admin.dashboard', compact('reports', 'stats', 'unreadReportIds', 'unreadCount'));
    }

    public function show(Request $request, Report $report)
    {
        // Mark notification as read
        $notification = Notification::where('user_id', auth()->id())
            ->where('report_id', $report->id)
            ->whereNull('read_at')
            ->first();
        if ($notification) {
            $notification->markAsRead();
        }

        $report->load('reporter', 'responder', 'updates.user', 'attachments', 'messages.user');

        $returnUrl = $request->get('return_url', route('admin.dashboard'));

        return view('admin.reports.show', compact('report', 'returnUrl'));
    }

    // Update report status and verification
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'status'              => 'required|in:pending,verifying,responding,resolved,rejected',
            'notes'               => 'nullable|string',
            'assigned_to'         => 'nullable|exists:users,id',
            'verification_status' => 'required|in:unverified,legit,scam',
        ]);

        $report->update($validated);

        if ($validated['status'] == 'responding' && !$report->responded_at) {
            $report->responded_at = Carbon::now();
            $report->save();
        }
        if ($validated['status'] == 'resolved' && !$report->resolved_at) {
            $report->resolved_at = Carbon::now();
            $report->save();
        }

        $report->updates()->create([
            'user_id' => auth()->id(),
            'status'  => $validated['status'],
            'notes'   => $validated['notes'] ?? null,
        ]);

        // Send email notification to the reporter (citizen) about status change
        if ($report->reporter && $report->reporter->email) {
            Mail::to($report->reporter->email)->send(new ReportStatusUpdated($report));
        }

        // Create database notification for the citizen
        if ($report->reporter) {
            Notification::create([
                'user_id'   => $report->reporter->id,
                'report_id' => $report->id,
                'type'      => 'status_update',
                'content'   => "Your report #{$report->id} status has been updated to " . ucfirst($validated['status']),
            ]);
        }

        // Redirect back to the original dashboard page (preserving filters & pagination)
        $returnUrl = $request->get('return_url', route('admin.dashboard'));
        return redirect($returnUrl)->with('success', 'Report updated.');
    }

    // AJAX endpoint to mark a notification as read
    public function markRead(Request $request)
    {
        $request->validate([
            'report_id' => 'required|exists:reports,id',
        ]);

        $notification = Notification::where('user_id', auth()->id())
            ->where('report_id', $request->report_id)
            ->whereNull('read_at')
            ->first();

        if ($notification) {
            $notification->markAsRead();
            $unreadCount = Notification::where('user_id', auth()->id())
                ->whereNull('read_at')
                ->count();
            return response()->json(['success' => true, 'unread_count' => $unreadCount]);
        }

        return response()->json(['success' => false, 'message' => 'No unread notification found']);
    }

    // Export methods
    public function export(Request $request)
    {
        $format = $request->query('format', 'csv');

        $query = Report::with('reporter', 'responder', 'station');

        if ($request->has('show_resolved')) {
            $query->where('status', 'resolved');
        } else {
            $query->where('status', '!=', 'resolved');
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $reports = $query->get();

        if ($format === 'csv') {
            return $this->exportCsv($reports);
        } elseif ($format === 'pdf') {
            return $this->exportPdf($reports);
        }

        return redirect()->back()->withErrors('Invalid format');
    }

    private function exportCsv($reports)
    {
        $filename = 'reports_' . date('Y-m-d_H-i') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($reports) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Citizen', 'Type', 'Title', 'Location', 'Status', 'Submitted', 'Station', 'Description', 'Verification']);

            foreach ($reports as $report) {
                fputcsv($file, [
                    $report->id,
                    $report->reporter->name ?? 'Unknown',
                    ucfirst($report->type),
                    $report->title,
                    $report->location,
                    ucfirst($report->status),
                    $report->created_at->format('Y-m-d H:i'),
                    $report->station->name ?? '—',
                    $report->description,
                    $report->verification_status,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function exportPdf($reports)
    {
        $data = ['reports' => $reports];
        $pdf = Pdf::loadView('admin.exports.export_report', $data);
        return $pdf->download('reports_' . date('Y-m-d_H-i') . '.pdf');
    }
}