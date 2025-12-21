<div x-data="{ 
        sidebarOpen: false,
        isDesktop: window.innerWidth >= 1024
    }" 
    x-init="
        // Watch for window resize
        window.addEventListener('resize', () => {
            isDesktop = window.innerWidth >= 1024;
            if (isDesktop) sidebarOpen = false;
        });
    "
    @toggle-sidebar.window="sidebarOpen = !sidebarOpen">
    
    @php
        $settings = \App\Models\Setting::current();
    @endphp
    
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen && !isDesktop" 
         x-transition:enter="transition-opacity ease-linear duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 bg-gray-900/80 lg:hidden"
         @click="sidebarOpen = false"
         style="display: none;">
    </div>

    <!-- Sidebar -->
    <div x-show="isDesktop || sidebarOpen"
         x-transition:enter="transition-transform ease-out duration-200 lg:transition-none"
         x-transition:enter-start="-translate-x-full lg:translate-x-0"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform ease-in duration-200 lg:transition-none"
         x-transition:leave-start="translate-x-0 lg:translate-x-0"
         x-transition:leave-end="-translate-x-full lg:translate-x-0"
         class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col lg:z-auto"
         :class="{ 'lg:translate-x-0': true }"
         style="display: none;">
        
        <!-- Sidebar content -->
        <div class="flex flex-col bg-white px-6 shadow-xl lg:shadow-none border-r border-gray-200 overflow-hidden h-full">
            <!-- Logo -->
            <div class="flex h-16 shrink-0 items-center py-4">
                <div class="flex items-center space-x-3 min-w-0">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-black p-1 overflow-hidden">
                        <img src="{{ asset('ini.jpg') }}" alt="Anugerah Rentcar Logo" class="h-full w-full object-contain">
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-lg font-semibold text-gray-900 truncate">{{ $settings->company_name ?? 'Anugerah Rentcar' }}</h1>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation - Scrollable -->
            <nav class="flex-1 overflow-y-auto overflow-x-hidden -mx-2 min-h-0">
                <ul role="list" class="space-y-1 px-2 py-2">
                    @foreach($menuItems as $item)
                        @if(isset($item['children']))
                            <!-- Menu item with children -->
                            @php
                                // Check if any child route is currently active
                                $isActive = false;
                                foreach($item['children'] as $child) {
                                    if(request()->routeIs($child['route'] . '*')) {
                                        $isActive = true;
                                        break;
                                    }
                                }
                            @endphp
                            <li x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
                                <button @click="open = !open" 
                                        class="group flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm font-medium leading-6 text-gray-700 hover:bg-gray-50 hover:text-accent-500"
                                        :class="{ 'bg-accent-50 text-accent-500': open }">
                                    @include('components.icons.' . $item['icon'], ['class' => 'h-5 w-5 shrink-0'])
                                    <span class="truncate flex-1">{{ $item['name'] }}</span>
                                    <svg class="h-4 w-4 shrink-0 transition-transform duration-200"
                                         :class="{ 'rotate-90': open }"
                                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                                <ul x-show="open" 
                                    x-transition:enter="transition ease-out duration-100"
                                    x-transition:enter-start="transform opacity-0 scale-95"
                                    x-transition:enter-end="transform opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-75"
                                    x-transition:leave-start="transform opacity-100 scale-100"
                                    x-transition:leave-end="transform opacity-0 scale-95"
                                    class="mt-1 px-2"
                                    style="display: none;">
                                    @foreach($item['children'] as $child)
                                        <li>
                                            <a href="{{ route($child['route']) }}" 
                                               wire:navigate
                                               class="group flex gap-x-3 rounded-md py-2 pl-8 pr-2 text-sm leading-6 text-gray-600 hover:bg-gray-50 hover:text-accent-500 {{ request()->routeIs($child['route'] . '*') ? 'bg-accent-50 text-accent-500 font-medium' : '' }}">
                                                @include('components.icons.' . $child['icon'], ['class' => 'h-4 w-4 shrink-0'])
                                                <span class="truncate">{{ $child['name'] }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            <!-- Simple menu item -->
                            <li>
                                <a href="{{ route($item['route']) }}" 
                                   wire:navigate
                                   class="group flex gap-x-3 rounded-md p-2 text-sm font-medium leading-6 text-gray-700 hover:bg-gray-50 hover:text-accent-500 {{ request()->routeIs($item['route'] . '*') ? 'bg-accent-50 text-accent-500' : '' }}">
                                    @include('components.icons.' . $item['icon'], ['class' => 'h-5 w-5 shrink-0'])
                                    <span class="truncate">{{ $item['name'] }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </nav>

            <!-- User info and logout at bottom -->
            <div class="shrink-0 border-t border-gray-200 bg-white pt-3">
                <div class="flex items-center gap-x-3 px-2 py-2 text-sm font-medium leading-6 text-gray-900">
                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-r from-accent-500 to-accent-600">
                        <span class="text-sm font-medium text-white">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">
                            {{ auth()->user()->name }}
                        </p>
                        <p class="text-xs text-gray-500 capitalize">
                            {{ auth()->user()->role }}
                        </p>
                    </div>
                </div>
                
                <!-- Logout Button -->
                <div class="px-2 pt-2 pb-4">
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" 
                                class="group flex w-full items-center justify-center gap-x-2 rounded-xl p-2.5 text-sm font-medium leading-6 text-white bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 transition-all duration-200 shadow-soft hover:shadow-medium">
                            <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Spacer for mobile bottom navigation -->
            <div class="shrink-0 h-16 lg:hidden bg-white"></div>
        </div>
    </div>
</div>