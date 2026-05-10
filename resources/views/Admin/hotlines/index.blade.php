@extends('layouts.app')

@section('title', 'Manage Hotlines')

@section('content')
        @include('layouts.page-header', ['title' => 'Emergency Hotlines'])

<div class="container-custom px-4 mt-6">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-5 py-4 bg-gray-50 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <h2 class="text-lg font-semibold text-gray-800">Hotline Numbers</h2>
            <a href="{{ route('admin.hotlines.create') }}" class="btn btn-primary w-full sm:w-auto text-center">+ Add Hotline</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Number</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($hotlines as $hotline)
                        <tr>
                            <td class="px-4 py-4 text-sm text-gray-900">{{ $hotline->name }}</td>
                            <td class="px-4 py-4 text-sm font-mono text-gray-700">{{ $hotline->number }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $hotline->icon ?? '—' }}</td>
                            <td class="px-4 py-4 text-sm text-gray-700">{{ $hotline->sort_order }}</td>
                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('admin.hotlines.edit', $hotline) }}" class="text-blue-600 hover:text-blue-800 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                    </a>
                                    <form action="{{ route('admin.hotlines.destroy', $hotline) }}" method="POST" class="inline" onsubmit="return confirm('Delete this hotline?')">
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
        @if(count($hotlines) == 0)
            <div class="p-8 text-center text-gray-500">No hotlines found. Click "Add Hotline" to create one.</div>
        @endif
    </div>
</div>
@endsection