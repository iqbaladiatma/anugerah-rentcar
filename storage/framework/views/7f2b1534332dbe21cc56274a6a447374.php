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
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                <?php echo e(__('Pengeluaran Management')); ?>

            </h2>
            <a href="<?php echo e(route('admin.expenses.create')); ?>" 
               class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                <span class="hidden sm:inline">Tambah Pengeluaran Baru</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalbb585b916ac9791b47ae751e31e7a162 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb585b916ac9791b47ae751e31e7a162 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.currency-dollar','data' => ['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-green-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.currency-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-green-500']); ?>
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
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Bulan Ini</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp <?php echo e(number_format($monthlySummary['total_amount'] / 1000, 0)); ?>K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal0eb582c370058102933a94667aeb70b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eb582c370058102933a94667aeb70b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.chart-bar','data' => ['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-blue-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.chart-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-blue-500']); ?>
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
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Tahun Ini</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp <?php echo e(number_format($yearlySummary['total_amount'] / 1000, 0)); ?>K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.trending-up','data' => ['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-purple-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.trending-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-purple-500']); ?>
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
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Rata-Rata</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp <?php echo e(number_format($yearlySummary['average_monthly'] / 1000, 0)); ?>K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalec84bc158a25135b58f1df8c1cc48af1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec84bc158a25135b58f1df8c1cc48af1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.receipt-tax','data' => ['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-red-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.receipt-tax'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-6 w-6 sm:h-8 sm:w-8 text-red-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec84bc158a25135b58f1df8c1cc48af1)): ?>
<?php $attributes = $__attributesOriginalec84bc158a25135b58f1df8c1cc48af1; ?>
<?php unset($__attributesOriginalec84bc158a25135b58f1df8c1cc48af1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec84bc158a25135b58f1df8c1cc48af1)): ?>
<?php $component = $__componentOriginalec84bc158a25135b58f1df8c1cc48af1; ?>
<?php unset($__componentOriginalec84bc158a25135b58f1df8c1cc48af1); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Transaksi</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900">
                                    <?php echo e(number_format($yearlySummary['total_count'])); ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense List Component -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-3 sm:p-4 lg:p-6">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.expense-list');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3655809870-0', null);

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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/expenses/index.blade.php ENDPATH**/ ?>