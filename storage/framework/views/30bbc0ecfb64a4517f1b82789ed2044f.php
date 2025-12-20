<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'Anugerah Rentcar')); ?> - Rental Mobil Terpercaya</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="<?php echo e(asset('ini.jpg')); ?>">
        <link rel="apple-touch-icon" href="<?php echo e(asset('ini.jpg')); ?>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    </head>
    <body class="font-sans antialiased bg-white">
        <!-- Navigation -->
        <nav class="bg-white shadow-soft border-b border-secondary-100 sticky top-0 z-50 backdrop-blur-sm bg-white/95">
            <div class="container-custom px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14 sm:h-16 lg:h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="<?php echo e(route('home')); ?>" class="flex items-center group">
                            <img 
                                src="<?php echo e(asset('ini.jpg')); ?>" 
                                alt="Anugerah Rentcar Logo" 
                                class="w-10 h-10 lg:w-12 lg:h-12 min-w-[40px] min-h-[40px] lg:min-w-[48px] lg:min-h-[48px] object-contain rounded-xl group-hover:scale-105 transition-transform duration-200 flex-shrink-0"
                            >
                            <span class="ml-3 text-lg lg:text-2xl font-bold text-secondary-900">Anugerah Rentcar</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden lg:flex lg:items-center lg:ml-10 lg:space-x-8">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
                            <a href="<?php echo e(route('customer.dashboard')); ?>" class="<?php echo e(request()->routeIs('customer.dashboard') ? 'nav-link-active' : 'nav-link'); ?>">
                                Dashboard
                            </a>
                            <a href="<?php echo e(route('customer.bookings')); ?>" class="<?php echo e(request()->routeIs('customer.bookings*') ? 'nav-link-active' : 'nav-link'); ?>">
                                Pemesanan Saya
                            </a>
                            <a href="<?php echo e(route('vehicles.catalog')); ?>" class="<?php echo e(request()->routeIs('vehicles.*') ? 'nav-link-active' : 'nav-link'); ?>">
                                Kendaraan
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('home')); ?>" class="<?php echo e(request()->routeIs('home') ? 'nav-link-active' : 'nav-link'); ?>">
                                Beranda
                            </a>
                            <a href="<?php echo e(route('vehicles.catalog')); ?>" class="<?php echo e(request()->routeIs('vehicles.*') ? 'nav-link-active' : 'nav-link'); ?>">
                                Kendaraan
                            </a>
                            <a href="<?php echo e(route('public.support')); ?>" class="nav-link">
                                Kontak
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Right side navigation (Desktop only) -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
                            <!-- Customer is logged in -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm font-medium text-secondary-700 hover:text-accent-500 focus:outline-none focus:text-accent-500 transition-colors px-3 py-2 rounded-lg hover:bg-primary-200">
                                    <span class="hidden sm:block"><?php echo e(auth('customer')->user()->name); ?></span>
                                    <span class="sm:hidden">Menu</span>
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-primary-500 rounded-xl shadow-medium py-2 z-50 border border-secondary-100">
                                    <a href="<?php echo e(route('customer.dashboard')); ?>" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                        Dashboard
                                    </a>
                                    <a href="<?php echo e(route('customer.bookings')); ?>" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                        Pemesanan Saya
                                    </a>
                                    <a href="<?php echo e(route('customer.profile')); ?>" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                        Profil
                                    </a>
                                    <div class="border-t border-secondary-100 my-2"></div>
                                    <form method="POST" action="<?php echo e(route('customer.logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Customer is not logged in -->
                            <a href="<?php echo e(route('login')); ?>" class="nav-link">
                                Masuk
                            </a>
                            <a href="<?php echo e(route('customer.register')); ?>" class="btn-primary text-sm">
                                Daftar
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>
        </nav>


        <!-- Page Content -->
        <main>
            <?php echo e($slot); ?>

        </main>

        <!-- Footer -->
        <footer class="bg-secondary-900 text-primary-500">
            <div class="container-custom section-padding">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <!-- Company Info -->
                    <div class="col-span-1 lg:col-span-2">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                                <img 
                                    src="<?php echo e(asset('ini.jpg')); ?>" 
                                    alt="Anugerah Rentcar Logo" 
                                    class="w-10 h-10 lg:w-12 lg:h-12 min-w-[40px] min-h-[40px] lg:min-w-[48px] lg:min-h-[48px] object-contain rounded-xl group-hover:scale-105 transition-transform duration-200 flex-shrink-0"
                                >
                            </div>
                            <span class="ml-4 text-2xl font-bold">Anugerah Rentcar</span>
                        </div>
                        <p class="text-secondary-300 mb-6 text-lg leading-relaxed max-w-md">
                            Partner terpercaya Anda untuk layanan rental mobil yang handal dan terjangkau. 
                            Kami menyediakan kendaraan berkualitas untuk semua kebutuhan transportasi Anda.
                        </p>
                        <div class="flex space-x-4">
                            <!-- 1. INSTAGRAM -->
                            <a href="https://www.instagram.com/anugerah.rentcar/" class="w-10 h-10 bg-secondary-800 hover:bg-pink-600 rounded-lg flex items-center justify-center text-secondary-400 hover:text-white transition-all duration-200 group">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>

                            <!-- 2. TIKTOK -->
                                <a href="https://www.tiktok.com/@anugerah.rentcar" class="w-10 h-10 bg-secondary-800 hover:bg-black hover:border hover:border-gray-700 rounded-lg flex items-center justify-center text-secondary-400 hover:text-white transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19.59 6.69a4.83 4.83 0 0 1-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 0 1-5.2 1.74 2.89 2.89 0 0 1 2.31-4.64 2.93 2.93 0 0 1 .88.13V9.4a6.84 6.84 0 0 0-1-.05A6.33 6.33 0 0 0 5 20.1a6.34 6.34 0 0 0 10.86-4.43v-7a8.16 8.16 0 0 0 4.77 1.52v-3.4a4.85 4.85 0 0 1-1-.1z"/>
                                </svg>
                            </a>

                                <!-- 3. WHATSAPP -->
                            <a href="https://wa.me/628977777451" class="w-10 h-10 bg-secondary-800 hover:bg-green-600 rounded-lg flex items-center justify-center text-secondary-400 hover:text-white transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6 text-primary-500">Tautan Cepat</h3>
                        <ul class="space-y-3">
                            <li><a href="<?php echo e(route('vehicles.catalog')); ?>" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">Jelajahi Kendaraan</a></li>
                            <li><a href="<?php echo e(route('terms')); ?>" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">Syarat & Ketentuan</a></li>
                            <li><a href="<?php echo e(route('terms')); ?>#faq" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">FAQ</a></li>
                            <li><a href="<?php echo e(route('public.support')); ?>" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">Hubungi Kami</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6 text-primary-500">Hubungi Kami</h3>
                        <ul class="space-y-4 text-secondary-300">
                            <li class="flex items-start">
                                <div class="w-5 h-5 mt-0.5 mr-3 text-accent-500 flex-shrink-0">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-base">Blora, Jawa Tengah</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-5 h-5 mt-0.5 mr-3 text-accent-500 flex-shrink-0">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                <span class="text-base">+62 897-7777-451</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-5 h-5 mt-0.5 mr-3 text-accent-500 flex-shrink-0">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                <span class="text-base">info@anugerahrentcar.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-secondary-800 mt-12 pt-8 text-center">
                    <p class="text-secondary-400 text-base">&copy; <?php echo e(date('Y')); ?> Anugerah Rentcar. Semua hak dilindungi.</p>
                </div>
            </div>
        </footer>

        <?php if (isset($component)) { $__componentOriginald8de4041c965810409d7e86b42ce6acb = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald8de4041c965810409d7e86b42ce6acb = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.customer-bottom-nav-test','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('customer-bottom-nav-test'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald8de4041c965810409d7e86b42ce6acb)): ?>
