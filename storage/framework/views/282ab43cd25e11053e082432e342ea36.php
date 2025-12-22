<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        
        <?php
            $settings = \App\Models\Setting::current();
        ?>
        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($settings->company_logo): ?>
            <link rel="icon" type="image/png" href="<?php echo e(asset('storage/' . $settings->company_logo)); ?>">
        <?php else: ?>
            <link rel="icon" type="image/jpeg" href="<?php echo e(asset('logo.jpg')); ?>">
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <title><?php echo e($settings->company_name ?? config('app.name', 'Anugerah Rentcar')); ?> - Panel Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <!-- Livewire Styles -->
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    </head>
    <body class="font-sans antialiased bg-white">
        <div class="min-h-screen">
            <!-- Bilah Sisi -->
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('layout.admin-sidebar', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3113744283-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            
            <!-- Area Konten Utama -->
            <div class="lg:pl-64">
                <!-- Navigasi Atas -->
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('layout.admin-header', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3113744283-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                
                <!-- Konten Halaman -->
                <main class="py-4 sm:py-6 pb-20 lg:pb-6">
                    <div class="mx-auto max-w-7xl px-3 sm:px-4 lg:px-8">
                        <!-- Judul Halaman -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($header)): ?>
                            <div class="mb-4 sm:mb-6">
                                <?php echo e($header); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        
                        <!-- Page Content -->
                        <?php echo e($slot); ?>

                    </div>
                </main>
            </div>

            <!-- Navigasi Bawah Seluler -->
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('layout.mobile-bottom-nav', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3113744283-2', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
        
        <!-- Livewire Scripts -->
        <?php if (isset($component)) { $__componentOriginal0d8d3c14ebd2b92d484be47e6c018839 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.notification','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('notification'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839)): ?>
<?php $attributes = $__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839; ?>
<?php unset($__attributesOriginal0d8d3c14ebd2b92d484be47e6c018839); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0d8d3c14ebd2b92d484be47e6c018839)): ?>
<?php $component = $__componentOriginal0d8d3c14ebd2b92d484be47e6c018839; ?>
<?php unset($__componentOriginal0d8d3c14ebd2b92d484be47e6c018839); ?>
<?php endif; ?>
        <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/layouts/admin.blade.php ENDPATH**/ ?>