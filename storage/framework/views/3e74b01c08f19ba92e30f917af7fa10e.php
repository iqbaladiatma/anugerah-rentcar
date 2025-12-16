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
                <?php echo e(__('Maintenance Management')); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.maintenance.create')); ?>" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <?php if (isset($component)) { $__componentOriginal52632fe7b137108a4c1d9fb6383ade19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52632fe7b137108a4c1d9fb6383ade19 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.plus','data' => ['class' => 'w-4 h-4 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 inline mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal52632fe7b137108a4c1d9fb6383ade19)): ?>
<?php $attributes = $__attributesOriginal52632fe7b137108a4c1d9fb6383ade19; ?>
<?php unset($__attributesOriginal52632fe7b137108a4c1d9fb6383ade19); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal52632fe7b137108a4c1d9fb6383ade19)): ?>
<?php $component = $__componentOriginal52632fe7b137108a4c1d9fb6383ade19; ?>
<?php unset($__componentOriginal52632fe7b137108a4c1d9fb6383ade19); ?>
<?php endif; ?>
                    Add Maintenance
                </a>
                <button onclick="window.location.href='<?php echo e(route('admin.maintenance.export')); ?>'" 
                        class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export Data
                </button>
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

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalbb585b916ac9791b47ae751e31e7a162 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb585b916ac9791b47ae751e31e7a162 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.currency-dollar','data' => ['class' => 'h-8 w-8 text-green-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.currency-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-green-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb585b916ac9791b47ae751e31e7a162)): ?>
<?php $attributes = $__attributesOriginalbb585b916ac9791b47ae751e31e7a162; ?>
<?php unset($__attributesOriginalbb585b916ac9791b47ae751e31e7a162); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb585b916ac9791b47ae751e31e7a162)): ?>
<?php $component = $__componentOriginalbb585b916ac9791b47ae751e31e7a162; ?>
<?php unset($__componentOriginalbb585b916ac9791b47ae751e31e7a162); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Cost</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    Rp <?php echo e(number_format($totalCost, 0, ',', '.')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalac5ce4cb0e7217f92544b8be719adb6f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.calendar','data' => ['class' => 'h-8 w-8 text-blue-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.calendar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-blue-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f)): ?>
<?php $attributes = $__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f; ?>
<?php unset($__attributesOriginalac5ce4cb0e7217f92544b8be719adb6f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalac5ce4cb0e7217f92544b8be719adb6f)): ?>
<?php $component = $__componentOriginalac5ce4cb0e7217f92544b8be719adb6f; ?>
<?php unset($__componentOriginalac5ce4cb0e7217f92544b8be719adb6f); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">This Month</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    Rp <?php echo e(number_format($thisMonthCost, 0, ',', '.')); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal50223666bec62b112c67eeabf671c0cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal50223666bec62b112c67eeabf671c0cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.wrench','data' => ['class' => 'h-8 w-8 text-red-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.wrench'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-red-500']); ?>
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
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Overdue</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($overdueMaintenance); ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal0656bd305abc6f376ceab88970af3514 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0656bd305abc6f376ceab88970af3514 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.clock','data' => ['class' => 'h-8 w-8 text-yellow-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.clock'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-yellow-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0656bd305abc6f376ceab88970af3514)): ?>
<?php $attributes = $__attributesOriginal0656bd305abc6f376ceab88970af3514; ?>
<?php unset($__attributesOriginal0656bd305abc6f376ceab88970af3514); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0656bd305abc6f376ceab88970af3514)): ?>
<?php $component = $__componentOriginal0656bd305abc6f376ceab88970af3514; ?>
<?php unset($__componentOriginal0656bd305abc6f376ceab88970af3514); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Due Soon</p>
                                <p class="text-2xl font-semibold text-gray-900"><?php echo e($dueSoonMaintenance); ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button onclick="showTab('maintenance-list')" 
                                class="tab-button active border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Maintenance Records
                        </button>
                        <button onclick="showTab('maintenance-scheduler')" 
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Schedule & Reminders
                        </button>
                        <button onclick="showTab('maintenance-analytics')" 
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Analytics & Reports
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div id="maintenance-list" class="tab-content">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.maintenance-list', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1224713326-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>

                <div id="maintenance-scheduler" class="tab-content hidden">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.maintenance-scheduler', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1224713326-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>

                <div id="maintenance-analytics" class="tab-content hidden">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.maintenance-analytics', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1224713326-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-blue-500', 'text-blue-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');
            
            // Add active class to clicked button
            event.target.classList.remove('border-transparent', 'text-gray-500');
            event.target.classList.add('active', 'border-blue-500', 'text-blue-600');
        }
    </script>

    <style>
        .tab-button.active {
            border-color: #3B82F6;
            color: #2563EB;
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\maintenance\index.blade.php ENDPATH**/ ?>