<?php $attributes = $__attributesOriginald8de4041c965810409d7e86b42ce6acb; ?>
<?php unset($__attributesOriginald8de4041c965810409d7e86b42ce6acb); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald8de4041c965810409d7e86b42ce6acb)): ?>
<?php $component = $__componentOriginald8de4041c965810409d7e86b42ce6acb; ?>
<?php unset($__componentOriginald8de4041c965810409d7e86b42ce6acb); ?>
<?php endif; ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->guest()): ?>
            <?php if (isset($component)) { $__componentOriginal75320a85ec0e09bd704db10c2ae3e357 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal75320a85ec0e09bd704db10c2ae3e357 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.guest-bottom-nav','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-bottom-nav'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal75320a85ec0e09bd704db10c2ae3e357)): ?>
<?php $attributes = $__attributesOriginal75320a85ec0e09bd704db10c2ae3e357; ?>
<?php unset($__attributesOriginal75320a85ec0e09bd704db10c2ae3e357); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal75320a85ec0e09bd704db10c2ae3e357)): ?>
<?php $component = $__componentOriginal75320a85ec0e09bd704db10c2ae3e357; ?>
<?php unset($__componentOriginal75320a85ec0e09bd704db10c2ae3e357); ?>
<?php endif; ?>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/layouts/public.blade.php ENDPATH**/ ?>