@extends('layouts.app')

@section('title', 'Report Status Tracker')

@section('content')
        @include('layouts.page-header', ['title' => 'Report Status Tracker'])

<div class="container-custom max-w-3xl mx-auto px-4 mt-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="p-5 sm:p-6">
            <form method="GET" class="mb-6">
                <div class="flex flex-col sm:flex-row gap-3">
                    <div class="flex-1">
                        <label for="report_id" class="block text-sm font-medium text-gray-700 mb-1">Enter Report ID</label>
                        <input type="text" name="report_id" id="report_id" class="form-input rounded-lg w-full" placeholder="e.g., 123" value="{{ request('report_id') }}">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="btn btn-primary w-full sm:w-auto px-6 py-2 rounded-lg">Track Report</button>
                    </div>
                </div>
            </form>

            @if($report)
                <div class="border-t border-gray-100 pt-6">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3 mb-4">
                        <h2 class="text-xl sm:text-2xl font-bold text-gray-800">Report #{{ $report->id }}</h2>
                        <span class="badge 
                            @if($report->status == 'pending') badge-pending
                            @elseif($report->status == 'verifying') badge-verifying
                            @elseif($report->status == 'responding') badge-responding
                            @elseif($report->status == 'resolved') badge-resolved
                            @else badge-rejected
                            @endif text-sm px-3 py-1">
                            {{ ucfirst($report->status) }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-3 mb-6">
                        <div class="flex flex-col sm:flex-row justify-between border-b pb-2">
                            <span class="text-gray-600 text-sm sm:text-base">Verification Status</span>
                            @if($report->verification_status == 'legit')
                                <span class="text-green-600 font-semibold flex items-center gap-1">✅ Legit</span>
                            @elseif($report->verification_status == 'scam')
                                <span class="text-red-600 font-semibold flex items-center gap-1">⚠️ Scam</span>
                            @else
                                <span class="text-gray-500">❓ Unverified</span>
                            @endif
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b pb-2">
                            <span class="text-gray-600 text-sm sm:text-base">Title</span>
                            <span class="text-gray-800 font-medium">{{ $report->title }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b pb-2">
                            <span class="text-gray-600 text-sm sm:text-base">Location</span>
                            <span class="text-gray-800">{{ $report->location }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row justify-between border-b pb-2">
                            <span class="text-gray-600 text-sm sm:text-base">Submitted</span>
                            <span class="text-gray-800">{{ $report->created_at->format('M d, Y \a\t h:i A') }}</span>
                        </div>
                        @if($report->responded_at)
                            <div class="flex flex-col sm:flex-row justify-between border-b pb-2">
                                <span class="text-gray-600 text-sm sm:text-base">Responded</span>
                                <span class="text-gray-800">{{ $report->responded_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                        @endif
                        @if($report->resolved_at)
                            <div class="flex flex-col sm:flex-row justify-between border-b pb-2">
                                <span class="text-gray-600 text-sm sm:text-base">Resolved</span>
                                <span class="text-gray-800">{{ $report->resolved_at->format('M d, Y \a\t h:i A') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-800 mb-2 text-sm sm:text-base">Recent Activity</h3>
                        <ul class="space-y-2 text-sm">
                            @forelse($report->updates->take(5) as $update)
                                <li class="flex flex-col sm:flex-row justify-between gap-1 sm:gap-0">
                                    <span class="text-gray-600 text-xs sm:text-sm">{{ $update->created_at->format('M d, H:i') }}</span>
                                    <span class="badge 
                                        @if($update->status == 'pending') badge-pending
                                        @elseif($update->status == 'verifying') badge-verifying
                                        @elseif($update->status == 'responding') badge-responding
                                        @elseif($update->status == 'resolved') badge-resolved
                                        @else badge-rejected
                                        @endif">
                                        {{ ucfirst($update->status) }}
                                    </span>
                                </li>
                            @empty
                                <li class="text-gray-500">No activity yet</li>
                            @endforelse
                        </ul>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('reports.show', $report) }}" class="inline-flex items-center text-red-600 hover:text-red-800 font-medium text-sm sm:text-base">
                            View Full Report Details
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            @elseif(request()->has('report_id'))
                <div class="alert alert-error mt-4">Report not found or you don't have permission to view it.</div>
            @else
                <div class="text-center py-12">
                    <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <p class="text-gray-500 text-base sm:text-lg">Enter a report ID to track its current status.</p>
                    <p class="text-gray-400 text-xs sm:text-sm mt-1">You can find your report ID on your My Reports page.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection