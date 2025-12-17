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
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Temukan Mobil Rental
                    <span class="text-yellow-400">Terbaik Anda</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Layanan rental mobil terpercaya, terjangkau, dan nyaman untuk semua kebutuhan Anda
                </p>
                
                <!-- Vehicle Search Widget -->
                <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-xl p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Mobil</label>
                            <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option>Semua Jenis</option>
                                <option>Sedan</option>
                                <option>SUV</option>
                                <option>MPV</option>
                                <option>Hatchback</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <a href="<?php echo e(route('vehicles.catalog')); ?>" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold transition-colors text-center">
                                Cari Mobil
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih Anugerah Rentcar?</h2>
                <p class="text-lg text-gray-600">Kami memberikan pengalaman rental mobil terbaik dengan fitur-fitur unggulan</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Kendaraan Berkualitas</h3>
                    <p class="text-gray-600">Mobil terawat dan rutin diservis untuk keamanan dan kenyamanan Anda</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Harga Kompetitif</h3>
                    <p class="text-gray-600">Harga transparan tanpa biaya tersembunyi. Diskon khusus untuk member</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-6 bg-gray-50 rounded-lg">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Layanan 24/7</h3>
                    <p class="text-gray-600">Dukungan pelanggan sepanjang waktu untuk bantuan yang Anda butuhkan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Vehicles Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Mobil Populer</h2>
                <p class="text-lg text-gray-600">Pilih dari berbagai koleksi mobil rental berkualitas kami</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Sample Vehicle Cards -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Toyota Avanza</h3>
                        <p class="text-gray-600 mb-4">MPV 7 seater yang nyaman untuk keluarga</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">Rp 350K</span>
                            <span class="text-gray-500">/hari</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Honda Brio</h3>
                        <p class="text-gray-600 mb-4">Hatchback irit dan lincah untuk dalam kota</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">Rp 250K</span>
                            <span class="text-gray-500">/hari</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Toyota Innova</h3>
                        <p class="text-gray-600 mb-4">MPV premium untuk perjalanan jauh</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-blue-600">Rp 450K</span>
                            <span class="text-gray-500">/hari</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-8">
                <a href="<?php echo e(route('vehicles.catalog')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                    Lihat Semua Kendaraan
                </a>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-lg text-gray-600">Langkah mudah untuk mendapatkan mobil rental Anda</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        1
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Cari & Pilih</h3>
                    <p class="text-gray-600">Jelajahi kendaraan yang tersedia dan pilih mobil yang sesuai kebutuhan</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        2
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pesan Online</h3>
                    <p class="text-gray-600">Lengkapi pemesanan dengan sistem reservasi online yang aman</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        3
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Verifikasi Dokumen</h3>
                    <p class="text-gray-600">Upload KTP dan SIM Anda untuk proses verifikasi</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        4
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Ambil & Pergi</h3>
                    <p class="text-gray-600">Ambil kendaraan Anda dan nikmati perjalanan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Siap Memulai Perjalanan Anda?</h2>
            <p class="text-xl mb-8 text-blue-100">Bergabunglah dengan ribuan pelanggan yang puas dan mempercayai kami untuk kebutuhan transportasi mereka</p>
            <div class="space-x-4">
                <a href="<?php echo e(route('vehicles.catalog')); ?>" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                    Jelajahi Kendaraan
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->guest()): ?>
                    <a href="<?php echo e(route('customer.register')); ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors inline-block">
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