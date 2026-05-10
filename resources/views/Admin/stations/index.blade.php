@extends('layouts.app')

@section('title', 'Stations')

@section('content')
@include('layouts.page-header', ['title' => 'Station Management'])

<div class="container-custom px-4 mt-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Filter Card --}}
    <div class="bg-white rounded-xl shadow-md overflow-hidden mb-6">
        <div class="px-5 py-4 bg-gray-50 border-b border-gray-100 flex flex-wrap items-center justify-between gap-2">
            <h2 class="text-lg font-semibold text-gray-800 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
                Filter Stations
            </h2>
            <a href="{{ route('admin.stations.create') }}" class="btn btn-primary w-full sm:w-auto text-center">+ New Station</a>
        </div>
        <div class="p-5">
            <form method="GET" action="{{ route('admin.stations.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="form-select rounded-lg" onchange="this.form.submit()">
                        <option value="">All</option>
                        <option value="fire" {{ request('type') == 'fire' ? 'selected' : '' }}>Fire Station</option>
                        <option value="police" {{ request('type') == 'police' ? 'selected' : '' }}>Police Station</option>
                        <option value="medical" {{ request('type') == 'medical' ? 'selected' : '' }}>Medical / Hospital</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or address..." class="form-input rounded-lg">
                </div>
                <div class="flex items-end space-x-2">
                    <button type="submit" class="btn btn-primary w-full">Filter</button>
                    <a href="{{ route('admin.stations.index') }}" class="btn btn-secondary w-full text-center">Reset</a>
                </div>
            </form>
        </div>
    </div>

    @if($stations->count())
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($stations as $station)
                            <tr>
                                <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $station->id }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $station->name }}</td>
                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="badge badge-{{ $station->type }}">{{ ucfirst($station->type) }}</span>
                                </td>
                                <td class="px-4 py-4 text-sm text-gray-700 max-w-xs truncate">{{ $station->address ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $station->phone ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-700">{{ $station->email ?? '—' }}</td>
                                <td class="px-4 py-4 whitespace-nowrap text-sm">
                                    <div class="flex items-center space-x-3">
                                        <a href="{{ route('admin.stations.edit', $station) }}" class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.stations.destroy', $station) }}" method="POST" class="inline" onsubmit="return confirm('Delete this station?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                {{ $stations->links() }}
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-md p-12 text-center">
            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <p class="text-gray-600 mb-4">No stations found.</p>
            <a href="{{ route('admin.stations.create') }}" class="btn btn-primary inline-block">Create your first station</a>
        </div>
    @endif
</div>
@endsection