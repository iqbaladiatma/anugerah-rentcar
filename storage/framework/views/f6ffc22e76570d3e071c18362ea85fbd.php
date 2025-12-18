<!-- GUEST BOTTOM NAV - Modern Minimalist -->
<div class="lg:hidden">
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-sm border-t border-secondary-100 shadow-large">
        <div class="grid grid-cols-4 h-18">
            <a href="<?php echo e(route('home')); ?>" wire:navigate
               class="mobile-nav-item <?php echo e(request()->routeIs('home') ? 'mobile-nav-active' : 'mobile-nav-inactive'); ?>">
                <div class="w-6 h-6 mb-1">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <span>Beranda</span>
            </a>
            
            <a href="<?php echo e(route('vehicles.catalog')); ?>" wire:navigate
               class="mobile-nav-item <?php echo e(request()->routeIs('vehicles.*') ? 'mobile-nav-active' : 'mobile-nav-inactive'); ?>">
                <div class="w-6 h-6 mb-1">
                    <svg fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                    </svg>
                </div>
                <span>Kendaraan</span>
            </a>
            
            <a href="<?php echo e(route('login')); ?>" wire:navigate
               class="mobile-nav-item <?php echo e(request()->routeIs('login') ? 'mobile-nav-active' : 'mobile-nav-inactive'); ?>">
                <div class="w-6 h-6 mb-1">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013 3v1"/>
                    </svg>
                </div>
                <span>Masuk</span>
            </a>
            
            <a href="<?php echo e(route('customer.register')); ?>" wire:navigate
               class="mobile-nav-item <?php echo e(request()->routeIs('customer.register') ? 'mobile-nav-active' : 'mobile-nav-inactive'); ?>">
                <div class="w-6 h-6 mb-1">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                </div>
                <span>Daftar</span>
            </a>
        </div>
    </nav>
    <!-- Bottom padding to prevent content overlap -->
    <div class="h-18"></div>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/components/guest-bottom-nav.blade.php ENDPATH**/ ?>