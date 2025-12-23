<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= $totalSteps; $i++): ?>
                    <div class="flex items-center <?php echo e($i < $totalSteps ? 'flex-1' : ''); ?>">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 
                            <?php echo e($currentStep >= $i ? 'bg-accent-500 border-accent-500 text-white' : 'border-gray-300 text-gray-500'); ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep > $i): ?>
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            <?php else: ?>
                                <?php echo e($i); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($i < $totalSteps): ?>
                            <div class="flex-1 h-0.5 mx-4 <?php echo e($currentStep > $i ? 'bg-accent-500' : 'bg-gray-300'); ?>"></div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="flex justify-between mt-2 text-sm">
                <span class="<?php echo e($currentStep >= 1 ? 'text-accent-600 font-medium' : 'text-gray-500'); ?>">Pilih Kendaraan</span>
                <span class="<?php echo e($currentStep >= 2 ? 'text-accent-600 font-medium' : 'text-gray-500'); ?>">Detail Harga</span>
                <span class="<?php echo e($currentStep >= 3 ? 'text-accent-600 font-medium' : 'text-gray-500'); ?>">Info Pelanggan</span>
                <span class="<?php echo e($currentStep >= 4 ? 'text-accent-600 font-medium' : 'text-gray-500'); ?>">Dokumen</span>
                <span class="<?php echo e($currentStep >= 5 ? 'text-accent-600 font-medium' : 'text-gray-500'); ?>">Konfirmasi</span>
            </div>
        </div>

        <!-- Error Messages -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($errors)): ?>
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- Step Content -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep === 1): ?>
                <!-- Step 1: Vehicle Selection -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Pilih Kendaraan & Tanggal</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Date Selection -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Periode Sewa</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tanggal Ambil</label>
                                        <input type="date" wire:model.live="startDate" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               min="<?php echo e(date('Y-m-d')); ?>">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tanggal Kembali</label>
                                        <input type="date" wire:model.live="endDate" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               min="<?php echo e($startDate); ?>">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pengambilan</label>
                                <input type="text" wire:model="pickupLocation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                       placeholder="Masukkan lokasi pengambilan">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pengembalian</label>
                                <input type="text" wire:model="returnLocation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                       placeholder="Masukkan lokasi pengembalian">
                            </div>

                            <div class="space-y-3">
                                <div class="mt-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Layanan</label>
                                    <div class="flex space-x-4">
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" wire:model.live="withDriver" value="0" class="w-4 h-4 text-accent-600 border-gray-300 focus:ring-accent-500">
                                            <span class="ml-2 text-sm text-gray-700">Lepas Kunci</span>
                                        </label>
                                        <label class="flex items-center cursor-pointer">
                                            <input type="radio" wire:model.live="withDriver" value="1" class="w-4 h-4 text-accent-600 border-gray-300 focus:ring-accent-500">
                                            <span class="ml-2 text-sm text-gray-700">Dengan Sopir</span>
                                        </label>
                                    </div>
                                </div>

                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="isOutOfTown" 
                                           class="w-4 h-4 text-accent-600 border-gray-300 rounded focus:ring-accent-500">
                                    <span class="ml-2 text-sm text-gray-700">Perjalanan Luar Kota</span>
                                </label>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOutOfTown): ?>
                                    <div class="ml-6">
                                        <label class="block text-xs text-gray-500 mb-1">Biaya Tambahan</label>
                                        <input type="number" wire:model.live="outOfTownFee" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               placeholder="Masukkan biaya tambahan" min="0">
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Vehicle Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Kendaraan Tersedia</label>
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $availableCars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $availableCar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <div class="border rounded-lg p-4 cursor-pointer transition-all
                                        <?php echo e($selectedCarId == $availableCar->id ? 'border-accent-500 bg-accent-50' : 'border-gray-200 hover:border-gray-300'); ?>"
                                         wire:click="$set('selectedCarId', <?php echo e($availableCar->id); ?>)">
                                        <div class="flex items-center space-x-4">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availableCar->photo_front): ?>
                                                <img src="<?php echo e(asset('storage/' . $availableCar->photo_front)); ?>" 
                                                     alt="<?php echo e($availableCar->brand); ?> <?php echo e($availableCar->model); ?>"
                                                     class="w-16 h-12 object-cover rounded">
                                            <?php else: ?>
                                                <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                    </svg>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900"><?php echo e($availableCar->brand); ?> <?php echo e($availableCar->model); ?></h4>
                                                <p class="text-sm text-gray-500"><?php echo e($availableCar->year); ?> • <?php echo e($availableCar->color); ?></p>
                                                <p class="text-lg font-bold text-accent-600">Rp <?php echo e(number_format($availableCar->daily_rate, 0, ',', '.')); ?>/day</p>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedCarId == $availableCar->id): ?>
                                                <svg class="w-5 h-5 text-accent-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.175-5.5-2.709"/>
                                        </svg>
                                        <p>No vehicles available for selected dates</p>
                                        <p class="text-sm">Try different dates or check back later</p>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($currentStep === 2): ?>
                <!-- Step 2: Pricing Details -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Harga</h2>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car && !empty($pricingData)): ?>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Selected Vehicle Info -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Selected Vehicle</h3>
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center space-x-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car->photo_front): ?>
                                            <img src="<?php echo e(asset('storage/' . $car->photo_front)); ?>" 
                                                 alt="<?php echo e($car->brand); ?> <?php echo e($car->model); ?>"
                                                 class="w-20 h-16 object-cover rounded">
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div>
                                            <h4 class="font-medium text-gray-900"><?php echo e($car->brand); ?> <?php echo e($car->model); ?></h4>
                                            <p class="text-sm text-gray-500"><?php echo e($car->year); ?> • <?php echo e($car->color); ?> • <?php echo e($car->license_plate); ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-900 mb-3">Rental Details</h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Pickup Date:</span>
                                            <span class="font-medium"><?php echo e(\Carbon\Carbon::parse($startDate)->format('M d, Y')); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Return Date:</span>
                                            <span class="font-medium"><?php echo e(\Carbon\Carbon::parse($endDate)->format('M d, Y')); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Duration:</span>
                                            <span class="font-medium"><?php echo e($pricingData['duration_days'] ?? 0); ?> days</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">With Driver:</span>
                                            <span class="font-medium"><?php echo e($withDriver ? 'Yes' : 'No'); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Out of Town:</span>
                                            <span class="font-medium"><?php echo e($isOutOfTown ? 'Yes' : 'No'); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Breakdown -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Breakdown</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Vehicle Rental (<?php echo e($pricingData['duration_days'] ?? 0); ?> days)</span>
                                        <span class="font-medium">Rp <?php echo e(number_format($pricingData['base_amount'] ?? 0, 0, ',', '.')); ?></span>
                                    </div>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($withDriver && ($pricingData['driver_fee'] ?? 0) > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Driver Fee (<?php echo e($pricingData['duration_days'] ?? 0); ?> days)</span>
                                            <span class="font-medium">Rp <?php echo e(number_format($pricingData['driver_fee'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOutOfTown && ($pricingData['out_of_town_fee'] ?? 0) > 0): ?>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Out of Town Fee</span>
                                            <span class="font-medium">Rp <?php echo e(number_format($pricingData['out_of_town_fee'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($pricingData['member_discount'] ?? 0) > 0): ?>
                                        <div class="flex justify-between text-green-600">
                                            <span>Member Discount</span>
                                            <span class="font-medium">-Rp <?php echo e(number_format($pricingData['member_discount'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <div class="border-t pt-3">
                                        <div class="flex justify-between text-lg font-bold">
                                            <span>Total Amount</span>
                                            <span class="text-accent-600">Rp <?php echo e(number_format($pricingData['total_amount'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                                            <span>Deposit Required</span>
                                            <span>Rp <?php echo e(number_format($pricingData['deposit_amount'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>
                                </div>

                                    <div class="mt-4 flex items-start bg-accent-50 p-4 rounded-lg">
                                        <svg class="w-5 h-5 text-accent-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                        </svg>
                                        <div class="text-sm text-accent-800">
                                            <p class="font-medium">Payment Information</p>
                                            <p class="mt-1">A deposit is required to secure your booking. The remaining balance can be paid upon vehicle pickup.</p>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-500 mx-auto mb-4"></div>
                            <p class="text-gray-600">Calculating pricing...</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

            <?php elseif($currentStep === 3): ?>
                <!-- Step 3: Customer Information -->
                <div class="p-6" wire:key="step-3-content">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pelanggan</h2>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$customer): ?>
                        <!-- Login/Register Toggle -->
                        <div class="mb-6">
                            <div class="flex rounded-lg bg-gray-100 p-1">
                                <button type="button" 
                                        wire:click="$set('isExistingCustomer', false)"
                                        class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-colors
                                            <?php echo e(!$isExistingCustomer ? 'bg-white text-accent-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                                    Pelanggan Baru
                                </button>
                                <button type="button" 
                                        wire:click="$set('isExistingCustomer', true)"
                                        class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-colors
                                            <?php echo e($isExistingCustomer ? 'bg-white text-accent-600 shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                                    Sudah Punya Akun
                                </button>
                            </div>
                        </div>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isExistingCustomer): ?>
                            <!-- Login Form -->
                            <div class="max-w-md mx-auto">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" wire:model="customerEmail" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               placeholder="Enter your email">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" wire:model="customerPassword" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               placeholder="Enter your password">
                                    </div>
                                    <button type="button" wire:click="authenticateCustomer" 
                                            class="w-full bg-accent-500 text-white py-2 px-4 rounded-lg hover:bg-accent-600 transition-colors font-medium">
                                        Login & Continue
                                    </button>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- Registration Form -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" wire:model="customerName" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your full name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" wire:model="customerPhone" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your phone number">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" wire:model="customerEmail" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your email">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 digits)</label>
                                    <input type="text" wire:model="customerNik" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your NIK" maxlength="16">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea wire:model="customerAddress" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="Enter your complete address"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <input type="password" wire:model="customerPassword" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Create a password (min. 8 characters)">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                    <input type="password" wire:model="customerPasswordConfirmation" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Confirm your password">
                                </div>
                            </div>
                            
                            <div class="mt-6 text-center">
                                <button type="button" wire:click="registerCustomer" 
                                        class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    Register & Continue
                                </button>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php else: ?>
                        <!-- Customer Info Display -->
                        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm">
                            <div class="flex justify-between items-start mb-6">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Data Diri Pemesan</h3>
                                    <p class="text-sm text-gray-500">Informasi ini akan digunakan untuk pemesanan Anda.</p>
                                </div>
                                <a href="<?php echo e(route('customer.profile')); ?>" target="_blank" class="text-sm text-accent-600 hover:text-accent-700 font-medium flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Ubah Data
                                </a>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                                    <p class="text-gray-900 font-medium"><?php echo e($customer->name); ?></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Email</label>
                                    <p class="text-gray-900 font-medium"><?php echo e($customer->email); ?></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nomor Telepon</label>
                                    <p class="text-gray-900 font-medium"><?php echo e($customer->phone); ?></p>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">NIK</label>
                                    <p class="text-gray-900 font-medium"><?php echo e($customer->nik); ?></p>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Alamat Lengkap</label>
                                    <p class="text-gray-900 font-medium"><?php echo e($customer->address); ?></p>
                                </div>
                            </div>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_member): ?>
                                <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <div>
                                        <p class="text-sm font-medium text-green-800">Status Member Aktif</p>
                                        <p class="text-xs text-green-600">Anda berhak mendapatkan diskon khusus member.</p>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

            <?php elseif($currentStep === 4): ?>
                <!-- Step 4: Document Upload -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Upload Dokumen yang Diperlukan</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- KTP Upload -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">KTP (Identity Card)</h3>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer && $customer->ktp_photo && !$ktpPhoto): ?>
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-green-800 font-medium">KTP already uploaded</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($ktpPhotoPreview): ?>
                                        <div class="mb-4">
                                            <img src="<?php echo e($ktpPhotoPreview); ?>" alt="KTP Preview" class="max-w-full h-48 mx-auto rounded">
                                            <button type="button" wire:click="removeKtpPhoto" 
                                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                Remove Photo
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="text-sm text-gray-600 mb-4">
                                            <label for="ktpPhoto" class="cursor-pointer">
                                                <span class="text-blue-600 hover:text-blue-500 font-medium">Click to upload</span>
                                                <span> or drag and drop</span>
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 10MB</p>
                                        </div>
                                        <input id="ktpPhoto" type="file" wire:model="ktpPhoto" accept="image/*" class="hidden">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- SIM Upload -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">SIM (Driving License)</h3>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer && $customer->sim_photo && !$simPhoto): ?>
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-green-800 font-medium">SIM already uploaded</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($simPhotoPreview): ?>
                                        <div class="mb-4">
                                            <img src="<?php echo e($simPhotoPreview); ?>" alt="SIM Preview" class="max-w-full h-48 mx-auto rounded">
                                            <button type="button" wire:click="removeSimPhoto" 
                                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                Remove Photo
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="text-sm text-gray-600 mb-4">
                                            <label for="simPhoto" class="cursor-pointer">
                                                <span class="text-blue-600 hover:text-blue-500 font-medium">Click to upload</span>
                                                <span> or drag and drop</span>
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 10MB</p>
                                        </div>
                                        <input id="simPhoto" type="file" wire:model="simPhoto" accept="image/*" class="hidden">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- KK Upload (Kartu Keluarga) -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Kartu Keluarga (KK)</h3>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer && $customer->kk_photo && !$kkPhoto): ?>
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-green-800 font-medium">KK already uploaded</span>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($kkPhotoPreview): ?>
                                        <div class="mb-4">
                                            <img src="<?php echo e($kkPhotoPreview); ?>" alt="KK Preview" class="max-w-full h-48 mx-auto rounded">
                                            <button type="button" wire:click="removeKkPhoto" 
                                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                Remove Photo
                                            </button>
                                        </div>
                                    <?php else: ?>
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="text-sm text-gray-600 mb-4">
                                            <label for="kkPhoto" class="cursor-pointer">
                                                <span class="text-blue-600 hover:text-blue-500 font-medium">Click to upload</span>
                                                <span> or drag and drop</span>
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 10MB</p>
                                        </div>
                                        <input id="kkPhoto" type="file" wire:model="kkPhoto" accept="image/*" class="hidden">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <p class="font-medium">Document Requirements</p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Photos must be clear and readable</li>
                                    <li>Documents must be valid and not expired</li>
                                    <li>File size should not exceed 10MB</li>
                                    <li>Accepted formats: JPG, JPEG, PNG</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            <?php elseif($currentStep === 5): ?>
                <!-- Step 5: Confirmation & Payment -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Konfirmasi Pemesanan</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Booking Summary -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Summary</h3>
                            
                            <!-- Vehicle Info -->
                            <div class="border rounded-lg p-4 mb-4">
                                <h4 class="font-medium text-gray-900 mb-2">Vehicle</h4>
                                <div class="flex items-center space-x-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($car && $car->photo_front): ?>
                                        <img src="<?php echo e(asset('storage/' . $car->photo_front)); ?>" 
                                             alt="<?php echo e($car->brand); ?> <?php echo e($car->model); ?>"
                                             class="w-16 h-12 object-cover rounded">
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div>
                                        <p class="font-medium"><?php echo e($car->brand ?? ''); ?> <?php echo e($car->model ?? ''); ?></p>
                                        <p class="text-sm text-gray-500"><?php echo e($car->year ?? ''); ?> • <?php echo e($car->color ?? ''); ?> • <?php echo e($car->license_plate ?? ''); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Details -->
                            <div class="border rounded-lg p-4 mb-4">
                                <h4 class="font-medium text-gray-900 mb-2">Rental Details</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pickup:</span>
                                        <span><?php echo e(\Carbon\Carbon::parse($startDate)->format('M d, Y')); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Return:</span>
                                        <span><?php echo e(\Carbon\Carbon::parse($endDate)->format('M d, Y')); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Duration:</span>
                                        <span><?php echo e($pricingData['duration_days'] ?? 0); ?> days</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pickup Location:</span>
                                        <span class="text-right"><?php echo e($pickupLocation); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Return Location:</span>
                                        <span class="text-right"><?php echo e($returnLocation); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Info -->
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer): ?>
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-2">Customer Information</h4>
                                    <div class="space-y-1 text-sm">
                                        <p><span class="text-gray-600">Name:</span> <?php echo e($customer->name); ?></p>
                                        <p><span class="text-gray-600">Email:</span> <?php echo e($customer->email); ?></p>
                                        <p><span class="text-gray-600">Phone:</span> <?php echo e($customer->phone); ?></p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_member): ?>
                                            <p class="text-green-600 font-medium">✓ Member Discount Applied</p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Payment & Final Steps -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                            
                            <!-- Price Summary -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>Vehicle Rental</span>
                                        <span>Rp <?php echo e(number_format($pricingData['base_amount'] ?? 0, 0, ',', '.')); ?></span>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($withDriver && ($pricingData['driver_fee'] ?? 0) > 0): ?>
                                        <div class="flex justify-between">
                                            <span>Driver Fee</span>
                                            <span>Rp <?php echo e(number_format($pricingData['driver_fee'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isOutOfTown && ($pricingData['out_of_town_fee'] ?? 0) > 0): ?>
                                        <div class="flex justify-between">
                                            <span>Out of Town Fee</span>
                                            <span>Rp <?php echo e(number_format($pricingData['out_of_town_fee'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($pricingData['member_discount'] ?? 0) > 0): ?>
                                        <div class="flex justify-between text-green-600">
                                            <span>Member Discount</span>
                                            <span>-Rp <?php echo e(number_format($pricingData['member_discount'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <div class="border-t pt-2">
                                        <div class="flex justify-between font-bold text-lg">
                                            <span>Total Amount</span>
                                            <span class="text-blue-600">Rp <?php echo e(number_format($pricingData['total_amount'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                                            <span>Deposit Required</span>
                                            <span>Rp <?php echo e(number_format($pricingData['deposit_amount'] ?? 0, 0, ',', '.')); ?></span>
                                        </div>
                                    </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all
                                        <?php echo e($paymentMethod === 'bank_transfer' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:bg-gray-50'); ?>">
                                        <input type="radio" name="paymentMethod" wire:model="paymentMethod" value="bank_transfer" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900">Bank Transfer</p>
                                            <p class="text-sm text-gray-500">Transfer ke rekening bank</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all
                                        <?php echo e($paymentMethod === 'cash' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:bg-gray-50'); ?>">
                                        <input type="radio" name="paymentMethod" wire:model="paymentMethod" value="cash" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900">Cash Payment</p>
                                            <p class="text-sm text-gray-500">Bayar di lokasi pick up</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                                <textarea wire:model="notes" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Any special requests or notes..."></textarea>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-medium">Important Information</p>
                                        <ul class="mt-1 list-disc list-inside space-y-1">
                                            <li>Booking confirmation will be sent to your email</li>
                                            <li>Vehicle pickup requires valid ID and driving license</li>
                                            <li>Deposit is refundable upon vehicle return in good condition</li>
                                            <li>Late return fees apply as per our policy</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Navigation Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep > 1): ?>
                    <button type="button" wire:click="previousStep" 
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                        ← Previous
                    </button>
                <?php else: ?>
                    <div></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($currentStep < $totalSteps): ?>
                    <button type="button" wire:click="nextStep" 
                            class="px-6 py-2 bg-accent-500 text-white rounded-lg hover:bg-accent-600 transition-colors font-medium">
                        Next →
                    </button>
                <?php else: ?>
                    <button type="button" wire:click="createBooking" 
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Complete Booking
                    </button>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/public/booking-wizard.blade.php ENDPATH**/ ?>