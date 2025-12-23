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
                <?php echo e(__('Manajemen Pelanggan')); ?>

            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('admin.customers.create')); ?>" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <?php if (isset($component)) { $__componentOriginal52632fe7b137108a4c1d9fb6383ade19 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal52632fe7b137108a4c1d9fb6383ade19 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.plus','data' => ['class' => 'w-3 h-3 sm:w-4 sm:h-4 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.plus'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 sm:w-4 sm:h-4 mr-1']); ?>
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
                    <span class="hidden sm:inline">Tambah Pelanggan</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
                <a href="<?php echo e(route('admin.customers.members')); ?>" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <?php if (isset($component)) { $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.star','data' => ['class' => 'w-3 h-3 sm:w-4 sm:h-4 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 sm:w-4 sm:h-4 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $attributes = $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $component = $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
                    Anggota
                </a>
                <a href="<?php echo e(route('admin.customers.blacklist')); ?>" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-red-500 hover:bg-red-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <?php if (isset($component)) { $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.ban','data' => ['class' => 'w-3 h-3 sm:w-4 sm:h-4 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.ban'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 sm:w-4 sm:h-4 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $attributes = $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $component = $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
                    <span class="hidden sm:inline">Daftar Hitam</span>
                    <span class="sm:hidden">Hitam</span>
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-3 sm:p-4 lg:p-6 text-gray-900">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                        <div class="bg-green-100 border border-green-400 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                            <?php echo e(session('error')); ?>

                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.customer-list', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3989122684-0', null);

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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/customers/index.blade.php ENDPATH**/ ?>