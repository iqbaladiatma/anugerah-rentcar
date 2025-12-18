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
    <?php
        // Get popular cars from database - ordered by number of bookings
        $popularCars = \App\Models\Car::where('status', 'available')
            ->withCount('bookings')
            ->orderByDesc('bookings_count')
            ->take(3)
            ->get();
            
        // If no cars with bookings, just get latest available cars
        if ($popularCars->isEmpty()) {
            $popularCars = \App\Models\Car::where('status', 'available')
                ->latest()
                ->take(3)
                ->get();
        }
    ?>

    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-secondary-900 via-secondary-800 to-secondary-900 text-primary-500 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-accent-500/10 to-accent-600/5"></div>
        <div class="relative container-custom section-padding">
            <div class="text-center animate-fade-in">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    <span class="text-white">Temukan Mobil Rental</span>
                    <span class="text-gradient block mt-2">Terbaik Anda</span>
                </h1>
                <p class="text-xl md:text-2xl mb-12 text-secondary-300 max-w-3xl mx-auto leading-relaxed">
                    Layanan rental mobil terpercaya, terjangkau, dan nyaman untuk semua kebutuhan Anda
                </p>
                
                <!-- Vehicle Search Widget -->
                <div class="max-w-5xl mx-auto card p-6 lg:p-8 text-secondary-800 animate-slide-up">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                        <div>
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Jenis Mobil</label>
                            <select class="form-input">
                                <option>Semua Jenis</option>
                                <option>Sedan</option>
                                <option>SUV</option>
                                <option>MPV</option>
                                <option>Hatchback</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <a href="<?php echo e(route('vehicles.catalog')); ?>" class="btn-primary w-full text-center">
                                Cari Mobil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section-padding bg-primary-500">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-6">Mengapa Memilih Anugerah Rentcar?</h2>
                <p class="text-lg lg:text-xl text-secondary-600 max-w-2xl mx-auto">Kami memberikan pengalaman rental mobil terbaik dengan fitur-fitur unggulan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
                <!-- Feature 1 -->
                <div class="text-center card-hover p-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-semibold text-secondary-900 mb-4">Kendaraan Berkualitas</h3>
                    <p class="text-secondary-600 leading-relaxed">Mobil terawat dan rutin diservis untuk keamanan dan kenyamanan Anda</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center card-hover p-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-secondary-800 to-secondary-900 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-semibold text-secondary-900 mb-4">Harga Kompetitif</h3>
                    <p class="text-secondary-600 leading-relaxed">Harga transparan tanpa biaya tersembunyi. Diskon khusus untuk member</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center card-hover p-8">
                    <div class="w-20 h-20 bg-gradient-to-r from-accent-400 to-accent-500 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl lg:text-2xl font-semibold text-secondary-900 mb-4">Layanan 24/7</h3>
                    <p class="text-secondary-600 leading-relaxed">Dukungan pelanggan sepanjang waktu untuk bantuan yang Anda butuhkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Vehicles Section -->
    <section class="section-padding bg-primary-200">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-6">Mobil Populer</h2>
                <p class="text-lg lg:text-xl text-secondary-600 max-w-2xl mx-auto">Pilih dari berbagai koleksi mobil rental berkualitas kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $popularCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="card-hover overflow-hidden bg-white rounded-xl shadow-lg">
                        <div class="h-48 lg:h-56 bg-secondary-100 flex items-center justify-center overflow-hidden">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->photo_front): ?>
                                <img src="<?php echo e(asset('storage/' . $car->photo_front)); ?>" 
                                     alt="<?php echo e($car->brand); ?> <?php echo e($car->model); ?>" 
                                     class="w-full h-full object-cover">
                            <?php else: ?>
                                <svg class="w-20 h-20 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="p-6 lg:p-8">
                            <h3 class="text-xl font-semibold text-secondary-900 mb-2"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></h3>
                            <p class="text-secondary-600 mb-4 leading-relaxed text-sm">
                                <?php echo e($car->year); ?> • <?php echo e(ucfirst($car->color)); ?> • <?php echo e($car->license_plate); ?>

                            </p>
                            <div class="flex justify-between items-center">
                                <div>
                                    <span class="text-2xl lg:text-3xl font-bold text-accent-500">Rp <?php echo e(number_format($car->daily_rate, 0, ',', '.')); ?></span>
                                    <span class="text-secondary-500 ml-1">/hari</span>
                                </div>
                                <a href="<?php echo e(route('vehicles.show', $car->id)); ?>" class="btn-outline text-sm">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <!-- Fallback if no cars in database -->
                    <div class="col-span-full text-center py-12">
                        <svg class="w-16 h-16 text-secondary-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-secondary-700 mb-2">Belum Ada Kendaraan</h3>
                        <p class="text-secondary-500">Kendaraan akan segera tersedia. Silakan cek kembali nanti.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <div class="text-center mt-12">
                <a href="<?php echo e(route('vehicles.catalog')); ?>" class="btn-primary text-lg">
                    Lihat Semua Kendaraan
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section-padding bg-primary-500">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-6">Cara Kerja</h2>
                <p class="text-lg lg:text-xl text-secondary-600 max-w-2xl mx-auto">Langkah mudah untuk mendapatkan mobil rental Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                <!-- Step 1 -->
                <div class="text-center group">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-r from-accent-500 to-accent-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl lg:text-3xl font-bold group-hover:scale-110 transition-transform duration-200">
                        1
                    </div>
                    <h3 class="text-lg lg:text-xl font-semibold text-secondary-900 mb-4">Cari & Pilih</h3>
                    <p class="text-secondary-600 leading-relaxed">Jelajahi kendaraan yang tersedia dan pilih mobil yang sesuai kebutuhan</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center group">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-r from-secondary-800 to-secondary-900 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl lg:text-3xl font-bold group-hover:scale-110 transition-transform duration-200">
                        2
                    </div>
                    <h3 class="text-lg lg:text-xl font-semibold text-secondary-900 mb-4">Pesan Online</h3>
                    <p class="text-secondary-600 leading-relaxed">Lengkapi pemesanan dengan sistem reservasi online yang aman</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center group">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-r from-accent-400 to-accent-500 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl lg:text-3xl font-bold group-hover:scale-110 transition-transform duration-200">
                        3
                    </div>
                    <h3 class="text-lg lg:text-xl font-semibold text-secondary-900 mb-4">Verifikasi Dokumen</h3>
                    <p class="text-secondary-600 leading-relaxed">Upload KTP dan SIM Anda untuk proses verifikasi</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center group">
                    <div class="w-16 h-16 lg:w-20 lg:h-20 bg-gradient-to-r from-secondary-700 to-secondary-800 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-2xl lg:text-3xl font-bold group-hover:scale-110 transition-transform duration-200">
                        4
                    </div>
                    <h3 class="text-lg lg:text-xl font-semibold text-secondary-900 mb-4">Ambil & Pergi</h3>
                    <p class="text-secondary-600 leading-relaxed">Ambil kendaraan Anda dan nikmati perjalanan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section-padding bg-gradient-to-r from-accent-500 to-accent-600 text-primary-500">
        <div class="container-custom text-center">
            <h2 class="text-3xl lg:text-4xl font-bold mb-6">Siap Memulai Perjalanan Anda?</h2>
            <p class="text-xl lg:text-2xl mb-12 text-accent-100 max-w-3xl mx-auto leading-relaxed">Bergabunglah dengan ribuan pelanggan yang puas dan mempercayai kami untuk kebutuhan transportasi mereka</p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="<?php echo e(route('vehicles.catalog')); ?>" class="bg-primary-500 text-accent-600 px-8 py-4 rounded-xl font-semibold hover:bg-primary-200 transition-all duration-200 hover:scale-105 shadow-medium text-lg">
                    Jelajahi Kendaraan
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->guest()): ?>
                    <a href="<?php echo e(route('customer.register')); ?>" class="border-2 border-primary-500 text-primary-500 px-8 py-4 rounded-xl font-semibold hover:bg-primary-500 hover:text-accent-600 transition-all duration-200 hover:scale-105 text-lg">
                        Daftar Sekarang
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/public/home.blade.php ENDPATH**/ ?>