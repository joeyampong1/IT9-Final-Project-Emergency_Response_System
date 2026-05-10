@extends('layouts.app')

@section('title', 'Emergency Hotlines')

@section('content')
        @include('layouts.page-header', ['title' => 'Emergency Hotlines'])

<div class="container-custom max-w-5xl mx-auto px-4 mt-6">
    <div class="grid grid-cols-1 gap-4">
        @php
            $hotlines = [
                ['name' => 'Philippine National Police (PNP)', 'number' => '117', 'icon' => 'police', 'bg' => 'from-blue-600 to-blue-700'],
                ['name' => 'Bureau of Fire Protection (BFP)', 'number' => '160', 'icon' => 'fire', 'bg' => 'from-orange-600 to-orange-700'],
                ['name' => 'National Emergency Hotline 911', 'number' => '911', 'icon' => 'emergency', 'bg' => 'from-red-600 to-red-700'],
                ['name' => 'Red Cross Philippines', 'number' => '143', 'icon' => 'medical', 'bg' => 'from-red-500 to-red-600'],
                ['name' => 'Philippine Coast Guard', 'number' => '117', 'icon' => 'coast', 'bg' => 'from-blue-700 to-blue-800'],
            ];
        @endphp

        @foreach($hotlines as $hotline)
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300">
                <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-gradient-to-br {{ $hotline['bg'] }} flex items-center justify-center text-white shadow-md flex-shrink-0">
                            @if($hotline['icon'] == 'police')
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                </svg>
                            @elseif($hotline['icon'] == 'fire')
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012 15.5a2.986 2.986 0 00-2.121.621z"></path>
                                </svg>
                            @elseif($hotline['icon'] == 'medical')
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-800 text-base sm:text-lg">{{ $hotline['name'] }}</h3>
                            <p class="text-xl sm:text-2xl font-bold text-red-600">{{ $hotline['number'] }}</p>
                        </div>
                    </div>
                    <a href="tel:{{ $hotline['number'] }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 sm:px-5 rounded-lg text-sm font-medium transition flex items-center justify-center gap-2 shadow-md w-full sm:w-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        Call Now
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-8 bg-red-50 rounded-xl p-4 sm:p-5 border border-red-100">
        <div class="flex gap-3">
            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-xs sm:text-sm text-gray-700">In case of emergency, always call the nearest hotline first. Stay calm and provide accurate information to the dispatcher.</p>
        </div>
    </div>
</div>
@endsection