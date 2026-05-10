@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    @include('layouts.page-header', ['title' => 'Admin Dashboard'])

<div class="container-custom">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

       {{-- ========== SECTION: REPORT STATUS ========== --}}
        <div class="mb-3">
            <div class="flex items-center gap-2 border-b border-gray-200 pb-2">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                <h2 class="text-xl font-bold text-gray-800">Report Status Overview</h2>
            </div>
            <p class="text-xs text-gray-400 mt-1">Total reports by current progress stage</p>
        </div>

        {{-- Stats Cards – soft neutral with coloured numbers & red icon --}}
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-5 mb-8">
            {{-- Total --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Total Reports</p>
                        <p class="text-3xl font-bold mt-1 text-gray-800">{{ $stats['total'] }}</p>
                    </div>
                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>

            {{-- Pending --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Pending</p>
                        <p class="text-3xl font-bold mt-1 text-yellow-600">{{ $stats['pending'] }}</p>
                    </div>
                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Verifying --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Verifying</p>
                        <p class="text-3xl font-bold mt-1 text-blue-600">{{ $stats['verifying'] }}</p>
                    </div>
                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
            </div>

            {{-- Responding --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Responding</p>
                        <p class="text-3xl font-bold mt-1 text-purple-600">{{ $stats['responding'] }}</p>
                    </div>
                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Resolved --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Resolved</p>
                        <p class="text-3xl font-bold mt-1 text-green-600">{{ $stats['resolved'] }}</p>
                    </div>
                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Rejected --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Rejected</p>
                        <p class="text-3xl font-bold mt-1 text-red-500">{{ $stats['rejected'] }}</p>
                    </div>
                    <svg class="w-10 h-10 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        {{-- ========== SECTION: VERIFICATION OVERVIEW ========== --}}
        <div class="mb-3 mt-6">
            <div class="flex items-center gap-2 border-b border-gray-200 pb-2">
                <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <h2 class="text-xl font-bold text-gray-800">Verification Overview</h2>
            </div>
            <p class="text-xs text-gray-400 mt-1">Reports classified by verification status</p>
        </div>

        {{-- Verification Stats Cards – white cards with coloured left border & number --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            {{-- Unverified --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-gray-400 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Unverified</p>
                        <p class="text-3xl font-bold mt-1 text-gray-700">{{ $stats['unverified'] ?? 0 }}</p>
                    </div>
                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Legit --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-green-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Legit</p>
                        <p class="text-3xl font-bold mt-1 text-green-600">{{ $stats['legit'] ?? 0 }}</p>
                    </div>
                    <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>

            {{-- Scam --}}
            <div class="bg-white rounded-xl shadow-md p-4 border-l-4 border-red-500 hover:shadow-lg transition duration-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Scam</p>
                        <p class="text-3xl font-bold mt-1 text-red-600">{{ $stats['scam'] ?? 0 }}</p>
                    </div>
                    <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>


    {{-- Filter Card with Verification Filter --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6 border border-gray-100">
        <div class="px-5 py-4 bg-gray-50 border-b border-gray-100 flex flex-wrap items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center">
                <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filter Reports
            </h2>
            <div class="flex space-x-2 mt-2 sm:mt-0">
                <div class="relative inline-block text-left">
                    <button id="exportDropdownButton" type="button" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-red-500">
                        Export
                        <svg class="ml-2 -mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                    <div id="exportDropdownMenu" class="absolute right-0 mt-2 w-36 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-10">
                        <div class="py-1">
                            <a href="{{ route('admin.reports.export', ['format' => 'csv'] + request()->query()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">CSV</a>
                            @if(class_exists(\Barryvdh\DomPDF\Facade\Pdf::class))
                                <a href="{{ route('admin.reports.export', ['format' => 'pdf'] + request()->query()) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">PDF</a>
                            @endif
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium transition {{ !request()->has('show_resolved') ? 'bg-red-600 text-white shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    Active Reports
                </a>
                <a href="{{ route('admin.dashboard', ['show_resolved' => 1]) }}" class="px-4 py-2 rounded-md text-sm font-medium transition {{ request()->has('show_resolved') ? 'bg-red-600 text-white shadow-sm' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                    History
                </a>
            </div>
        </div>

        <div class="p-5">
            <form method="GET" action="{{ route('admin.dashboard') }}" id="filterForm">
                @if(request()->has('show_resolved'))
                    <input type="hidden" name="show_resolved" value="1">
                @endif
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="form-select w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="verifying" {{ request('status') == 'verifying' ? 'selected' : '' }}>Verifying</option>
                            <option value="responding" {{ request('status') == 'responding' ? 'selected' : '' }}>Responding</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" class="form-select w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="accident" {{ request('type') == 'accident' ? 'selected' : '' }}>Accident</option>
                            <option value="fire" {{ request('type') == 'fire' ? 'selected' : '' }}>Fire</option>
                            <option value="crime" {{ request('type') == 'crime' ? 'selected' : '' }}>Crime</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Verification</label>
                        <select name="verification" class="form-select w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500" onchange="this.form.submit()">
                            <option value="">All</option>
                            <option value="unverified" {{ request('verification') == 'unverified' ? 'selected' : '' }}>Unverified</option>
                            <option value="legit" {{ request('verification') == 'legit' ? 'selected' : '' }}>Legit ✅</option>
                            <option value="scam" {{ request('verification') == 'scam' ? 'selected' : '' }}>Scam ⚠️</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, description, location..." class="form-input w-full rounded-lg border-gray-300 focus:ring-red-500 focus:border-red-500">
                    </div>
                    <div class="flex items-end space-x-2">
                        <button type="submit" class="btn btn-primary w-full md:w-auto px-6 py-2">Apply</button>
                        <a href="{{ request()->has('show_resolved') ? route('admin.dashboard', ['show_resolved' => 1]) : route('admin.dashboard') }}" class="btn btn-secondary w-full md:w-auto px-6 py-2 text-center">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modern Card Grid for Reports with Verification Badge --}}
    @if($reports->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($reports as $report)
               @php
                    $firstImage = $report->attachments->firstWhere('file_type', 'image');
                    $bgImage = $firstImage ? asset('storage/' . $firstImage->file_path) : null;

                @endphp
                <div class="relative rounded-xl shadow-md hover:shadow-xl transition-all duration-200 flex flex-col overflow-hidden
                        {{ $bgImage ? 'bg-cover bg-center' : 'bg-gradient-to-br from-gray-800 to-gray-900' }}"
                    @if($bgImage) style="background-image: url('{{ $bgImage }}');" @endif>
                    
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-[1px]"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        {{-- Header: ID, Verification Badge, and Status Badge --}}
                        <div class="px-5 pt-5 pb-2 border-b border-white/20 flex justify-between items-center">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-sm font-medium text-white/80">#{{ $report->id }}</span>
                                @if(in_array($report->id, $unreadReportIds))
                                    <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">NEW</span>
                                @endif
                                @if($report->verification_status == 'legit')
                                    <span class="bg-green-600/80 text-white text-xs px-2 py-0.5 rounded-full">✅ Legit</span>
                                @elseif($report->verification_status == 'scam')
                                    <span class="bg-red-600/80 text-white text-xs px-2 py-0.5 rounded-full">⚠️ Scam</span>
                                @else
                                    <span class="bg-gray-600/80 text-white text-xs px-2 py-0.5 rounded-full">❓ Unverified</span>
                                @endif
                            </div>
                            <span class="badge 
                                @if($report->status == 'pending') badge-pending
                                @elseif($report->status == 'verifying') badge-verifying
                                @elseif($report->status == 'responding') badge-responding
                                @elseif($report->status == 'resolved') badge-resolved
                                @else badge-rejected
                                @endif">
                                {{ ucfirst($report->status) }}
                            </span>
                        </div>

                        {{-- Body (unchanged) --}}
                        <div class="p-5 flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="inline-block w-2 h-2 rounded-full 
                                    @if($report->type == 'accident') bg-green-400
                                    @elseif($report->type == 'fire') bg-red-400
                                    @else bg-gray-400
                                    @endif"></span>
                                <span class="text-sm font-semibold text-white/80 uppercase tracking-wide">
                                    {{ ucfirst($report->type) }}
                                </span>
                            </div>

                            <h3 class="text-lg font-bold text-white mb-2 line-clamp-2">{{ $report->title }}</h3>
                            <p class="text-white/80 text-sm mb-3 line-clamp-3">{{ $report->description }}</p>

                            <div class="flex items-center text-sm text-white/70 mb-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span class="truncate">{{ $report->reporter->name ?? 'Unknown' }}</span>
                            </div>

                            <div class="flex items-center text-sm text-white/70 mb-1">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="truncate">{{ $report->location }}</span>
                            </div>

                            <div class="flex items-center text-sm text-white/70">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $report->created_at->format('M d, Y') }}</span>
                            </div>

                            @if($report->station)
                                <div class="mt-3 text-sm text-white/70">
                                    <strong>Station:</strong> 
                                    <a href="javascript:void(0)" onclick="showStationModal(
                                        '{{ $report->station->id }}',
                                        '{{ addslashes($report->station->name) }}',
                                        '{{ $report->station->type }}',
                                        '{{ addslashes($report->station->address) }}',
                                        '{{ $report->station->phone }}',
                                        '{{ addslashes($report->station->email) }}',
                                        '{{ $report->station->latitude }}',
                                        '{{ $report->station->longitude }}',
                                        {{ $report->id }}
                                    )" class="text-blue-300 hover:text-blue-100 underline">
                                        {{ $report->station->name }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        {{-- Footer with Actions --}}
                        <div class="px-5 py-4 bg-black/30 rounded-b-xl flex justify-between items-center">
                            <a href="{{ route('admin.reports.show', ['report' => $report, 'return_url' => request()->fullUrl()]) }}" 
                                class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                                    View Report
                                </a>
                            @if($report->status != 'resolved')
                                <form action="{{ route('admin.reports.update', $report) }}" method="POST" class="inline">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="status" value="resolved">
                                    <input type="hidden" name="notes" value="Archived from dashboard">
                                    <button type="submit" onclick="return confirm('Archive this report? It will be moved to History.')" class="text-red-300 hover:text-red-100" title="Archive">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-8">
            {{ $reports->links() }}
        </div>
    @else
        <div class="card p-8 text-center">
            <p class="text-gray-600 mb-4">No reports found.</p>
        </div>
    @endif

    {{-- Station Modal (unchanged) --}}
    <div id="stationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold">Station Details</h3>
                <button type="button" onclick="closeModal()" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div id="modalContent"></div>
        </div>
    </div>

    <script>
        function showStationModal(stationId, stationName, stationType, stationAddress, stationPhone, stationEmail, stationLat, stationLng, reportId) {
            const modal = document.getElementById('stationModal');
            const content = document.getElementById('modalContent');
            content.innerHTML = `
                <div class="space-y-2">
                    <p><strong>Name:</strong> ${stationName}</p>
                    <p><strong>Type:</strong> ${stationType.charAt(0).toUpperCase() + stationType.slice(1)}</p>
                    <p><strong>Address:</strong> ${stationAddress || '—'}</p>
                    <p><strong>Phone:</strong> ${stationPhone || '—'}</p>
                    <p><strong>Email:</strong> ${stationEmail || '—'}</p>
                    <p><strong>Coordinates:</strong> ${stationLat}, ${stationLng}</p>
                    <button onclick="sendStationAlert(${stationId}, ${reportId})" class="btn btn-primary w-full mt-2">Send Alert</button>
                </div>
            `;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function sendStationAlert(stationId, reportId) {
            if (!confirm('Send alert to this station?')) return;
            fetch(`/admin/stations/${stationId}/send-alert/${reportId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({})
            })
            .then(response => response.ok ? response.json() : Promise.reject())
            .then(data => { alert(data.message); closeModal(); })
            .catch(() => alert('Error sending alert.'));
        }

        function closeModal() {
            const modal = document.getElementById('stationModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        document.getElementById('stationModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });

        (function() {
            const button = document.getElementById('exportDropdownButton');
            const menu = document.getElementById('exportDropdownMenu');
            if (button && menu) {
                button.addEventListener('click', (e) => { e.stopPropagation(); menu.classList.toggle('hidden'); });
                document.addEventListener('click', () => menu.classList.add('hidden'));
            }
        })();
    </script>
@endsection