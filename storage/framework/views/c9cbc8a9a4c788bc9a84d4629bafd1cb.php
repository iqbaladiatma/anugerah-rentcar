<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <!-- Vehicle Status -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            <?php echo e(ucfirst($car->status)); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Vehicle Information -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Kendaraan</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Plat Nomor</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->license_plate); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Merek & Model</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tahun</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->year); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Warna</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->color); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Informasi Harga</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tarif Harian</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp <?php echo e(number_format($car->daily_rate, 0, ',', '.')); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tarif Mingguan</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp <?php echo e(number_format($car->weekly_rate, 0, ',', '.')); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Biaya Sopir/Hari</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp <?php echo e(number_format($car->driver_fee_per_day, 0, ',', '.')); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Recent Bookings -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pemesanan Terbaru</h3>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-500">Tidak ada pemesanan terbaru</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/vehicles/show.blade.php ENDPATH**/ ?>