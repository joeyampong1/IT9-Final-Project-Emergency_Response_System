<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ setting('site_name', 'ERS') }} – Emergency Reporting System</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans antialiased blurred-bg"
      style="--bg-image: url('{{ asset('images/Landing_image.jpg') }}');">

    <div class="fixed inset-0 bg-black/60 z-0"></div>

    <div class="relative z-10 min-h-screen flex flex-col">
        <div class="flex-1 flex items-center justify-center px-4 sm:px-6 py-4 sm:py-8">
            <div class="w-full max-w-5xl mx-2 sm:mx-4">
                {{-- Quote – smaller text on mobile --}}
                <div class="text-center max-w-3xl mx-auto mb-8 sm:mb-12 animate-fade-in">
                    <p class="text-lg sm:text-xl md:text-2xl text-white/90 font-light italic drop-shadow">
                        "Your safety is our mission. Report emergencies instantly, help arrives faster."
                    </p>
                </div>

                {{-- Login/Register card – full width on mobile, max-w-md on larger --}}
                <div class="flex justify-center mb-10 sm:mb-12">
                    <div class="w-full max-w-md backdrop-blur-md bg-white/10 rounded-2xl shadow-2xl border border-white/20 p-5 sm:p-6 md:p-8 transition-all duration-300 hover:shadow-red-500/20">
                        <div class="flex justify-center mb-4 sm:mb-6">
                            <img src="{{ asset('images/ERS logo Login.png') }}" alt="ERS Logo" class="h-16 w-auto sm:h-20 rounded-lg">
                        </div>
                        <div class="text-center text-white/90 text-base sm:text-lg font-semibold mb-4 sm:mb-6">
                            Emergency Reporting Portal
                        </div>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="landing-btn-primary w-full block text-center py-2.5 sm:py-3 rounded-xl text-white font-bold transition transform hover:scale-[1.02]">Go to Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="landing-btn-primary w-full block text-center py-2.5 sm:py-3 rounded-xl text-white font-bold transition transform hover:scale-[1.02]">Log In</a>
                                <div class="mt-3 text-center text-white/70 text-sm">Don't have an account?</div>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="landing-btn-secondary w-full block text-center py-2.5 sm:py-3 mt-2 rounded-xl text-white font-bold transition">Register</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>

                {{-- Reminder cards – stack on mobile, side‑by‑side on tablet/desktop --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 sm:gap-6 mx-auto w-full">
                    <div class="reminder-card p-4 sm:p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            <h3 class="font-bold text-white text-base sm:text-lg">Stay Calm & Safe</h3>
                        </div>
                        <p class="text-white/80 text-xs sm:text-sm">Provide clear location and nature of emergency. Do not hang up until told to do so.</p>
                    </div>
                    <div class="reminder-card p-4 sm:p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                            <h3 class="font-bold text-white text-base sm:text-lg">Secure Your Location</h3>
                        </div>
                        <p class="text-white/80 text-xs sm:text-sm">Enable GPS or drop a pin on the map. Accurate location saves critical minutes.</p>
                    </div>
                    <div class="reminder-card p-4 sm:p-5">
                        <div class="flex items-center gap-3 mb-2">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            <h3 class="font-bold text-white text-base sm:text-lg">Attach Evidence</h3>
                        </div>
                        <p class="text-white/80 text-xs sm:text-sm">Upload photos or videos to help responders assess the situation before arrival.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-4 text-center text-white/60 text-xs">
            Emergency Response System – 24/7 Emergency Response | IT9 Final Project
        </div>
    </div>
</body>
</html>