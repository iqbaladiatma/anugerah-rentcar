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
                    Vehicles Requiring Maintenance
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Vehicles that need oil changes, STNK renewals, or other maintenance services.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="<?php echo e(route('admin.vehicles.index')); ?>" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <?php if (isset($component)) { $__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-left','data' => ['class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7)): ?>
<?php $attributes = $__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7; ?>
<?php unset($__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7)): ?>
<?php $component = $__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7; ?>
<?php unset($__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7); ?>
<?php endif; ?>
                    Back to Vehicles
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <!-- Maintenance Notifications Component -->
        <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.maintenance-notifications', ['showAll' => true]);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-419803824-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        
        <!-- Vehicles Needing Maintenance -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Vehicles Requiring Attention</h3>
            </div>
            <div class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Vehicle
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Issue
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                                $maintenanceVehicles = \App\Models\Car::where(function ($query) {
                                    $query->where('last_oil_change', '<=', now()->subDays(90))
                                          ->orWhere('stnk_expiry', '<=', now()->addDays(30));
                                })->get();
                            ?>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $maintenanceVehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $notifications = $vehicle->getMaintenanceNotifications();
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo e($vehicle->license_plate); ?>

                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900"><?php echo e($notification['message']); ?></div>
                                            <div class="text-sm text-gray-500">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification['type'] === 'oil_change'): ?>
                                                    Last oil change: <?php echo e($vehicle->last_oil_change?->format('d M Y') ?? 'Not recorded'); ?>

                                                <?php elseif($notification['type'] === 'stnk_expiry'): ?>
                                                    STNK expires: <?php echo e($vehicle->stnk_expiry?->format('d M Y')); ?>

                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                <?php if($notification['priority'] === 'high'): ?> bg-red-100 text-red-800
                                                <?php else: ?> bg-yellow-100 text-yellow-800
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($notification['priority'])); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                <?php if($vehicle->status === 'available'): ?> bg-green-100 text-green-800
                                                <?php elseif($vehicle->status === 'rented'): ?> bg-blue-100 text-blue-800
                                                <?php elseif($vehicle->status === 'maintenance'): ?> bg-yellow-100 text-yellow-800
                                                <?php else: ?> bg-gray-100 text-gray-800
                                                <?php endif; ?>">
                                                <?php echo e(ucfirst($vehicle->status)); ?>

                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->status !== 'maintenance'): ?>
                                                    <form action="<?php echo e(route('admin.vehicles.update-status', $vehicle)); ?>" method="POST" class="inline">
                                                        <?php echo csrf_field(); ?>
                                                        <?php echo method_field('PATCH'); ?>
                                                        <input type="hidden" name="status" value="maintenance">
                                                        <input type="hidden" name="reason" value="Scheduled maintenance">
                                                        <button type="submit" 
                                                                class="text-yellow-600 hover:text-yellow-900 text-sm">
                                                            Mark for Maintenance
                                                        </button>
                                                    </form>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <a href="<?php echo e(route('admin.vehicles.show', $vehicle)); ?>" 
                                                   class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                                                <a href="<?php echo e(route('admin.vehicles.edit', $vehicle)); ?>" 
                                                   class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <?php if (isset($component)) { $__componentOriginal50223666bec62b112c67eeabf671c0cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal50223666bec62b112c67eeabf671c0cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.wrench','data' => ['class' => 'w-12 h-12 mx-auto mb-4 text-gray-300']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.wrench'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-12 h-12 mx-auto mb-4 text-gray-300']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal50223666bec62b112c67eeabf671c0cf)): ?>
<?php $attributes = $__attributesOriginal50223666bec62b112c67eeabf671c0cf; ?>
<?php unset($__attributesOriginal50223666bec62b112c67eeabf671c0cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal50223666bec62b112c67eeabf671c0cf)): ?>
<?php $component = $__componentOriginal50223666bec62b112c67eeabf671c0cf; ?>
<?php unset($__componentOriginal50223666bec62b112c67eeabf671c0cf); ?>
<?php endif; ?>
                                            <p class="text-lg font-medium">No maintenance required</p>
                                            <p class="text-sm">All vehicles are up to date with maintenance schedules.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </tbody>
                    </table>
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\vehicles\maintenance-due.blade.php ENDPATH**/ ?>