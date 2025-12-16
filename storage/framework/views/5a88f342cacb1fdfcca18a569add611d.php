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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Maintenance Details')); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.maintenance.edit', $maintenance)); ?>" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <?php if (isset($component)) { $__componentOriginal0242837fe24781c41f0167a55744af19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0242837fe24781c41f0167a55744af19 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.pencil','data' => ['class' => 'w-4 h-4 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.pencil'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 inline mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0242837fe24781c41f0167a55744af19)): ?>
<?php $attributes = $__attributesOriginal0242837fe24781c41f0167a55744af19; ?>
<?php unset($__attributesOriginal0242837fe24781c41f0167a55744af19); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0242837fe24781c41f0167a55744af19)): ?>
<?php $component = $__componentOriginal0242837fe24781c41f0167a55744af19; ?>
<?php unset($__componentOriginal0242837fe24781c41f0167a55744af19); ?>
<?php endif; ?>
                    Edit
                </a>
                <a href="<?php echo e(route('admin.maintenance.index')); ?>" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <?php if (isset($component)) { $__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-left','data' => ['class' => 'w-4 h-4 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 inline mr-1']); ?>
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
                    Back to List
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Maintenance Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Vehicle Information -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Vehicle</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        <div class="font-semibold"><?php echo e($maintenance->car->license_plate); ?></div>
                                        <div class="text-gray-600"><?php echo e($maintenance->car->brand); ?> <?php echo e($maintenance->car->model); ?></div>
                                        <div class="text-gray-500"><?php echo e($maintenance->car->year); ?></div>
                                    </div>
                                </div>

                                <!-- Maintenance Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Maintenance Type</label>
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            <?php if($maintenance->maintenance_type === 'routine'): ?> bg-green-100 text-green-800
                                            <?php elseif($maintenance->maintenance_type === 'repair'): ?> bg-red-100 text-red-800
                                            <?php else: ?> bg-blue-100 text-blue-800 <?php endif; ?>">
                                            <?php echo e(ucfirst($maintenance->maintenance_type)); ?>

                                        </span>
                                    </div>
                                </div>

                                <!-- Service Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Service Date</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        <?php echo e($maintenance->service_date->format('d F Y')); ?>

                                        <span class="text-gray-500">(<?php echo e($maintenance->service_date->diffForHumans()); ?>)</span>
                                    </div>
                                </div>

                                <!-- Next Service Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Next Service Date</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($maintenance->next_service_date): ?>
                                            <div class="<?php if($maintenance->isNextServiceDue()): ?> text-red-600 font-semibold <?php elseif($maintenance->isNextServiceDueSoon()): ?> text-yellow-600 font-semibold <?php endif; ?>">
                                                <?php echo e($maintenance->next_service_date->format('d F Y')); ?>

                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($maintenance->isNextServiceDue()): ?>
                                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full ml-2">Overdue</span>
                                                <?php elseif($maintenance->isNextServiceDueSoon()): ?>
                                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full ml-2">Due Soon</span>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($maintenance->getDaysUntilNextService() !== null): ?>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    <?php echo e($maintenance->getDaysUntilNextService()); ?> days until next service
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-gray-400">Not scheduled</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>

                                <!-- Cost -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Cost</label>
                                    <div class="mt-1 text-lg font-semibold text-gray-900">
                                        Rp <?php echo e(number_format($maintenance->cost, 0, ',', '.')); ?>

                                    </div>
                                </div>

                                <!-- Odometer Reading -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Odometer Reading</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        <?php echo e(number_format($maintenance->odometer_at_service, 0, ',', '.')); ?> km
                                    </div>
                                </div>

                                <!-- Service Provider -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Service Provider</label>
                                    <div class="mt-1 text-sm text-gray-900"><?php echo e($maintenance->service_provider); ?></div>
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-line"><?php echo e($maintenance->description); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Photo -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($maintenance->receipt_photo): ?>
                        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Receipt Photo</h3>
                                <div class="text-center">
                                    <img src="<?php echo e($maintenance->receipt_photo_url); ?>" 
                                         alt="Maintenance Receipt" 
                                         class="max-w-full h-auto rounded-lg shadow-lg mx-auto"
                                         style="max-height: 500px;">
                                    <div class="mt-2">
                                        <a href="<?php echo e($maintenance->receipt_photo_url); ?>" 
                                           target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            View Full Size
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="<?php echo e(route('admin.maintenance.edit', $maintenance)); ?>" 
                                   class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    Edit Maintenance
                                </a>
                                <a href="<?php echo e(route('admin.vehicles.show', $maintenance->car)); ?>" 
                                   class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    View Vehicle
                                </a>
                                <a href="<?php echo e(route('admin.maintenance.car-history', $maintenance->car)); ?>" 
                                   class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    Vehicle History
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Analysis -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($maintenance->getCostPerKilometer()): ?>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Cost Analysis</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Cost per km:</span>
                                        <span class="text-sm font-medium">Rp <?php echo e(number_format($maintenance->getCostPerKilometer(), 2, ',', '.')); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Related Maintenance -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($relatedMaintenances->count() > 0): ?>
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Maintenance</h3>
                                <div class="space-y-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $relatedMaintenances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border-l-4 border-gray-200 pl-3">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        <?php echo e($related->service_date->format('d M Y')); ?>

                                                    </div>
                                                    <div class="text-xs text-gray-600">
                                                        <?php echo e(ucfirst($related->maintenance_type)); ?>

                                                    </div>
                                                    <div class="text-xs text-gray-500 truncate" style="max-width: 200px;">
                                                        <?php echo e($related->description); ?>

                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Rp <?php echo e(number_format($related->cost, 0, ',', '.')); ?>

                                                    </div>
                                                    <a href="<?php echo e(route('admin.maintenance.show', $related)); ?>" 
                                                       class="text-xs text-blue-600 hover:text-blue-800">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\maintenance\show.blade.php ENDPATH**/ ?>