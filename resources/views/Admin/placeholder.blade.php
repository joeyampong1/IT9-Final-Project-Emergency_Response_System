@extends('layouts.app')

@section('title', $page ?? 'Admin Page')

@section('content')
        @include('layouts.page-header', ['title' => $page ?? 'Admin Page'])

<div class="container-custom mt-12">
    <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition-all duration-300 hover:shadow-xl">
        <div class="bg-gradient-to-r from-red-500 to-red-600 h-2 w-full"></div>
        <div class="p-8 md:p-12 text-center">
            <div class="w-28 h-28 mx-auto bg-red-50 rounded-full flex items-center justify-center mb-6">
                <svg class="w-14 h-14 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-3">{{ $page ?? 'Admin' }} Page</h2>
            <div class="w-24 h-1 bg-red-500 mx-auto mb-6 rounded-full"></div>
            <p class="text-gray-600 text-lg mb-4">We're working hard to bring you this feature.</p>
            <p class="text-gray-400 text-sm">This page is currently under construction. Please check back later.</p>
            <div class="mt-8 inline-flex items-center gap-2 text-sm text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Coming soon
            </div>
        </div>
    </div>
</div>
@endsection