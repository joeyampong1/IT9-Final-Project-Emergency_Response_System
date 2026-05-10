@extends('layouts.app')

@section('title', 'My Reports')

@section('content')
{{-- Use only the page-header, which already contains the sticky behavior --}}
@include('layouts.page-header', ['title' => 'My Reports'])

<div class="container-custom mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Card --}}
    <div class="bg-white rounded-lg shadow p-4 mb-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-4 gap-3">
            <h2 class="text-lg font-semibold text-gray-700">Filter Reports</h2>
            <a href="{{ route('reports.create') }}" class="btn btn-primary w-full sm:w-auto text-center">+ New Report</a>
        </div>

        <form method="GET" action="{{ route('reports.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="form-select w-full" onchange="this.form.submit()">
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
                <select name="type" class="form-select w-full" onchange="this.form.submit()">
                    <option value="">All</option>
                    <option value="accident" {{ request('type') == 'accident' ? 'selected' : '' }}>Medical</option>
                    <option value="fire" {{ request('type') == 'fire' ? 'selected' : '' }}>Fire</option>
                    <option value="crime" {{ request('type') == 'crime' ? 'selected' : '' }}>Crime</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Title, description, location..." class="form-input w-full">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="btn btn-primary w-full">Filter</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary w-full text-center">Reset</a>
            </div>
        </form>
    </div>

    @if($reports->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($reports as $report)
               @php
                $firstImage = $report->attachments->firstWhere('file_type', 'image');
                $bgImage = $firstImage ? asset('storage/' . $firstImage->file_path) : null;
            @endphp
            <div class="relative rounded-lg shadow-md ... {{ $bgImage ? 'bg-cover bg-center' : 'bg-gradient-to-br from-gray-800 to-gray-900' }}"
                @if($bgImage) style="background-image: url('{{ $bgImage }}');" @endif>
                    
                    <div class="absolute inset-0 bg-black/60 backdrop-blur-[1px]"></div>
                    
                    <div class="relative z-10 flex flex-col h-full">
                        <div class="px-5 pt-4 pb-2 border-b border-white/20 flex justify-between items-center">
                            <span class="text-sm font-medium text-white/80">#{{ $report->id }}</span>
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

                        <div class="p-5 flex-1">
                            <div class="flex items-center gap-2 mb-3">
                                <span class="inline-block w-2 h-2 rounded-full 
                                    @if($report->type == 'accident') bg-green-400
                                    @elseif($report->type == 'fire') bg-red-400
                                    @else bg-gray-400
                                    @endif"></span>
                                <span class="text-sm font-semibold text-white/80 uppercase tracking-wide">
                                    {{ $report->type == 'accident' ? 'Medical' : ucfirst($report->type) }}
                                </span>
                            </div>

                            <h3 class="text-base sm:text-lg font-bold text-white mb-2 line-clamp-2">{{ $report->title }}</h3>
                            <p class="text-white/80 text-sm mb-3 line-clamp-3">{{ $report->description }}</p>

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
                        </div>

                        <div class="px-5 py-3 bg-black/30 rounded-b-lg">
                            <a href="{{ route('reports.show', $report) }}" class="btn btn-primary w-full text-center block bg-white/20 hover:bg-white/30 text-white border border-white/30 transition text-sm py-2">
                                View Report
                            </a>
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
            <a href="{{ route('reports.create') }}" class="btn btn-primary inline-block">Create your first report</a>
        </div>
    @endif
</div>
@endsection