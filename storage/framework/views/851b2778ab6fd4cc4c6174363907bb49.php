<?php if (isset($component)) { $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06 = $attributes; } ?>
<?php $component = App\View\Components\PublicLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PublicLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-white min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-r from-accent-500 to-accent-600 text-white">
            <div class="container-custom section-padding-sm">
                <div class="animate-fade-in">
                    <h1 class="heading-lg text-white mb-4">Selamat datang kembali, <?php echo e(auth('customer')->user()->name); ?>!</h1>
                    <p class="text-xl text-accent-100">Kelola pemesanan dan informasi akun Anda</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="container-custom section-padding-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in">
                <!-- Total Bookings -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-accent-500 to-accent-600 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-secondary-600 truncate">Total Pemesanan</p>
                            <p class="text-3xl font-bold text-secondary-900"><?php echo e($stats['total_bookings']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Active Bookings -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-secondary-700 to-secondary-800 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-secondary-600 truncate">Pemesanan Aktif</p>
                            <p class="text-3xl font-bold text-secondary-900"><?php echo e($stats['active_bookings']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Completed Bookings -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-accent-400 to-accent-500 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-secondary-600 truncate">Selesai</p>
                            <p class="text-3xl font-bold text-secondary-900"><?php echo e($stats['completed_bookings']); ?></p>
                        </div>
                    </div>
                </div>

                <!-- Total Spent -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <p class="text-sm font-medium text-secondary-600 truncate">Total Pengeluaran</p>
                            <p class="text-2xl font-bold text-secondary-900 truncate" title="Rp <?php echo e(number_format($stats['total_spent'], 0, ',', '.')); ?>">
                                Rp <?php echo e(number_format($stats['total_spent'], 0, ',', '.')); ?>

                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <?php echo $__env->make('customer.partials.payment-alert', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Bookings -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="px-6 py-5 border-b border-secondary-100">
                            <h3 class="heading-sm">Pemesanan Terbaru</h3>
                        </div>
                        <div class="p-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentBookings->count() > 0): ?>
                                <div class="space-y-4">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center justify-between p-4 border border-secondary-200 rounded-xl hover:shadow-soft transition-all duration-200">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->car->photo_front): ?>
                                                        <img class="h-14 w-14 rounded-xl object-cover" src="<?php echo e(asset('storage/' . $booking->car->photo_front)); ?>" alt="<?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?>">
                                                    <?php else: ?>
                                                        <div class="h-14 w-14 bg-secondary-100 rounded-xl flex items-center justify-center">
                                                            <svg class="w-7 h-7 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                            </svg>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-secondary-900"><?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?></p>
                                                    <p class="text-sm text-secondary-600"><?php echo e($booking->start_date->format('M d, Y')); ?> - <?php echo e($booking->end_date->format('M d, Y')); ?></p>
                                                    
                                                    
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->sudahSerahKunci() || $booking->sudahTerimaKunci()): ?>
                                                        <div class="flex items-center gap-2 mt-1">
                                                            <?php if($booking->sudahSerahKunci()): ?>
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                    Kunci Diserahkan
                                                                </span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->sudahTerimaKunci()): ?>
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                    Kunci Dikembalikan
                                                                </span>
                                                            <?php elseif($booking->sudahSerahKunci()): ?>
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800 animate-pulse">
                                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                                                                    </svg>
                                                                    Sedang Digunakan
                                                                </span>
                                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                    <?php if($booking->booking_status === 'active'): ?> bg-accent-100 text-accent-800
                                                    <?php elseif($booking->booking_status === 'completed'): ?> bg-secondary-100 text-secondary-800
                                                    <?php elseif($booking->booking_status === 'pending'): ?> bg-accent-50 text-accent-700
                                                    <?php else: ?> bg-secondary-100 text-secondary-700 <?php endif; ?>">
                                                    <?php echo e(ucfirst($booking->booking_status)); ?>

                                                </span>
                                                <p class="font-bold text-secondary-900 mt-2">Rp <?php echo e(number_format($booking->total_amount, 0, ',', '.')); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <div class="mt-6">
                                    <a href="<?php echo e(route('customer.bookings')); ?>" class="text-accent-600 hover:text-accent-500 font-semibold transition-colors">
                                        Lihat semua pemesanan →
                                    </a>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-16">
                                    <div class="w-20 h-20 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-10 h-10 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <h3 class="heading-sm mb-3">Belum ada pemesanan</h3>
                                    <p class="text-secondary-600 mb-8">Mulai dengan memesan kendaraan pertama Anda.</p>
                                    <a href="<?php echo e(route('vehicles.catalog')); ?>" class="btn-primary">
                                        Lihat Kendaraan
                                    </a>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="lg:col-span-1">
                    <div class="card p-6">
                        <h3 class="heading-sm mb-6">Aksi Cepat</h3>
                        <div class="flex flex-col gap-3">
                            <a href="<?php echo e(route('vehicles.catalog')); ?>" class="flex items-center justify-center w-full py-3 px-4 bg-gradient-to-r from-accent-500 to-accent-600 hover:from-accent-600 hover:to-accent-700 text-white font-semibold rounded-xl transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                Pesan Kendaraan Baru
                            </a>
                            <a href="<?php echo e(route('customer.bookings')); ?>" class="flex items-center justify-center w-full py-3 px-4 bg-white border border-secondary-200 hover:bg-secondary-50 text-secondary-700 font-medium rounded-xl transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Lihat Pemesanan Saya
                            </a>
                            <a href="<?php echo e(route('customer.profile')); ?>" class="flex items-center justify-center w-full py-3 px-4 bg-white border border-secondary-200 hover:bg-secondary-50 text-secondary-700 font-medium rounded-xl transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Edit Profil
                            </a>
                            <a href="<?php echo e(route('customer.support')); ?>" class="flex items-center justify-center w-full py-3 px-4 bg-white border border-secondary-200 hover:bg-secondary-50 text-secondary-700 font-medium rounded-xl transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                                Hubungi Dukungan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/customer/dashboard.blade.php ENDPATH**/ ?>