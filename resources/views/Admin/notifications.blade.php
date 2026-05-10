@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
        @include('layouts.page-header', ['title' => 'Notifications'])

<div class="container-custom mt-6">
    {{-- Optional summary bar --}}
    <div class="bg-white rounded-xl shadow-md p-4 mb-6 flex flex-wrap items-center justify-between">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="text-gray-700 text-sm">All notifications</span>
        </div>
        <div class="text-xs text-gray-500">
            {{ $notifications->total() }} total · {{ $notifications->count() }} shown
        </div>
    </div>

    @if($notifications->count())
        <div class="space-y-4">
            @foreach($notifications as $notification)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                    <div class="flex">
                        {{-- Left coloured strip for unread --}}
                        <div class="w-1.5 {{ $notification->read_at ? 'bg-gray-300' : 'bg-red-500' }}"></div>

                        {{-- Main content --}}
                        <div class="flex-1 p-5">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                                <div class="flex items-center gap-3">
                                    {{-- Icon based on notification type --}}
                                    <div class="w-8 h-8 rounded-full 
                                        @if($notification->type == 'new_report') bg-red-100 text-red-600
                                        @elseif($notification->type == 'status_update') bg-blue-100 text-blue-600
                                        @else bg-gray-100 text-gray-600 @endif
                                        flex items-center justify-center">
                                        @if($notification->type == 'new_report')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                            </svg>
                                        @elseif($notification->type == 'status_update')
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-gray-800 font-medium">{{ $notification->content }}</p>
                                        <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500 mt-1">
                                            <span class="flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                {{ $notification->created_at->format('M d, Y \a\t h:i A') }}
                                            </span>
                                            <span>{{ $notification->created_at->diffForHumans() }}</span>
                                            @if($notification->report_id)
                                                <span class="flex items-center gap-1">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                                    </svg>
                                                    Report #{{ $notification->report_id }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Action link (if report related) --}}
                                @if($notification->report_id)
                                    <a href="{{ route('admin.reports.show', $notification->report_id) }}" 
                                       class="inline-flex items-center gap-1 text-red-600 hover:text-red-800 text-sm font-medium whitespace-nowrap">
                                        View Report
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-8">
                {{ $notifications->links() }}
            </div>
        @endif
    @else
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg class="w-20 h-20 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <p class="text-gray-600 text-lg">No notifications yet</p>
            <p class="text-gray-400 text-sm mt-1">When you receive updates, they will appear here.</p>
        </div>
    @endif
</div>
@endsection