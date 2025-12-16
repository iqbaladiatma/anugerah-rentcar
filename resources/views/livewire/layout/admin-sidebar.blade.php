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
    @toggle-sidebar.window="sidebarOpen = !sidebarOpen">
    
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
    <div x-show="isDesktop || sidebarOpen"
         x-transition:enter="transition-transform ease-out duration-200 lg:transition-none"
         x-transition:enter-start="-translate-x-full lg:translate-x-0"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition-transform ease-in duration-200 lg:transition-none"
         x-transition:leave-start="translate-x-0 lg:translate-x-0"
         x-transition:leave-end="-translate-x-full lg:translate-x-0"
         class="fixed inset-y-0 z-50 flex w-64 flex-col lg:z-auto"
         :class="{ 'lg:translate-x-0': true }">
        
        <!-- Sidebar content -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4 shadow-xl lg:shadow-none border-r border-gray-200">
            <!-- Logo -->
            <div class="flex h-16 shrink-0 items-center">
                <div class="flex items-center space-x-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-600">
                        <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 01-3 0V5.25a1.5 1.5 0 013 0v13.5zM15.75 18.75a1.5 1.5 0 01-3 0V5.25a1.5 1.5 0 013 0v13.5z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-semibold text-gray-900">Anugerah Rentcar</h1>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex flex-1 flex-col">
                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                    <li>
                        <ul role="list" class="-mx-2 space-y-1">
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
                                                class="group flex w-full items-center gap-x-3 rounded-md p-2 text-left text-sm font-medium leading-6 text-gray-700 hover:bg-gray-50 hover:text-blue-600"
                                                :class="{ 'bg-gray-50 text-blue-600': open }">
                                            @include('components.icons.' . $item['icon'], ['class' => 'h-5 w-5 shrink-0'])
                                            {{ $item['name'] }}
                                            <svg class="ml-auto h-4 w-4 shrink-0 transition-transform duration-200"
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
                                            class="mt-1 px-2">
                                            @foreach($item['children'] as $child)
                                                <li>
                                                    <a href="{{ route($child['route']) }}" 
                                                       wire:navigate
                                                       class="group flex gap-x-3 rounded-md py-2 pl-8 pr-2 text-sm leading-6 text-gray-600 hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs($child['route'] . '*') ? 'bg-gray-50 text-blue-600 font-medium' : '' }}">
                                                        @include('components.icons.' . $child['icon'], ['class' => 'h-4 w-4 shrink-0'])
                                                        {{ $child['name'] }}
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
                                           class="group flex gap-x-3 rounded-md p-2 text-sm font-medium leading-6 text-gray-700 hover:bg-gray-50 hover:text-blue-600 {{ request()->routeIs($item['route'] . '*') ? 'bg-gray-50 text-blue-600' : '' }}">
                                            @include('components.icons.' . $item['icon'], ['class' => 'h-5 w-5 shrink-0'])
                                            {{ $item['name'] }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>

                    <!-- User info at bottom -->
                    <li class="mt-auto">
                        <div class="flex items-center gap-x-4 px-2 py-3 text-sm font-medium leading-6 text-gray-900 border-t border-gray-200">
                            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
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
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</div>