<div class="lg:hidden">
    <!-- Mobile Bottom Navigation -->
    <nav class="fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-gray-200 shadow-lg pb-safe">
        <div class="grid grid-cols-4 h-16">
            <!-- Dashboard -->
            <a href="<?php echo e(route('dashboard')); ?>" 
               wire:navigate
               class="flex flex-col items-center justify-center space-y-1 <?php echo e(request()->routeIs('dashboard') ? 'text-blue-600' : 'text-gray-600'); ?> hover:text-blue-600 active:scale-95 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span class="text-xs font-medium">Dashboard</span>
            </a>

            <!-- Bookings -->
            <a href="<?php echo e(route('admin.bookings.index')); ?>" 
               wire:navigate
               class="flex flex-col items-center justify-center space-y-1 <?php echo e(request()->routeIs('admin.bookings.*') ? 'text-blue-600' : 'text-gray-600'); ?> hover:text-blue-600 active:scale-95 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                </svg>
                <span class="text-xs font-medium">Bookings</span>
            </a>

            <!-- Vehicles -->
            <a href="<?php echo e(route('admin.vehicles.index')); ?>" 
               wire:navigate
               class="flex flex-col items-center justify-center space-y-1 <?php echo e(request()->routeIs('admin.vehicles.*') ? 'text-blue-600' : 'text-gray-600'); ?> hover:text-blue-600 active:scale-95 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <span class="text-xs font-medium">Vehicles</span>
            </a>

            <!-- Menu (Toggle Sidebar) -->
            <button @click="$dispatch('toggle-sidebar')"
                    class="flex flex-col items-center justify-center space-y-1 text-gray-600 hover:text-blue-600 active:scale-95 active:text-blue-600 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <span class="text-xs font-medium">Menu</span>
            </button>
        </div>
    </nav>

    <!-- Bottom padding to prevent content from being hidden behind bottom nav -->
    <div class="h-16"></div>
</div>
<?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/layout/mobile-bottom-nav.blade.php ENDPATH**/ ?>