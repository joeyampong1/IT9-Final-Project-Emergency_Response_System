<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Station;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\StationAlert;
use App\Models\Report;
use Illuminate\Support\Facades\Log;

/**
 * @method void middleware(string|array $middleware, array $options = [])
 */
class AdminStationController extends Controller
{

    public function index(Request $request)
    {
    $query = Station::query();

    // Filter by type
    if ($request->filled('type')) {
        $query->where('type', $request->type);
    }

    // Search by name or address
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });
    }

    $stations = $query->latest()->paginate(15)->appends($request->query());

    return view('admin.stations.index', compact('stations'));
    }

    public function create()
    {
        return view('admin.stations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'phone' => 'nullable|string',
            'type' => 'required|in:fire,police,medical',
            'email' => 'required|email',
        ]);

        Station::create($validated);

        return redirect()->route('admin.stations.index')->with('success', 'Station created.');
    }

    public function edit(Station $station)
    {
        return view('admin.stations.edit', compact('station'));
    }

    public function update(Request $request, Station $station)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'phone' => 'nullable|string',
            'email' => 'required|email',
            'type' => 'required|in:fire,police,medical',
        ]);

        $station->update($validated);

        \Log::info('Updating station', $validated);
        \Log::info('Station after update', $station->toArray());

        return redirect()->route('admin.stations.index')->with('success', 'Station updated.');
    }

    public function destroy(Station $station)
    {
        $station->delete();
        return redirect()->route('admin.stations.index')->with('success', 'Station deleted.');
    }

   public function sendAlert(Request $request, $stationId, $reportId)
    {
    try {
        $station = Station::findOrFail($stationId);
        $report = Report::findOrFail($reportId);

        // Check if station has email
        if (empty($station->email)) {
            return response()->json(['error' => 'Station has no email address.'], 400);
        }

        // Send email
        Mail::to($station->email)->send(new StationAlert($report, $station));

        return response()->json(['message' => 'Alert sent to station.']);
        } catch (\Exception $e) {
            // Log the error and return it
            \Log::error('SendAlert error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}