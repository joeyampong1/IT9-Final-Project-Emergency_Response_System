@extends('layouts.app')

@section('title', 'System Settings')

@section('content')
        @include('layouts.page-header', ['title' => 'System Settings'])

<div class="container-custom max-w-4xl mx-auto mt-6 space-y-6">
    <form action="{{ route('admin.settings.update') }}" method="POST" id="settingsForm">
        @csrf

        {{-- General Settings Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-colors duration-200">
            <div class="bg-red-600 h-1.5 w-full"></div>
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">General Settings</h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label class="form-label dark:text-gray-300">Site Name</label>
                        <input type="text" name="site_name" class="form-input rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" value="{{ $settings['site_name'] ?? config('app.name') }}">
                    </div>
                    <div class="form-group">
                        <label class="form-label dark:text-gray-300">Emergency Contact Email</label>
                        <input type="email" name="emergency_email" class="form-input rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" value="{{ $settings['emergency_email'] ?? '' }}">
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label class="form-label dark:text-gray-300">Default Map Zoom Level</label>
                        <input type="number" name="map_zoom" class="form-input rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" value="{{ $settings['map_zoom'] ?? 13 }}" min="1" max="20">
                    </div>
                    <div class="form-group">
                        <label class="form-label dark:text-gray-300">Map Style</label>
                        <select name="map_style" class="form-select rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                            <option value="street" {{ ($settings['map_style'] ?? 'street') == 'street' ? 'selected' : '' }}>Street</option>
                            <option value="satellite" {{ ($settings['map_style'] ?? 'street') == 'satellite' ? 'selected' : '' }}>Satellite</option>
                            <option value="terrain" {{ ($settings['map_style'] ?? 'street') == 'terrain' ? 'selected' : '' }}>Terrain</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <br>

        {{-- Appearance Card with Toggle Switch for Dark Mode --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-colors duration-200">
            <div class="bg-red-600 h-1.5 w-full"></div>
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path>
                </svg>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Appearance</h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <label class="form-label dark:text-gray-300 block">Dark Mode</label>
                        <p class="text-xs text-gray-500 dark:text-gray-400">Switch between light and dark theme</p>
                    </div>
                    <div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="dark_mode" value="0">
                            <input type="checkbox" name="dark_mode" class="sr-only peer" id="darkModeToggle" value="1" {{ ($settings['dark_mode'] ?? 0) == 1 ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                        </label>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label class="form-label dark:text-gray-300">Text Size</label>
                        <select name="font_size" class="form-select rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                            <option value="small" {{ ($settings['font_size'] ?? 'medium') == 'small' ? 'selected' : '' }}>Small</option>
                            <option value="medium" {{ ($settings['font_size'] ?? 'medium') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="large" {{ ($settings['font_size'] ?? 'medium') == 'large' ? 'selected' : '' }}>Large</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <br>
       {{-- Notifications & Performance Card with Toggle for Sound --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden transition-colors duration-200">
            <div class="bg-red-600 h-1.5 w-full"></div>
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Notifications & Performance</h2>
            </div>
            <div class="p-6 space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label class="form-label dark:text-gray-300">Auto‑Refresh Reports (seconds)</label>
                        <input type="number" name="refresh_interval" class="form-input rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600" value="{{ $settings['refresh_interval'] ?? 30 }}" min="10" max="300">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Set to 0 to disable auto‑refresh</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="form-label dark:text-gray-300 block">Notification Sound</label>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Play sound on new notifications</p>
                        </div>
                        <div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="notification_sound" value="0">
                                <input type="checkbox" name="notification_sound" class="sr-only peer" value="1" {{ ($settings['notification_sound'] ?? 1) == 1 ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label dark:text-gray-300">Default Timezone</label>
                    <select name="timezone" class="form-select rounded-lg dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600">
                        @foreach(timezone_identifiers_list() as $tz)
                            <option value="{{ $tz }}" {{ ($settings['timezone'] ?? 'Asia/Manila') == $tz ? 'selected' : '' }}>{{ $tz }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <br>

         {{-- Future settings cards can be added here following the same structure --}}
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary px-8 py-2.5 rounded-lg shadow-md hover:shadow-lg transition">Save All Settings</button>
        </div>
    </form>
</div>

<script>
    // Helper to update dark mode on the fly when the toggle is changed
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            if (this.checked) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        });
        // Initial state
        if (darkModeToggle.checked) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    }
</script>
@endsection