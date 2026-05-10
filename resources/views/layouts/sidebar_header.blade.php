<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ auth()->check() && auth()->user()->role == 'admin' ? route('admin.dashboard') : route('reports.index') }}" class="inline-block">
            <img src="{{ asset('images/ERS logo sidebar_final.png') }}" alt="ERS Logo" class="cursor-pointer hover:opacity-80 transition">
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto px-2">
        <ul class="space-y-1">
            @auth
                @if(auth()->user()->role == 'admin')
                    @php
                        $unreadCount = \App\Models\Notification::where('user_id', auth()->id())
                            ->whereNull('read_at')
                            ->count();
                    @endphp
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <span>Dashboard</span>
                            @if($unreadCount > 0)
                                <span class="ml-auto bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5 shadow-sm">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="sidebar-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Account
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.users.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Users
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.stations.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.stations.*') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Stations
                        </a>
                    </li>

                    <!-- Notifications (admin) -->
                    <li>
                        <a href="{{ route('admin.notifications') }}" class="sidebar-nav-item {{ request()->routeIs('admin.notifications') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            <span>Notifications</span>
                            @if($unreadCount > 0)
                                <span class="ml-auto bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5 shadow-sm">{{ $unreadCount }}</span>
                            @endif
                        </a>
                    </li>

                    <!-- Report Analytics -->
                    <li>
                        <a href="{{ route('admin.analytics') }}" class="sidebar-nav-item {{ request()->routeIs('admin.analytics') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Report Analytics
                        </a>
                    </li>

                    <!-- Activity Logs -->
                    <li>
                        <a href="{{ route('admin.activity-logs') }}" class="sidebar-nav-item {{ request()->routeIs('admin.activity-logs') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Activity Logs
                        </a>
                    </li>

                    <!-- Emergency Hotlines (Admin CRUD) -->
                    <li>
                        <a href="{{ route('admin.hotlines.index') }}" class="sidebar-nav-item {{ request()->routeIs('admin.hotlines.*') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Emergency Hotlines
                        </a>
                    </li>

                    <!-- System Settings -->
                    <li>
                        <a href="{{ route('admin.settings') }}" class="sidebar-nav-item {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            System Settings
                        </a>
                    </li>
                @else
                    <!-- Citizen menu items -->
                    <li>
                        <a href="{{ route('reports.index') }}" class="sidebar-nav-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            My Reports
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports.create') }}" class="sidebar-nav-item {{ request()->routeIs('reports.create') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            New Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('profile.edit') }}" class="sidebar-nav-item {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Account
                        </a>
                    </li>
                    @php
                        $citizenUnreadCount = \App\Models\Notification::where('user_id', auth()->id())->unread()->count();
                    @endphp
                    <li>
                        <a href="{{ route('citizen.notifications') }}" class="sidebar-nav-item {{ request()->routeIs('citizen.notifications') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                            </svg>
                            Notifications
                            @if($citizenUnreadCount > 0)
                                <span class="ml-auto bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5 shadow-sm">{{ $citizenUnreadCount }}</span>
                            @endif
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('citizen.hotlines') }}" class="sidebar-nav-item {{ request()->routeIs('citizen.hotlines') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Emergency Hotline
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('citizen.tracker') }}" class="sidebar-nav-item {{ request()->routeIs('citizen.tracker') ? 'active' : '' }}">
                            <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                            Report Status Tracker
                        </a>
                    </li>
                @endif

                <div class="flex-1"></div>

                <!-- Logout button -->
                <li class="pt-4 mt-2 border-t border-gray-700">
                    <button type="button" id="logoutTrigger" class="sidebar-logout w-full">
                        <svg class="sidebar-nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </li>
            @endauth

            @guest
                <li><a href="{{ route('login') }}" class="sidebar-nav-item">Login</a></li>
                <li><a href="{{ route('register') }}" class="sidebar-nav-item">Register</a></li>
            @endguest
        </ul>
    </nav>
</aside>