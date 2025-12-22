<div>
    <!-- Walk-in Booking Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show_modal): ?>
        <div class="fixed inset-0 z-50 overflow-hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-gray-900/70 backdrop-blur-sm transition-opacity" wire:click="closeModal"></div>
            
            <!-- Modal Container -->
            <div class="fixed inset-0 flex items-start sm:items-center justify-center p-2 pt-4 pb-20 sm:p-4 sm:pb-4 overflow-y-auto">
                <!-- Modal Content -->
                <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-2xl flex flex-col max-h-[80vh] sm:max-h-[85vh]">
                    
                    <!-- Header - Fixed at top -->
                    <div class="flex-shrink-0 rounded-t-2xl bg-gradient-to-r from-green-600 to-green-700 px-4 py-3 sm:py-4 sm:px-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="hidden sm:flex h-10 w-10 items-center justify-center rounded-full bg-white/20">
                                    <svg class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-base sm:text-lg font-bold text-white" id="modal-title">Pemesanan Walk-in</h3>
                                    <p class="text-xs text-green-100 hidden sm:block">Data dikelola langsung oleh admin</p>
                                </div>
                            </div>
                            <button wire:click="closeModal" type="button" 
                                    class="rounded-full p-2 text-white/80 hover:bg-white/20 hover:text-white transition-colors">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Scrollable Content -->
                    <div class="flex-1 overflow-y-auto p-4 sm:p-5 space-y-4">
                        
                        <!-- Error Messages -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                            <div class="rounded-lg bg-red-50 p-3 border border-red-200">
                                <div class="flex items-center gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm text-red-700"><?php echo e(session('error')); ?></span>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- Section: Data Pelanggan -->
                        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                            <div class="bg-gray-50 px-3 py-2 sm:px-4 sm:py-3 border-b border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Data Pelanggan
                                </h4>
                            </div>
                            <div class="p-3 sm:p-4 space-y-3">
                                <!-- Toggle Mode -->
                                <div class="flex rounded-lg bg-gray-100 p-1">
                                    <button type="button" 
                                            wire:click="$set('customer_mode', 'existing')"
                                            class="flex-1 py-2 px-3 text-xs sm:text-sm font-medium rounded-md transition-colors <?php echo e($customer_mode === 'existing' ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                                        Pelanggan Terdaftar
                                    </button>
                                    <button type="button" 
                                            wire:click="$set('customer_mode', 'new')"
                                            class="flex-1 py-2 px-3 text-xs sm:text-sm font-medium rounded-md transition-colors <?php echo e($customer_mode === 'new' ? 'bg-white text-green-700 shadow-sm' : 'text-gray-600 hover:text-gray-900'); ?>">
                                        Buat Baru
                                    </button>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer_mode === 'existing'): ?>
                                    <!-- Existing Customer Selection -->
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Pelanggan <span class="text-red-500">*</span></label>
                                        <select wire:model.live="customer_id" 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="">-- Pilih Pelanggan --</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($customer['id']); ?>">
                                                    <?php echo e($customer['name']); ?> - <?php echo e($customer['phone']); ?>

                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer['is_member']): ?> (Member) <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['customer_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer_id): ?>
                                            <?php $selectedCustomer = $this->getSelectedCustomer(); ?>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedCustomer): ?>
                                                <div class="mt-2 p-2 bg-green-50 rounded-lg text-xs text-green-800">
                                                    <div class="font-medium"><?php echo e($selectedCustomer['name']); ?></div>
                                                    <div><?php echo e($selectedCustomer['phone']); ?> <?php echo e($selectedCustomer['email'] ? '• ' . $selectedCustomer['email'] : ''); ?></div>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($selectedCustomer['is_member']): ?>
                                                        <div class="mt-2 pt-2 border-t border-green-200">
                                                            <label class="flex items-center cursor-pointer">
                                                                <input type="checkbox" wire:model.live="apply_member_discount" 
                                                                       class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                                                <span class="ml-2 text-sm font-medium text-green-800">Terapkan Diskon Member</span>
                                                            </label>
                                                            <p class="mt-1 text-xs text-green-600">
                                                                Member mendapat diskon khusus untuk setiap pemesanan.
                                                            </p>
                                                        </div>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <!-- New Customer Form -->
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model="new_customer_name" 
                                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="Nama pelanggan">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_customer_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Telepon <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model="new_customer_phone" 
                                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="08xxxxxxxxxx">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['new_customer_phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                                            <input type="email" wire:model="new_customer_email" 
                                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="Opsional">
                                        </div>
                                        <div>
                                            <label class="block text-xs font-medium text-gray-700 mb-1">NIK/SIM</label>
                                            <input type="text" wire:model="new_customer_id_number" 
                                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="Opsional">
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Alamat</label>
                                            <input type="text" wire:model="new_customer_address" 
                                                   class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="Opsional">
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 bg-blue-50 p-2 rounded-lg">
                                        <svg class="inline h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Pelanggan baru akan otomatis terdaftar di sistem.
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Section: Kendaraan & Jadwal -->
                        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                            <div class="bg-gray-50 px-3 py-2 sm:px-4 sm:py-3 border-b border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                    Kendaraan & Jadwal
                                </h4>
                            </div>
                            <div class="p-3 sm:p-4 space-y-3">
                                <!-- Kendaraan -->
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Kendaraan <span class="text-red-500">*</span></label>
                                    <select wire:model.live="car_id" 
                                            class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                        <option value="">-- Pilih --</option>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($car['id']); ?>">
                                                <?php echo e($car['license_plate']); ?> - <?php echo e($car['brand']); ?> <?php echo e($car['model']); ?> 
                                                (Rp <?php echo e(number_format($car['daily_rate'], 0, ',', '.')); ?>/hari)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </select>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['car_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($availability)): ?>
                                        <div class="mt-1.5 flex items-center gap-1 text-xs <?php echo e($availability['is_available'] ?? false ? 'text-green-600' : 'text-red-600'); ?>">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($availability['is_available'] ?? false): ?>
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                                <span>Tersedia</span>
                                            <?php else: ?>
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                <span><?php echo e($availability['error'] ?? 'Tidak tersedia'); ?></span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                <!-- Tanggal -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Mulai <span class="text-red-500">*</span></label>
                                        <input type="datetime-local" wire:model.live="start_date" 
                                               class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Selesai <span class="text-red-500">*</span></label>
                                        <input type="datetime-local" wire:model.live="end_date" 
                                               class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>

                                <!-- Lokasi -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Lokasi Ambil <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="pickup_location" 
                                               class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                               placeholder="Lokasi ambil">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['pickup_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Lokasi Kembali <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="return_location" 
                                               class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                               placeholder="Lokasi kembali">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['return_location'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-xs text-red-500"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>

                                <!-- Options -->
                                <div class="flex flex-wrap gap-4">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="with_driver" 
                                               class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                        <span class="ml-2 text-sm text-gray-700">Dengan Sopir</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:model.live="is_out_of_town" 
                                               class="h-4 w-4 rounded border-gray-300 text-green-600 focus:ring-green-500">
                                        <span class="ml-2 text-sm text-gray-700">Luar Kota</span>
                                    </label>
                                </div>

                                <!-- Conditional Fields -->
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($with_driver): ?>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Sopir</label>
                                        <select wire:model="driver_id" 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="">-- Pilih --</option>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $available_drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($driver['id']); ?>"><?php echo e($driver['name']); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </select>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_out_of_town): ?>
                                    <div x-data="{ 
                                        display: '', 
                                        init() { 
                                            this.display = this.formatRupiah($wire.out_of_town_fee || 0); 
                                        },
                                        formatRupiah(value) {
                                            return new Intl.NumberFormat('id-ID').format(value || 0);
                                        },
                                        updateValue(e) {
                                            let raw = e.target.value.replace(/\D/g, '');
                                            $wire.out_of_town_fee = parseInt(raw) || 0;
                                            this.display = this.formatRupiah(raw);
                                        }
                                    }" x-init="$watch('$wire.out_of_town_fee', val => display = formatRupiah(val))">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Biaya Luar Kota</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-500 text-sm">Rp</span>
                                            <input type="text" 
                                                   x-model="display"
                                                   @input="updateValue($event)"
                                                   class="block w-full pl-10 rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                                   placeholder="0">
                                        </div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Section: Rincian Harga -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show_pricing && !empty($pricing)): ?>
                            <div class="rounded-xl border-2 border-green-200 bg-green-50 overflow-hidden">
                                <div class="bg-green-100 px-3 py-2 sm:px-4 sm:py-3 border-b border-green-200">
                                    <h4 class="text-sm font-semibold text-green-800 flex items-center gap-2">
                                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        Rincian Harga
                                    </h4>
                                </div>
                                <div class="p-3 sm:p-4">
                                    <div class="space-y-1.5 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Durasi</span>
                                            <span class="font-medium"><?php echo e($pricing['duration_days'] ?? 0); ?> hari</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Harga Dasar</span>
                                            <span><?php echo e($this->formatCurrency($pricing['base_amount'] ?? 0)); ?></span>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($pricing['driver_fee'] ?? 0) > 0): ?>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Sopir</span>
                                                <span><?php echo e($this->formatCurrency($pricing['driver_fee'])); ?></span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($is_out_of_town && $out_of_town_fee > 0): ?>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Luar Kota</span>
                                                <span><?php echo e($this->formatCurrency($out_of_town_fee)); ?></span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($pricing['member_discount'] ?? 0) > 0): ?>
                                            <div class="flex justify-between text-red-600">
                                                <span class="flex items-center gap-1">
                                                    <svg class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                    </svg>
                                                    Diskon Member
                                                </span>
                                                <span>- <?php echo e($this->formatCurrency($pricing['member_discount'])); ?></span>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="border-t border-green-300 pt-2 mt-2">
                                            <div class="flex justify-between">
                                                <span class="font-bold text-green-800">Total</span>
                                                <span class="font-bold text-green-800"><?php echo e($this->formatCurrency($pricing['total_amount'] ?? 0)); ?></span>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($pricing['member_discount'] ?? 0) > 0): ?>
                                                <p class="text-xs text-green-600 mt-1">
                                                    Hemat <?php echo e($this->formatCurrency($pricing['member_discount'])); ?> dengan diskon member!
                                                </p>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- Validation Errors -->
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($validation_errors)): ?>
                            <div class="rounded-lg bg-red-50 p-3 border border-red-200">
                                <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $validation_errors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- Section: Pembayaran & Status -->
                        <div class="rounded-xl border border-gray-200 bg-white overflow-hidden">
                            <div class="bg-gray-50 px-3 py-2 sm:px-4 sm:py-3 border-b border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-900 flex items-center gap-2">
                                    <svg class="h-4 w-4 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Pembayaran & Status
                                </h4>
                            </div>
                            <div class="p-3 sm:p-4 space-y-3">
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Tipe Bayar</label>
                                        <select wire:model.live="payment_type" 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="full">Lunas</option>
                                            <option value="deposit">DP</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status Bayar</label>
                                        <select wire:model="payment_status" 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="paid">Lunas</option>
                                            <option value="partial">Sebagian</option>
                                            <option value="pending">Belum</option>
                                        </select>
                                    </div>
                                    <div x-data="{ 
                                        display: '', 
                                        init() { 
                                            this.display = this.formatRupiah($wire.paid_amount || 0); 
                                        },
                                        formatRupiah(value) {
                                            return new Intl.NumberFormat('id-ID').format(value || 0);
                                        },
                                        updateValue(e) {
                                            let raw = e.target.value.replace(/\D/g, '');
                                            $wire.paid_amount = parseInt(raw) || 0;
                                            this.display = this.formatRupiah(raw);
                                        }
                                    }" x-init="$watch('$wire.paid_amount', val => display = formatRupiah(val))">
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Dibayar</label>
                                        <div class="relative">
                                            <span class="absolute inset-y-0 left-0 flex items-center pl-2 text-gray-500 text-xs">Rp</span>
                                            <input type="text" 
                                                   x-model="display"
                                                   @input="updateValue($event)"
                                                   class="block w-full pl-8 rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Status</label>
                                        <select wire:model="booking_status" 
                                                class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500">
                                            <option value="active">Aktif</option>
                                            <option value="confirmed">Konfirmasi</option>
                                            <option value="pending">Pending</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Catatan</label>
                                    <textarea wire:model="notes" rows="2"
                                              class="block w-full rounded-lg border-gray-300 shadow-sm text-sm focus:border-green-500 focus:ring-green-500"
                                              placeholder="Catatan (opsional)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer - Fixed at bottom -->
                    <div class="flex-shrink-0 rounded-b-2xl border-t border-gray-200 bg-gray-50 px-4 py-3 sm:px-6 sm:py-4">
                        <div class="flex flex-col-reverse gap-2 sm:flex-row sm:justify-end sm:gap-3">
                            <button wire:click="closeModal" type="button"
                                    class="w-full sm:w-auto rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                                Batal
                            </button>
                            <button wire:click="createBooking" type="button"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="opacity-60"
                                    <?php if(empty($availability['is_available'])): ?> disabled <?php endif; ?>
                                    class="w-full sm:w-auto inline-flex items-center justify-center rounded-lg bg-green-600 px-5 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                                <span wire:loading.remove wire:target="createBooking" class="flex items-center">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Buat Pemesanan
                                </span>
                                <span wire:loading wire:target="createBooking" class="flex items-center">
                                    <svg class="animate-spin h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                    </svg>
                                    Memproses...
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>
<?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/walkin-booking-form.blade.php ENDPATH**/ ?>