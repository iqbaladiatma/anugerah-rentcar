<!-- CUSTOMER BOTTOM NAV - Modern Minimalist -->
@auth('customer')
<div class="lg:hidden">
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-t border-secondary-100 shadow-large">
        <div class="grid grid-cols-4 h-18">
            <a href="{{ route('customer.dashboard') }}" wire:navigate
               class="mobile-nav-item {{ request()->routeIs('customer.dashboard') ? 'mobile-nav-active' : 'mobile-nav-inactive' }}">
                <div class="w-6 h-6 mb-1">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span>Dashboard</span>
            </a>
            
            <a href="{{ route('customer.bookings') }}" wire:navigate
               class="mobile-nav-item {{ request()->routeIs('customer.bookings*') ? 'mobile-nav-active' : 'mobile-nav-inactive' }}">
                <div class="w-6 h-6 mb-1">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                </div>
                <span>Pesanan</span>
            </a>
            
            <a href="{{ route('vehicles.catalog') }}" wire:navigate
               class="mobile-nav-item {{ request()->routeIs('vehicles.*') ? 'mobile-nav-active' : 'mobile-nav-inactive' }}">
                <div class="w-6 h-6 mb-1">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                    </svg>
                </div>
                <span>Kendaraan</span>
            </a>
            
            <a href="{{ route('customer.profile') }}" wire:navigate
               class="mobile-nav-item {{ request()->routeIs('customer.profile') ? 'mobile-nav-active' : 'mobile-nav-inactive' }}">
                <div class="w-6 h-6 mb-1">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                </div>
                <span>Profil</span>
            </a>
        </div>
    </nav>
    <!-- Bottom padding to prevent content overlap -->
    <div class="h-18"></div>
</div>
@endauth
