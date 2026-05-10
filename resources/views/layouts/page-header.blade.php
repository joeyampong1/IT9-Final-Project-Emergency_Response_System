<div class="sticky top-0 z-40 bg-gray-100 dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800 shadow-md py-3 mb-6">
    <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between min-h-[64px]">
            <div class="flex items-center">
                <h1 class="text-xl md:text-2xl font-bold text-gray-800 dark:text-white ml-12 md:ml-0 transition-all">
                    {{ $title }}
                </h1>
            </div>

            <div class="flex items-center space-x-3">
                <div class="hidden sm:block text-right">
                    <p class="text-sm font-semibold text-gray-800 dark:text-white leading-none">
                        {{ auth()->user()->name }}
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                <!-- Clickable avatar leading to My Account -->
                <a href="{{ route('profile.edit') }}" class="block cursor-pointer">
                    <div class="w-10 h-10 rounded-full bg-red-600 flex items-center justify-center text-white shadow-sm ring-2 ring-white dark:ring-gray-800 hover:bg-red-700 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>