<!DOCTYPE html>
<html lang="en" class="{{ setting('dark_mode', 0) == 1 ? 'dark' : '' }} {{ setting('font_size', 'medium') }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ERS Admin')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 antialiased">
    {{-- Mobile menu toggle button --}}
    <button id="menuToggle" class="fixed top-4 left-4 z-50 p-2 rounded-md bg-red-600 text-white shadow-md md:hidden">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>

    <div id="menuOverlay" class="menu-overlay"></div>

    @auth
        @include('layouts.sidebar_header')
    @endauth

    <main @auth class="main-content transition-all duration-300" @endauth>
        @yield('content')
    </main>

    @stack('scripts')

    {{-- Logout Confirmation Modal (placed at the end of body to avoid stacking conflicts) --}}
    <div id="logoutModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-black/50 backdrop-blur-sm transition-all duration-200">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all scale-95">
            <div class="bg-red-600 h-1.5 w-full rounded-t-2xl"></div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 mx-auto bg-red-100 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-2">Confirm Logout</h3>
                <p class="text-gray-600 mb-6">Are you sure you want to log out?</p>
                <div class="flex gap-3">
                    <button id="cancelLogout" class="flex-1 btn btn-secondary rounded-lg py-2.5">Cancel</button>
                    <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full btn btn-primary rounded-lg py-2.5 bg-red-600 hover:bg-red-700">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle logic (unchanged)
        const menuToggle = document.getElementById('menuToggle');
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('menuOverlay');

        if (menuToggle && sidebar) {
            function toggleMenu(show) {
                if (show === undefined) {
                    sidebar.classList.toggle('open');
                } else if (show) {
                    sidebar.classList.add('open');
                } else {
                    sidebar.classList.remove('open');
                }
                if (overlay) {
                    overlay.classList.toggle('active', sidebar.classList.contains('open'));
                }
                document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
            }
            menuToggle.addEventListener('click', () => toggleMenu());
            if (overlay) {
                overlay.addEventListener('click', () => toggleMenu(false));
            }
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                    toggleMenu(false);
                }
            });
        }

        // Logout modal handling
        const logoutTrigger = document.getElementById('logoutTrigger');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');

        if (logoutTrigger && logoutModal) {
            logoutTrigger.addEventListener('click', function(e) {
                e.preventDefault();
                logoutModal.classList.remove('hidden');
                logoutModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            });

            cancelLogout.addEventListener('click', function() {
                logoutModal.classList.add('hidden');
                logoutModal.classList.remove('flex');
                document.body.style.overflow = '';
            });

            logoutModal.addEventListener('click', function(e) {
                if (e.target === logoutModal) {
                    logoutModal.classList.add('hidden');
                    logoutModal.classList.remove('flex');
                    document.body.style.overflow = '';
                }
            });
        }
    </script>
</body>
</html>