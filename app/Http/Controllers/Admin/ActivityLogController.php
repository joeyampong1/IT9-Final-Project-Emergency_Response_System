<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportUpdate; // or create a dedicated ActivityLog model

class ActivityLogController extends Controller
{
    public function index()
    {
        // Example: get latest report updates (timeline)
        $logs = ReportUpdate::with('user')->latest()->paginate(20);
        return view('admin.activity-logs', compact('logs'));
    }
}