@extends('layouts.app')

@section('content')
<div class="container-custom max-w-7xl mx-auto px-4 py-6 sm:py-8">
    {{-- Header with user info – stacks on mobile --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 pb-4 border-b border-gray-200">
        <h1 class="page-title text-2xl sm:text-3xl font-bold text-gray-800">Dashboard</h1>
        <div class="text-left sm:text-right mt-2 sm:mt-0">
            <p class="text-gray-800 font-semibold">{{ auth()->user()->name }}</p>
            <p class="text-sm text-gray-500">{{ auth()->user()->email }}</p>
        </div>
    </div>

    <div class="w-full">
        <div class="card max-w-2xl mx-auto">
            <div class="card-header bg-red-600 text-white px-5 py-3 sm:px-6 sm:py-4 rounded-t-lg">
                <h2 class="text-lg sm:text-xl font-bold">{{ __('Dashboard') }}</h2>
            </div>
            <div class="card-body p-5 sm:p-6 bg-white rounded-b-lg shadow-md">
                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif
                <p class="text-sm sm:text-base">{{ __('You are logged in!') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection