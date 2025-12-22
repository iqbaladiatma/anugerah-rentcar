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
            <h2 class="font-semibold text-base sm:text-lg lg:text-xl text-gray-800 leading-tight">
                <?php echo e(__('Analisis Pengeluaran')); ?>

            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('admin.expenses.create')); ?>" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <span class="hidden sm:inline">Tambah Pengeluaran</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
                <a href="<?php echo e(route('admin.expenses.index')); ?>" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <span class="hidden sm:inline">Kembali ke Pengeluaran</span>
                    <span class="sm:hidden">Kembali</span>
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.expense-analytics');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3806514644-0', null);

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
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/expenses/analytics.blade.php ENDPATH**/ ?>