<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Example data – replace with real statistics
        $stats = [
            'total' => Report::count(),
            'by_type' => Report::selectRaw('type, count(*) as count')->groupBy('type')->get(),
            'by_verification' => Report::selectRaw('verification_status, count(*) as count')->groupBy('verification_status')->get(),
        ];
        return view('admin.analytics', compact('stats'));
    }
}