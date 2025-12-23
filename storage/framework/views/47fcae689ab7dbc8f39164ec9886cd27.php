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

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Pemesanan</h1>
                <p class="text-sm text-gray-500 mt-1">Nomor Booking: <span class="font-semibold text-gray-900"><?php echo e($booking->booking_number); ?></span></p>
            </div>
            <div>
                <?php
                    $statusColors = [
                        'pending' => 'bg-yellow-100 text-yellow-800',
                        'confirmed' => 'bg-blue-100 text-blue-800',
                        'active' => 'bg-green-100 text-green-800',
                        'completed' => 'bg-gray-100 text-gray-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'confirmed' => 'Dikonfirmasi',
                        'active' => 'Sedang Berlangsung',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                ?>
                <span class="px-3 py-1 rounded-full text-sm font-medium <?php echo e($statusColors[$booking->booking_status] ?? 'bg-gray-100 text-gray-800'); ?>">
                    <?php echo e($statusLabels[$booking->booking_status] ?? ucfirst($booking->booking_status)); ?>

                </span>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                <span class="text-green-800 font-medium"><?php echo e(session('success')); ?></span>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Booking Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Vehicle Information -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-accent-600 to-accent-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Informasi Kendaraan</h2>
                </div>
                <div class="p-6">
                    <div class="flex items-start space-x-4">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->car->photo_front): ?>
                            <img src="<?php echo e(asset('storage/' . $booking->car->photo_front)); ?>" 
                                 alt="<?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?>"
                                 class="w-32 h-24 object-cover rounded-lg">
                        <?php else: ?>
                            <div class="w-32 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="flex-1">
                            <h3 class="text-xl font-bold text-gray-900"><?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?></h3>
                            <div class="mt-2 space-y-1 text-sm text-gray-600">
                                <p><span class="font-medium">Tahun:</span> <?php echo e($booking->car->year); ?></p>
                                <p><span class="font-medium">Warna:</span> <?php echo e($booking->car->color); ?></p>
                                <p><span class="font-medium">Plat Nomor:</span> <?php echo e($booking->car->license_plate); ?></p>
                                <p><span class="font-medium">Transmisi:</span> <?php echo e(ucfirst($booking->car->transmission)); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rental Details -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-accent-600 to-accent-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Detail Sewa</h2>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pengambilan</p>
                            <p class="font-semibold text-gray-900"><?php echo e(\Carbon\Carbon::parse($booking->start_date)->format('d M Y')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pengembalian</p>
                            <p class="font-semibold text-gray-900"><?php echo e(\Carbon\Carbon::parse($booking->end_date)->format('d M Y')); ?></p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Durasi</p>
                            <p class="font-semibold text-gray-900"><?php echo e(\Carbon\Carbon::parse($booking->start_date)->diffInDays($booking->end_date)); ?> Hari</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Dengan Driver</p>
                            <p class="font-semibold text-gray-900"><?php echo e($booking->with_driver ? 'Ya' : 'Tidak'); ?></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Lokasi Pengambilan</p>
                            <p class="font-semibold text-gray-900"><?php echo e($booking->pickup_location); ?></p>
                        </div>
                        <div class="col-span-2">
                            <p class="text-sm text-gray-500">Lokasi Pengembalian</p>
                            <p class="font-semibold text-gray-900"><?php echo e($booking->return_location); ?></p>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->notes): ?>
                            <div class="col-span-2">
                                <p class="text-sm text-gray-500">Catatan</p>
                                <p class="text-gray-900"><?php echo e($booking->notes); ?></p>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>
            </div>

            
            <?php echo $__env->make('customer.partials.kunci-status', ['booking' => $booking], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Right Column - Payment & Actions -->
        <div class="space-y-6">
            <!-- Payment Summary -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-accent-600 to-accent-700 px-6 py-4">
                    <h2 class="text-lg font-semibold text-white">Ringkasan Pembayaran</h2>
                </div>
                <div class="p-6 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Sewa Kendaraan</span>
                        <span class="font-medium">Rp <?php echo e(number_format($booking->base_amount, 0, ',', '.')); ?></span>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->driver_fee > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Driver</span>
                            <span class="font-medium">Rp <?php echo e(number_format($booking->driver_fee, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->out_of_town_fee > 0): ?>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Biaya Luar Kota</span>
                            <span class="font-medium">Rp <?php echo e(number_format($booking->out_of_town_fee, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->member_discount > 0): ?>
                        <div class="flex justify-between text-sm text-green-600">
                            <span>Diskon Member</span>
                            <span class="font-medium">-Rp <?php echo e(number_format($booking->member_discount, 0, ',', '.')); ?></span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="font-bold text-gray-900">Total</span>
                            <span class="font-bold text-blue-600 text-lg">Rp <?php echo e(number_format($booking->total_amount, 0, ',', '.')); ?></span>
                        </div>
                        <div class="flex justify-between text-sm mt-1">
                            <span class="text-gray-600">Deposit</span>
                            <span class="font-medium">Rp <?php echo e(number_format($booking->deposit_amount, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                    <div class="pt-3 border-t">
                        <?php
                            $paymentStatusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'partial' => 'bg-blue-100 text-blue-800',
                                'refunded' => 'bg-gray-100 text-gray-800',
                            ];
                            $paymentStatusLabels = [
                                'pending' => 'Menunggu Pembayaran',
                                'paid' => 'Lunas',
                                'partial' => 'Sebagian',
                                'refunded' => 'Dikembalikan',
                            ];
                        ?>
                        <div class="text-center">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-medium <?php echo e($paymentStatusColors[$booking->payment_status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                <?php echo e($paymentStatusLabels[$booking->payment_status] ?? ucfirst($booking->payment_status)); ?>

                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-lg shadow-md p-6 space-y-3">
                <h3 class="font-semibold text-gray-900 mb-4">Aksi</h3>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->payment_status === 'pending'): ?>
                    <a href="<?php echo e(route('customer.bookings.payment', $booking)); ?>" 
                       class="block w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium text-center">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                        Upload Bukti Pembayaran
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->booking_status === 'pending'): ?>
                    <form method="POST" action="<?php echo e(route('customer.bookings.cancel', $booking)); ?>" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors font-medium">
                            Batalkan Pemesanan
                        </button>
                    </form>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <a href="<?php echo e(route('customer.bookings.ticket', $booking)); ?>" class="block w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium text-center">
                    Download Tiket
                </a>

                <a href="<?php echo e(route('customer.bookings')); ?>" class="block w-full bg-gray-200 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-300 transition-colors font-medium text-center">
                    Kembali ke Daftar
                </a>
            </div>

            <!-- Contact Support -->
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="font-semibold text-gray-900 mb-2">Butuh Bantuan?</h3>
                <p class="text-sm text-gray-600 mb-4">Hubungi kami jika Anda memiliki pertanyaan tentang pemesanan ini.</p>
                <a href="<?php echo e(route('customer.support')); ?>" class="block w-full bg-white text-blue-600 py-2 px-4 rounded-lg hover:bg-gray-50 transition-colors font-medium text-center border border-blue-600">
                    Hubungi Dukungan
                </a>
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/customer/booking-details.blade.php ENDPATH**/ ?>