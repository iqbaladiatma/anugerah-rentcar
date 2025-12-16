<?php if (isset($component)) { $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06 = $attributes; } ?>
<?php $component = App\View\Components\PublicLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PublicLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Complete Your Booking</h1>
                <p class="text-lg text-gray-600">Follow the steps below to secure your vehicle reservation</p>
            </div>

            <!-- Booking Wizard Component -->
            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('public.booking-wizard', [
                'carId' => $car->id,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d')
            ]);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-1441623319-0', null);

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

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Add any additional JavaScript for the booking wizard
        document.addEventListener('livewire:load', function () {
            // Handle file upload progress
            Livewire.on('fileUploadProgress', (progress) => {
                console.log('Upload progress:', progress);
            });

            // Handle booking completion
            Livewire.on('bookingCompleted', (bookingId) => {
                console.log('Booking completed:', bookingId);
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\public\booking\wizard.blade.php ENDPATH**/ ?>