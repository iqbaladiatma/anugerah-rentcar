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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Reports Dashboard')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Report Categories -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Customer Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal46848001facf1cdb1a84c118cea2e25d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal46848001facf1cdb1a84c118cea2e25d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.users','data' => ['class' => 'h-8 w-8 text-blue-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.users'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-blue-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal46848001facf1cdb1a84c118cea2e25d)): ?>
<?php $attributes = $__attributesOriginal46848001facf1cdb1a84c118cea2e25d; ?>
<?php unset($__attributesOriginal46848001facf1cdb1a84c118cea2e25d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal46848001facf1cdb1a84c118cea2e25d)): ?>
<?php $component = $__componentOriginal46848001facf1cdb1a84c118cea2e25d; ?>
<?php unset($__componentOriginal46848001facf1cdb1a84c118cea2e25d); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Customer Reports</h3>
                                <p class="text-sm text-gray-500">Booking history and customer statistics</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo e(route('admin.reports.customer')); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Financial Reports -->
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
                                <h3 class="text-lg font-medium text-gray-900">Financial Reports</h3>
                                <p class="text-sm text-gray-500">Profit/loss and revenue analysis</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo e(route('admin.reports.financial')); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal76aa02719abeb9a1a42530834e80b874 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal76aa02719abeb9a1a42530834e80b874 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.car','data' => ['class' => 'h-8 w-8 text-purple-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.car'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-purple-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal76aa02719abeb9a1a42530834e80b874)): ?>
<?php $attributes = $__attributesOriginal76aa02719abeb9a1a42530834e80b874; ?>
<?php unset($__attributesOriginal76aa02719abeb9a1a42530834e80b874); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal76aa02719abeb9a1a42530834e80b874)): ?>
<?php $component = $__componentOriginal76aa02719abeb9a1a42530834e80b874; ?>
<?php unset($__componentOriginal76aa02719abeb9a1a42530834e80b874); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Vehicle Reports</h3>
                                <p class="text-sm text-gray-500">Utilization and revenue per vehicle</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo e(route('admin.reports.vehicle')); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Reports -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Analytics Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal0eb582c370058102933a94667aeb70b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eb582c370058102933a94667aeb70b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.chart-bar','data' => ['class' => 'h-8 w-8 text-indigo-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.chart-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-indigo-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eb582c370058102933a94667aeb70b4)): ?>
<?php $attributes = $__attributesOriginal0eb582c370058102933a94667aeb70b4; ?>
<?php unset($__attributesOriginal0eb582c370058102933a94667aeb70b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eb582c370058102933a94667aeb70b4)): ?>
<?php $component = $__componentOriginal0eb582c370058102933a94667aeb70b4; ?>
<?php unset($__componentOriginal0eb582c370058102933a94667aeb70b4); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Analytics Dashboard</h3>
                                <p class="text-sm text-gray-500">Comprehensive business analytics and trends</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo e(route('admin.reports.analytics')); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Analytics
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profitability Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.trending-up','data' => ['class' => 'h-8 w-8 text-emerald-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.trending-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-emerald-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2)): ?>
<?php $attributes = $__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2; ?>
<?php unset($__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2)): ?>
<?php $component = $__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2; ?>
<?php unset($__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Profitability Analysis</h3>
                                <p class="text-sm text-gray-500">Vehicle ROI and profit margin analysis</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo e(route('admin.reports.profitability')); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Analyze Profitability
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Customer LTV Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal6a0d3005e792973cc5c150700f936f03 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a0d3005e792973cc5c150700f936f03 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user-group','data' => ['class' => 'h-8 w-8 text-pink-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-pink-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a0d3005e792973cc5c150700f936f03)): ?>
<?php $attributes = $__attributesOriginal6a0d3005e792973cc5c150700f936f03; ?>
<?php unset($__attributesOriginal6a0d3005e792973cc5c150700f936f03); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a0d3005e792973cc5c150700f936f03)): ?>
<?php $component = $__componentOriginal6a0d3005e792973cc5c150700f936f03; ?>
<?php unset($__componentOriginal6a0d3005e792973cc5c150700f936f03); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Customer Lifetime Value</h3>
                                <p class="text-sm text-gray-500">Customer value and loyalty analysis</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="<?php echo e(route('admin.reports.customer-ltv')); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Customer LTV
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Statistics (Last 30 Days)</h3>
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.dashboard-stats', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-731784954-0', null);

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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\reports\index.blade.php ENDPATH**/ ?>