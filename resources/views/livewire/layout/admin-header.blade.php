<div class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">

    <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
        <!-- Search -->
        <div class="relative flex flex-1 items-center">
            <div class="relative w-full max-w-md">
                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                    <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" 
                       placeholder="Cari pelanggan, kendaraan, pemesanan..." 
                       class="block w-full rounded-md border-0 py-1.5 pl-10 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-accent-500 sm:text-sm sm:leading-6">
            </div>
        </div>

        <div class="flex items-center gap-x-4 lg:gap-x-6">
            <!-- Notifications Widget -->
            @livewire('admin.notification-widget')

            <!-- Separator -->
            <div class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" aria-hidden="true"></div>

            <!-- Profile dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button type="button" 
                        class="-m-1.5 flex items-center p-1.5 hover:bg-gray-50 rounded-md"
                        @click="open = !open">
                    <span class="sr-only">Buka menu pengguna</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gradient-to-r from-accent-500 to-accent-600">
                        <span class="text-sm font-medium text-white">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                    </div>
                    <span class="hidden lg:flex lg:items-center">
                        <span class="ml-4 text-sm font-semibold leading-6 text-gray-900">
                            {{ auth()->user()->name }}
                        </span>
                        <svg class="ml-2 h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </span>
                </button>

                <!-- Dropdown menu -->
                <div x-show="open" 
                     @click.away="open = false"
                     x-transition:enter="transition ease-out duration-100"
                     x-transition:enter-start="transform opacity-0 scale-95"
                     x-transition:enter-end="transform opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-75"
                     x-transition:leave-start="transform opacity-100 scale-100"
                     x-transition:leave-end="transform opacity-0 scale-95"
                     class="absolute right-0 z-10 mt-2.5 w-48 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5">
                    
                    <a href="{{ route('profile') }}" 
                       wire:navigate
                       class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">
                        Profil Anda
                    </a>
                    
                    <div class="border-t border-gray-200 my-1"></div>
                    
                    <button wire:click="logout" 
                            class="block w-full text-left px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">
                        Keluar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

