<div class="lg:hidden">
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-200 shadow-2xl">
        <div class="grid grid-cols-4 h-16">
            <a href="{{ route('home') }}" wire:navigate
               class="flex flex-col items-center justify-center space-y-1 text-gray-500 hover:text-blue-600 transition-colors {{ request()->routeIs('home') ? 'text-blue-600' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-xs font-medium">Beranda</span>
            </a>
            
            <a href="{{ route('vehicles.catalog') }}" wire:navigate
               class="flex flex-col items-center justify-center space-y-1 text-gray-500 hover:text-blue-600 transition-colors {{ request()->routeIs('vehicles.*') ? 'text-blue-600' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                </svg>
                <span class="text-xs font-medium">Kendaraan</span>
            </a>
            
            <a href="{{ route('login') }}" wire:navigate
               class="flex flex-col items-center justify-center space-y-1 text-gray-500 hover:text-blue-600 transition-colors {{ request()->routeIs('login') ? 'text-blue-600' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span class="text-xs font-medium">Masuk</span>
            </a>
            
            <a href="{{ route('customer.register') }}" wire:navigate
               class="flex flex-col items-center justify-center space-y-1 text-gray-500 hover:text-blue-600 transition-colors {{ request()->routeIs('customer.register') ? 'text-blue-600' : '' }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                </svg>
                <span class="text-xs font-medium">Daftar</span>
            </a>
        </div>
    </nav>
</div>
