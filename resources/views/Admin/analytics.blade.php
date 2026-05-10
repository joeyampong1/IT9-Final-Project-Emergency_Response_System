@extends('layouts.app')

@section('title', 'Report Analytics')

@section('content')
        @include('layouts.page-header', ['title' => 'Report Analytics'])


<div class="container-custom mt-6">
    {{-- KPI Cards Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-8">
        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Total Reports</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Avg. Response Time</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">—</p>
                </div>
                <svg class="w-10 h-10 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Resolution Rate</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">—%</p>
                </div>
                <svg class="w-10 h-10 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm font-medium">Open Reports</p>
                    <p class="text-3xl font-bold mt-1 text-gray-800">{{ ($stats['pending'] ?? 0) + ($stats['verifying'] ?? 0) + ($stats['responding'] ?? 0) }}</p>
                </div>
                <svg class="w-10 h-10 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
        </div>
    </div>

    {{-- Main Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Reports by Type --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-red-600 h-1.5 w-full"></div>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                    <h3 class="text-md font-semibold text-gray-700">Reports by Type</h3>
                </div>
                @if(isset($stats['by_type']) && $stats['by_type']->count())
                    <div class="space-y-4">
                        @foreach($stats['by_type'] as $item)
                            @php
                                $percentage = $stats['total'] > 0 ? round(($item->count / $stats['total']) * 100) : 0;
                                $colorClass = match($item->type) {
                                    'accident' => 'bg-green-500',
                                    'fire' => 'bg-red-500',
                                    'crime' => 'bg-gray-700',
                                    default => 'bg-blue-500'
                                };
                            @endphp
                            <div>
                                <div class="flex justify-between items-center mb-1">
                                    <span class="capitalize text-gray-700 font-medium">{{ $item->type }}</span>
                                    <span class="text-sm font-semibold text-gray-800">{{ $item->count }} ({{ $percentage }}%)</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="{{ $colorClass }} h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No data available</p>
                @endif
            </div>
        </div>

        {{-- Reports by Verification Status --}}
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="bg-red-600 h-1.5 w-full"></div>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    <h3 class="text-md font-semibold text-gray-700">Verification Status</h3>
                </div>
                @if(isset($stats['by_verification']) && $stats['by_verification']->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($stats['by_verification'] as $item)
                            @php
                                $badgeClass = match($item->verification_status) {
                                    'legit' => 'bg-green-100 text-green-800',
                                    'scam' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                };
                            @endphp
                            <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 rounded-full 
                                        @if($item->verification_status == 'legit') bg-green-500
                                        @elseif($item->verification_status == 'scam') bg-red-500
                                        @else bg-gray-500 @endif">
                                    </div>
                                    <span class="capitalize text-gray-700">{{ $item->verification_status ?: 'Unverified' }}</span>
                                </div>
                                <span class="font-bold text-gray-800">{{ $item->count }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-8">No data available</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Status Distribution Bar (another row) --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
        <div class="bg-red-600 h-1.5 w-full"></div>
        <div class="p-5">
            <div class="flex items-center gap-2 mb-4">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h3 class="text-md font-semibold text-gray-700">Reports by Current Status</h3>
            </div>
            <div class="flex flex-wrap gap-3">
                @php
                    $statuses = [
                        'pending' => ['label' => 'Pending', 'color' => 'bg-yellow-500', 'count' => $stats['pending'] ?? 0],
                        'verifying' => ['label' => 'Verifying', 'color' => 'bg-blue-500', 'count' => $stats['verifying'] ?? 0],
                        'responding' => ['label' => 'Responding', 'color' => 'bg-purple-500', 'count' => $stats['responding'] ?? 0],
                        'resolved' => ['label' => 'Resolved', 'color' => 'bg-green-500', 'count' => $stats['resolved'] ?? 0],
                        'rejected' => ['label' => 'Rejected', 'color' => 'bg-red-500', 'count' => $stats['rejected'] ?? 0],
                    ];
                @endphp
                @foreach($statuses as $status)
                    <div class="flex-1 min-w-[100px] bg-gray-50 rounded-lg p-3 text-center">
                        <div class="text-xs font-medium text-gray-500 uppercase">{{ $status['label'] }}</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $status['count'] }}</div>
                        <div class="w-full bg-gray-200 rounded-full h-1.5 mt-2">
                            <div class="{{ $status['color'] }} h-1.5 rounded-full" style="width: {{ $stats['total'] > 0 ? ($status['count'] / $stats['total']) * 100 : 0 }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Export Button (optional) --}}
    <div class="flex justify-end">
        <a href="{{ route('admin.reports.export', ['format' => 'csv'] + request()->query()) }}" class="btn btn-secondary px-6 py-2 rounded-lg">
            Export Analytics
        </a>
    </div>
</div>
@endsection