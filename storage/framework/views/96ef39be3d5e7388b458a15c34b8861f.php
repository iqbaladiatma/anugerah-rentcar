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
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-r from-blue-600 to-blue-800 text-white">
        <div class="absolute inset-0 bg-black opacity-20"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Find Your Perfect
                    <span class="text-yellow-400">Rental Car</span>
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Reliable, affordable, and convenient car rental services for all your needs
                </p>
                
                <!-- Vehicle Search Widget -->
                <div class="max-w-4xl mx-auto">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('public.vehicle-search-widget', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3970840439-0', null);

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
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Why Choose Anugerah Rentcar?</h2>
                <p class="text-lg text-gray-600">We provide the best car rental experience with these amazing features</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality Vehicles</h3>
                    <p class="text-gray-600">Well-maintained and regularly serviced vehicles for your safety and comfort</p>
                </div>

                <!-- Feature 2 -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Competitive Pricing</h3>
                    <p class="text-gray-600">Transparent pricing with no hidden fees. Special discounts for members</p>
                </div>

                <!-- Feature 3 -->
                <div class="text-center p-6">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">24/7 Support</h3>
                    <p class="text-gray-600">Round-the-clock customer support for any assistance you need</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Vehicles Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Popular Vehicles</h2>
                <p class="text-lg text-gray-600">Choose from our wide selection of quality rental cars</p>
            </div>

            <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('public.popular-vehicles', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3970840439-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">How It Works</h2>
                <p class="text-lg text-gray-600">Simple steps to get your rental car</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Step 1 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        1
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Search & Select</h3>
                    <p class="text-gray-600">Browse available vehicles and choose the perfect car for your needs</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        2
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Book Online</h3>
                    <p class="text-gray-600">Complete your booking with our secure online reservation system</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        3
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Verify Documents</h3>
                    <p class="text-gray-600">Upload your KTP and driving license for verification</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center">
                    <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                        4
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Pick Up & Go</h3>
                    <p class="text-gray-600">Collect your vehicle and enjoy your journey</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-16 bg-blue-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-4">Ready to Start Your Journey?</h2>
            <p class="text-xl mb-8 text-blue-100">Join thousands of satisfied customers who trust us with their transportation needs</p>
            <div class="space-x-4">
                <a href="<?php echo e(route('vehicles.catalog')); ?>" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                    Browse Vehicles
                </a>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->guest()): ?>
                    <a href="<?php echo e(route('customer.register')); ?>" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors inline-block">
                        Register Now
                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </section>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\public\home.blade.php ENDPATH**/ ?>