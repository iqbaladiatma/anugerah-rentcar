<div x-data="{ 
        sidebarOpen: @entangle('sidebarOpen'),
        isDesktop: window.innerWidth >= 1024
    }" 
    x-init="
        // Watch for window resize
        window.addEventListener('resize', () => {
            isDesktop = window.innerWidth >= 1024;
        });
    "
    @toggle-customer-sidebar.window="sidebarOpen = !sidebarOpen">
    
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen && !isDesktop" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-gray-900/80 lg:hidden"
         @click="sidebarOpen = false">
    </div>

    <!-- Sidebar -->
    <div x-show="sidebarOpen"
         x-transition:enter="transition-transform ease-out duration-200"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform ease-in duration-200"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 z-50 flex w-72 flex-col bg-white shadow-2xl lg:hidden"
         style="display: none;">
        
        <!-- Sidebar content -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto px-6 pb-4">
            <!-- Header -->
            <div class="flex h-16 shrink-0 items-center justify-between border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gradient-to-r from-blue-600 to-blue-700">
                        <svg class="h-6 w-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Anugerah Rentcar</h1>
                        <p class="text-xs text-gray-500">Portal Pelanggan</p>
                    </div>
                </div>
                <button @click="sidebarOpen = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <!-- User Info -->
            <div class="flex items-center gap-x-4 px-4 py-3 bg-gradient-to-r from-blue-50 to-blue-100 rounded-lg">
                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-600">
                    <span class="text-lg font-medium text-white">
                        {{ substr(auth('customer')->user()->name, 0, 1) }}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-gray-900 truncate">
                        {{ auth('customer')->user()->name }}
                    </p>
                    <p class="text-xs text-gray-600">
                        {{ auth('customer')->user()->email }}
                    </p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-2">
                    @foreach($menuItems as $item)
                        <li>
                            <a href="{{ route($item['route']) }}" 
                               wire:navigate
                               class="group flex gap-x-3 rounded-lg p-3 text-sm font-medium leading-6 text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors {{ request()->routeIs($item['route'] . '*') ? 'bg-blue-50 text-blue-600' : '' }}">
                                @if($item['icon'] === 'home')
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                @elseif($item['icon'] === 'clipboard')
                                    <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                @elseif($item['icon'] === 'car')
                                    <svg class="h-6 w-6 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                    </svg>
                                @endif
                                {{ $item['name'] }}
                            </a>
                        </li>
                    @endforeach

                    <!-- Logout -->
                    <li class="mt-auto pt-4 border-t border-gray-200">
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit" class="group flex w-full gap-x-3 rounded-lg p-3 text-sm font-medium leading-6 text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="h-6 w-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>
