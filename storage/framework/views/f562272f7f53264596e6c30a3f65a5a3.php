<div class="max-w-4xl mx-auto">
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $totalSteps; $i++): ?>
                <div class="flex items-center <?php echo e($i < $totalSteps ? 'flex-1' : ''); ?>">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 
                        <?php echo e($currentStep >= $i ? 'bg-blue-600 border-blue-600 text-white' : 'border-gray-300 text-gray-500'); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep > $i): ?>
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        <?php else: ?>
                            <?php echo e($i); ?>

                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="ml-3 text-sm font-medium <?php echo e($currentStep >= $i ? 'text-blue-600' : 'text-gray-500'); ?>">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php switch($i):
                            case (1): ?> Booking Details <?php break; ?>
                            <?php case (2): ?> Customer Info <?php break; ?>
                            <?php case (3): ?> Documents <?php break; ?>
                            <?php case (4): ?> Payment <?php break; ?>
                        <?php endswitch; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i < $totalSteps): ?>
                        <div class="flex-1 h-0.5 mx-4 <?php echo e($currentStep > $i ? 'bg-blue-600' : 'bg-gray-300'); ?>"></div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Vehicle Summary Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100">
        <div class="flex items-center space-x-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->photo_front): ?>
                <img src="<?php echo e(asset('storage/' . $car->photo_front)); ?>" 
                     alt="<?php echo e($car->brand); ?> <?php echo e($car->model); ?>"
                     class="w-24 h-16 object-cover rounded-lg">
            <?php else: ?>
                <div class="w-24 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                    </svg>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></h3>
                <p class="text-sm text-gray-600"><?php echo e($car->year); ?> • <?php echo e($car->color); ?> • <?php echo e($car->license_plate); ?></p>
                <p class="text-sm text-blue-600 font-medium">
                    <?php echo e($startDate->format('M d, Y')); ?> - <?php echo e($endDate->format('M d, Y')); ?> (<?php echo e($duration); ?> days)
                </p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-blue-600">
                    Rp <?php echo e(number_format($pricing['total_amount'] ?? 0, 0, ',', '.')); ?>

                </div>
                <p class="text-sm text-gray-500">Total Amount</p>
            </div>
        </div>
    </div>

    <!-- Step Content -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep === 1): ?>
            <!-- Step 1: Booking Details -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Booking Details</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Location *</label>
                        <input type="text" wire:model="pickupLocation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter pickup address">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pickupLocation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Return Location *</label>
                        <input type="text" wire:model="returnLocation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Enter return address">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['returnLocation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="withDriver" id="withDriver"
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="withDriver" class="ml-3 text-sm font-medium text-gray-700">
                            Include Driver (+Rp <?php echo e(number_format($car->driver_fee_per_day, 0, ',', '.')); ?>/day)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="isOutOfTown" id="isOutOfTown"
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="isOutOfTown" class="ml-3 text-sm font-medium text-gray-700">
                            Out of Town Trip (Additional fees may apply)
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Special Notes (Optional)</label>
                    <textarea wire:model="notes" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Any special requests or notes..."></textarea>
                </div>

                <!-- Pricing Breakdown -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing Breakdown</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Base Rate (<?php echo e($duration); ?> days)</span>
                            <span class="font-medium">Rp <?php echo e(number_format($pricing['base_amount'] ?? 0, 0, ',', '.')); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($withDriver && ($pricing['driver_fee'] ?? 0) > 0): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Driver Fee</span>
                                <span class="font-medium">Rp <?php echo e(number_format($pricing['driver_fee'], 0, ',', '.')); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOutOfTown && ($pricing['out_of_town_fee'] ?? 0) > 0): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Out of Town Fee</span>
                                <span class="font-medium">Rp <?php echo e(number_format($pricing['out_of_town_fee'], 0, ',', '.')); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <div class="border-t pt-2">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total Amount</span>
                                <span class="text-blue-600">Rp <?php echo e(number_format($pricing['total_amount'] ?? 0, 0, ',', '.')); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif($currentStep === 2): ?>
            <!-- Step 2: Customer Information -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Information</h2>
                
                <div class="mb-6">
                    <div class="flex space-x-4">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="customerType" value="existing" 
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Existing Customer</span>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" wire:model="customerType" value="new" 
                                   class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">New Customer</span>
                        </label>
                    </div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customerType === 'existing'): ?>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Search Customer *</label>
                        <input type="text" wire:model.debounce.300ms="customerSearch" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Search by name, phone, or NIK...">
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($existingCustomers) > 0): ?>
                            <div class="mt-2 border border-gray-200 rounded-lg max-h-60 overflow-y-auto">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $existingCustomers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="flex items-center p-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0">
                                        <input type="radio" wire:model="existingCustomerId" value="<?php echo e($customer->id); ?>"
                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <div class="ml-3">
                                            <div class="font-medium text-gray-900"><?php echo e($customer->name); ?></div>
                                            <div class="text-sm text-gray-600"><?php echo e($customer->phone); ?> • <?php echo e($customer->nik); ?></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_member): ?>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Member
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['existingCustomerId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" wire:model="customerName" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter full name">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customerName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number *</label>
                            <input type="tel" wire:model="customerPhone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter phone number">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customerPhone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email (Optional)</label>
                            <input type="email" wire:model="customerEmail" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Enter email address">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customerEmail'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">NIK (ID Number) *</label>
                            <input type="text" wire:model="customerNik" maxlength="16"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="16-digit NIK">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customerNik'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea wire:model="customerAddress" rows="3"
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Enter complete address"></textarea>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customerAddress'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

        <?php elseif($currentStep === 3): ?>
            <!-- Step 3: Document Upload -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Identity Verification</h2>
                <p class="text-gray-600 mb-8">Please upload clear photos of your identity documents for verification purposes.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- KTP Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">KTP (Identity Card) *</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ktpPhoto): ?>
                                <div class="space-y-4">
                                    <img src="<?php echo e($ktpPhoto->temporaryUrl()); ?>" class="mx-auto max-h-40 rounded-lg shadow-md">
                                    <button type="button" wire:click="$set('ktpPhoto', null)" 
                                            class="text-sm text-red-600 hover:text-red-800">
                                        Remove Photo
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="space-y-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div>
                                        <label for="ktpPhoto" class="cursor-pointer">
                                            <span class="text-blue-600 hover:text-blue-800 font-medium">Upload KTP Photo</span>
                                            <input id="ktpPhoto" type="file" wire:model="ktpPhoto" accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['ktpPhoto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- SIM Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">SIM (Driving License) *</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($simPhoto): ?>
                                <div class="space-y-4">
                                    <img src="<?php echo e($simPhoto->temporaryUrl()); ?>" class="mx-auto max-h-40 rounded-lg shadow-md">
                                    <button type="button" wire:click="$set('simPhoto', null)" 
                                            class="text-sm text-red-600 hover:text-red-800">
                                        Remove Photo
                                    </button>
                                </div>
                            <?php else: ?>
                                <div class="space-y-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div>
                                        <label for="simPhoto" class="cursor-pointer">
                                            <span class="text-blue-600 hover:text-blue-800 font-medium">Upload SIM Photo</span>
                                            <input id="simPhoto" type="file" wire:model="simPhoto" accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['simPhoto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                </div>

                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Document Requirements</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Photos must be clear and readable</li>
                                    <li>Documents must be valid and not expired</li>
                                    <li>Files should be in JPG or PNG format, maximum 2MB</li>
                                    <li>Your information will be kept secure and confidential</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        <?php elseif($currentStep === 4): ?>
            <!-- Step 4: Payment Method -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Payment Information</h2>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Select Payment Method</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" wire:model="paymentMethod" value="bank_transfer" 
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Bank Transfer</div>
                                    <div class="text-sm text-gray-600">Transfer to our bank account</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" wire:model="paymentMethod" value="cash" 
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Cash Payment</div>
                                    <div class="text-sm text-gray-600">Pay in cash at pickup</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($paymentMethod === 'bank_transfer'): ?>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Bank Transfer Instructions</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Bank:</span>
                                    <span class="ml-2 text-sm text-gray-900">Bank BCA</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Account Number:</span>
                                    <span class="ml-2 text-sm text-gray-900 font-mono">1234567890</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Account Name:</span>
                                    <span class="ml-2 text-sm text-gray-900">PT Anugerah Rentcar</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Amount:</span>
                                    <span class="ml-2 text-sm text-gray-900 font-semibold">Rp <?php echo e(number_format($pricing['deposit_amount'] ?? 0, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    <strong>Note:</strong> Please transfer the deposit amount to confirm your booking. 
                                    The remaining balance can be paid at pickup.
                                </p>
                            </div>
                        </div>
                    <?php elseif($paymentMethod === 'cash'): ?>
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Cash Payment Instructions</h4>
                            <div class="space-y-3">
                                <p class="text-sm text-gray-700">
                                    You can pay the full amount in cash when you pick up the vehicle. 
                                    Please bring the exact amount or be prepared for change.
                                </p>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Total Amount:</span>
                                    <span class="ml-2 text-sm text-gray-900 font-semibold">Rp <?php echo e(number_format($pricing['total_amount'] ?? 0, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <strong>Note:</strong> Your booking will be confirmed immediately. 
                                    Please arrive on time for vehicle pickup.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <!-- Final Summary -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Booking Summary</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Vehicle:</span>
                                <span class="font-medium"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Duration:</span>
                                <span class="font-medium"><?php echo e($duration); ?> days</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pickup:</span>
                                <span class="font-medium"><?php echo e($pickupLocation); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Return:</span>
                                <span class="font-medium"><?php echo e($returnLocation); ?></span>
                            </div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($withDriver): ?>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Driver:</span>
                                    <span class="font-medium text-green-600">Included</span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <div class="border-t pt-2 mt-4">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total Amount:</span>
                                    <span class="text-blue-600">Rp <?php echo e(number_format($pricing['total_amount'] ?? 0, 0, ',', '.')); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
            <button type="button" wire:click="previousStep" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium
                           <?php echo e($currentStep === 1 ? 'invisible' : ''); ?>">
                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Previous
            </button>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep < $totalSteps): ?>
                <button type="button" wire:click="nextStep" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg">
                    Next
                    <svg class="w-4 h-4 inline ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            <?php else: ?>
                <button type="button" wire:click="completeBooking" 
                        class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium shadow-md hover:shadow-lg">
                    Complete Booking
                    <svg class="w-4 h-4 inline ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\livewire\booking-wizard.blade.php ENDPATH**/ ?>