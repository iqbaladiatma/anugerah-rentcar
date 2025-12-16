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
    <div class="bg-white">
        <!-- Header -->
        <div class="bg-gray-50 border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-3xl font-bold text-gray-900">Customer Support</h1>
                <p class="mt-2 text-gray-600">Get help with your bookings and account</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-6 rounded-md bg-green-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800"><?php echo e(session('success')); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Support Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-900">Submit Support Request</h2>
                            <p class="mt-1 text-sm text-gray-500">Fill out the form below and we'll get back to you within 24 hours</p>
                        </div>

                        <form method="POST" action="<?php echo e(route('customer.support.submit')); ?>" class="p-6">
                            <?php echo csrf_field(); ?>

                            <div class="grid grid-cols-1 gap-6">
                                <!-- Subject -->
                                <div>
                                    <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                                    <input type="text" 
                                           name="subject" 
                                           id="subject" 
                                           value="<?php echo e(old('subject')); ?>" 
                                           required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Brief description of your issue">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Category and Priority -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                        <select name="category" 
                                                id="category" 
                                                required
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Select a category</option>
                                            <option value="booking" <?php echo e(old('category') === 'booking' ? 'selected' : ''); ?>>Booking Issues</option>
                                            <option value="payment" <?php echo e(old('category') === 'payment' ? 'selected' : ''); ?>>Payment & Billing</option>
                                            <option value="vehicle" <?php echo e(old('category') === 'vehicle' ? 'selected' : ''); ?>>Vehicle Issues</option>
                                            <option value="general" <?php echo e(old('category') === 'general' ? 'selected' : ''); ?>>General Inquiry</option>
                                        </select>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>

                                    <div>
                                        <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                                        <select name="priority" 
                                                id="priority" 
                                                required
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Select priority</option>
                                            <option value="low" <?php echo e(old('priority') === 'low' ? 'selected' : ''); ?>>Low</option>
                                            <option value="medium" <?php echo e(old('priority') === 'medium' ? 'selected' : ''); ?>>Medium</option>
                                            <option value="high" <?php echo e(old('priority') === 'high' ? 'selected' : ''); ?>>High</option>
                                        </select>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['priority'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>

                                <!-- Related Booking -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($recentBookings->count() > 0): ?>
                                    <div>
                                        <label for="booking_id" class="block text-sm font-medium text-gray-700">Related Booking (Optional)</label>
                                        <select name="booking_id" 
                                                id="booking_id"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                            <option value="">Select a booking if this issue is related to a specific booking</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($booking->id); ?>" <?php echo e(old('booking_id') == $booking->id ? 'selected' : ''); ?>>
                                                    #<?php echo e($booking->booking_number); ?> - <?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?> 
                                                    (<?php echo e($booking->start_date->format('M d, Y')); ?>)
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['booking_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <!-- Message -->
                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                    <textarea name="message" 
                                              id="message" 
                                              rows="6" 
                                              required
                                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Please provide detailed information about your issue or question..."><?php echo e(old('message')); ?></textarea>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['message'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="mt-6">
                                <button type="submit" 
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Submit Support Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Contact Information -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Phone</p>
                                    <p class="text-sm text-gray-600">+62 123 456 7890</p>
                                    <p class="text-xs text-gray-500">Available 24/7 for emergencies</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Email</p>
                                    <p class="text-sm text-gray-600">support@anugerahrentcar.com</p>
                                    <p class="text-xs text-gray-500">Response within 24 hours</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-gray-900">Office</p>
                                    <p class="text-sm text-gray-600">Jl. Raya Utama No. 123<br>Jakarta Selatan, 12345</p>
                                    <p class="text-xs text-gray-500">Mon-Fri: 8AM-6PM, Sat: 8AM-4PM</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Section -->
                    <div class="bg-white shadow rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Frequently Asked Questions</h3>
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">How can I modify my booking?</h4>
                                <p class="text-sm text-gray-600 mt-1">You can modify your booking up to 24 hours before the start time through your booking details page.</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">What if I return the vehicle late?</h4>
                                <p class="text-sm text-gray-600 mt-1">Late returns incur hourly penalties. Contact us immediately if you expect to be late.</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">How do I cancel my booking?</h4>
                                <p class="text-sm text-gray-600 mt-1">Cancellations can be made through your booking details page. Cancellation policies apply based on timing.</p>
                            </div>
                            <div>
                                <h4 class="text-sm font-medium text-gray-900">What documents do I need?</h4>
                                <p class="text-sm text-gray-600 mt-1">You need a valid KTP and driving license (SIM). Upload them in your profile for faster processing.</p>
                            </div>
                        </div>
                    </div>

                    <!-- Emergency Contact -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-sm font-semibold text-red-800">Emergency Contact</h3>
                        </div>
                        <p class="text-sm text-red-700 mb-2">
                            For urgent issues during your rental period (accidents, breakdowns, etc.):
                        </p>
                        <p class="text-sm font-semibold text-red-800">+62 123 456 7890</p>
                        <p class="text-xs text-red-600 mt-1">Available 24/7</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\customer\support.blade.php ENDPATH**/ ?>