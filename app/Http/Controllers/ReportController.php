<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\ReportAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\Station;
use App\Models\Notification;
use App\Models\User;
use App\Mail\ReportSubmitted;
use Illuminate\Support\Facades\Mail;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');     
    }

        public function index(Request $request)
    {
        $query = auth()->user()->reports();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Search by title, description, or location
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $reports = $query->latest()->paginate(10);

        // Preserve query parameters for pagination links
        $reports->appends($request->only(['status', 'type', 'search']));

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:accident,fire,crime',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'attachments' => 'nullable|array|max:5',   
            'attachments.*' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480',
        ]);

        // Rate limiting: 3 reports per hour per user
        $key = 'report:'.auth()->id();
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return back()->withErrors('You have submitted too many reports. Please wait an hour.');
        }
        RateLimiter::hit($key, 3600);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'pending';

        $report = Report::create($validated);

                // Create notification for all admin users
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            Notification::create([
                'user_id'   => $admin->id,
                'report_id' => $report->id,
                'type'      => 'new_report',
                'content'   => "New report #{$report->id} submitted by " . auth()->user()->name,
            ]);
        }


        // Auto-assign nearest station of the same type
        if ($request->filled('latitude') && $request->filled('longitude')) {
            $typeMap = [
                'accident' => 'medical',
                'fire'     => 'fire',
                'crime'    => 'police',
            ];
            $requiredStationType = $typeMap[$request->type] ?? null;

            if ($requiredStationType) {
                $stations = Station::where('type', $requiredStationType)->get();
            } else {
                $stations = Station::all();
            }

            $nearestStation = null;
            $minDistance = PHP_INT_MAX;
            foreach ($stations as $station) {
                if ($station->latitude && $station->longitude) {
                    $distance = $this->haversineDistance(
                        $request->latitude,
                        $request->longitude,
                        $station->latitude,
                        $station->longitude
                    );
                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $nearestStation = $station;
                    }
                }
            }

            if ($nearestStation) {
                $report->station_id = $nearestStation->id;
                $report->save();
            }
        }

        // pansamantala debugging lang
         if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if ($file->isValid()) {
                    $path = $file->store('reports/' . $report->id, 'public');
                    if (!$path) {
                        \Log::error('Storage failed for file: ' . $file->getClientOriginalName());
                        continue;
                    }
                    $type = str_starts_with($file->getMimeType(), 'image/') ? 'image' : 'video';
                    $report->attachments()->create([
                        'file_path' => $path,
                        'file_type' => $type,
                        'original_name' => $file->getClientOriginalName(),
                        'mime_type' => $file->getMimeType(),
                    ]);
                } else {
                    \Log::error('Invalid file upload error: ' . $file->getError());
                }
            }
        }

        // Log initial update
        $report->updates()->create([
            'user_id' => auth()->id(),
            'status' => 'pending',
            'notes' => 'Report submitted.',
        ]);

        // Send confirmation email to reporter
    if ($report->reporter && $report->reporter->email) {
        Mail::to($report->reporter->email)->send(new ReportSubmitted($report));
    }

        return redirect()->route('reports.index')->with('success', 'Report submitted successfully.');
    }

    public function show(Report $report)
    {
        // Citizens can only see their own reports; admins can see any via separate route
        if ($report->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        return view('reports.show', compact('report'));
    }

    public function tracker(Request $request)
    {
        $report = null;
        if ($request->filled('report_id')) {
            $report = Report::where('id', $request->report_id)
                ->where('user_id', auth()->id())
                ->first();
            if (!$report) {
                return back()->withErrors('Report not found or you do not have access.');
            }
        }
        return view('citizen.tracker', compact('report'));
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // kilometers
        $latDelta = deg2rad($lat2 - $lat1);
        $lonDelta = deg2rad($lon2 - $lon1);
        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}