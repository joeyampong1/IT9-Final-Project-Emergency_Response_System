@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
        @include('layouts.page-header', ['title' => 'Activity Logs'])

<div class="container-custom mt-6">
    {{-- Optional Filter Bar (you can expand later) --}}
    <div class="bg-white rounded-xl shadow-md p-4 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                <span class="text-gray-700 text-sm font-medium">Activity Feed</span>
            </div>
            <div class="text-sm text-gray-500">
                Showing latest {{ $logs->count() }} of {{ $logs->total() }} events
            </div>
        </div>
    </div>

    {{-- Timeline Cards --}}
    @forelse($logs as $log)
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-4 hover:shadow-lg transition duration-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between p-5 border-l-4 
                @if(str_contains($log->notes ?? '', 'status') || str_contains($log->status ?? '', 'status'))
                    border-yellow-500
                @elseif(str_contains($log->notes ?? '', 'assign'))
                    border-blue-500
                @elseif(str_contains($log->notes ?? '', 'note'))
                    border-green-500
                @else
                    border-red-500
                @endif
            ">
                <div class="flex-1">
                    <div class="flex items-center gap-2 mb-1 flex-wrap">
                        {{-- Action icon based on content --}}
                        @if(str_contains($log->notes ?? '', 'status') || str_contains($log->status ?? '', 'status'))
                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        @elseif(str_contains($log->notes ?? '', 'assign'))
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                            </svg>
                        @elseif(str_contains($log->notes ?? '', 'note'))
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                        <span class="text-sm font-medium text-gray-700">{{ $log->notes ?? 'Report status updated' }}</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs text-gray-500 mt-1">
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                            </svg>
                            Report #{{ $log->report_id }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ $log->user->name ?? 'System' }}
                        </span>
                        <span class="flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $log->created_at->format('M d, Y \a\t h:i A') }}
                        </span>
                    </div>
                </div>
                <div class="mt-3 sm:mt-0 text-left sm:text-right">
                    <span class="inline-flex items-center gap-1 text-xs text-gray-500 bg-gray-100 rounded-full px-3 py-1">
                        {{ $log->created_at->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>
    @empty
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
            <p class="text-gray-500 text-lg">No activity logs found.</p>
            <p class="text-gray-400 text-sm mt-1">Actions like status changes, assignments, or notes will appear here.</p>
        </div>
    @endforelse

    {{-- Pagination --}}
    @if($logs->hasPages())
        <div class="mt-8">
            {{ $logs->links() }}
        </div>
    @endif
</div>
@endsection