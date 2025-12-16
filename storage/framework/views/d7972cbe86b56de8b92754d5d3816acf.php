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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    <?php echo e($car->license_plate); ?> - <?php echo e($car->brand); ?> <?php echo e($car->model); ?>

                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Vehicle details, maintenance history, and booking information.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('admin.vehicles.index')); ?>" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Back to Vehicles
                </a>
                <a href="#" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Edit Vehicle
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
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
                        <h3 class="text-lg font-medium text-gray-900">Vehicle Information</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">License Plate</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->license_plate); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Brand & Model</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Year</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->year); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Color</dt>
                                <dd class="mt-1 text-sm text-gray-900"><?php echo e($car->color); ?></dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Pricing Information -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Pricing Information</h3>
                    </div>
                    <div class="px-6 py-4">
                        <dl class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Daily Rate</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp <?php echo e(number_format($car->daily_rate, 0, ',', '.')); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Weekly Rate</dt>
                                <dd class="mt-1 text-sm text-gray-900">Rp <?php echo e(number_format($car->weekly_rate, 0, ',', '.')); ?></dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Driver Fee/Day</dt>
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
                        <h3 class="text-lg font-medium text-gray-900">Recent Bookings</h3>
                    </div>
                    <div class="px-6 py-4">
                        <p class="text-sm text-gray-500">No recent bookings</p>
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\vehicles\show.blade.php ENDPATH**/ ?>