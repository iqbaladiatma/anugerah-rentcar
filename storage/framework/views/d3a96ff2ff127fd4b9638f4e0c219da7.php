<div>
    <form wire:submit="save" class="space-y-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Dasar</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- License Plate (3 Parts - Indonesian Format) -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor Plat <span class="text-red-500">*</span>
                    </label>
                    <div class="flex items-center gap-2">
                        <!-- Part 1: Area Code (1 letter) -->
                        <div class="w-16">
                            <input type="text" 
                                   wire:model.blur="plate_area"
                                   maxlength="1"
                                   class="w-full text-center uppercase border border-gray-300 rounded-lg px-2 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['license_plate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="B"
                                   style="text-transform: uppercase;"
                                   oninput="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '')">
                        </div>
                        
                        <!-- Part 2: Number (1-4 digits) -->
                        <div class="w-24">
                            <input type="text" 
                                   wire:model.blur="plate_number"
                                   maxlength="4"
                                   class="w-full text-center border border-gray-300 rounded-lg px-2 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['license_plate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="1234"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        
                        <!-- Part 3: Series (1-3 letters) -->
                        <div class="w-20">
                            <input type="text" 
                                   wire:model.blur="plate_series"
                                   maxlength="3"
                                   class="w-full text-center uppercase border border-gray-300 rounded-lg px-2 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['license_plate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="ABC"
                                   style="text-transform: uppercase;"
                                   oninput="this.value = this.value.toUpperCase().replace(/[^A-Z]/g, '')">
                        </div>
                        
                        <!-- Preview -->
                        <div class="flex-1 ml-2">
                            <span class="text-sm text-gray-500">Preview:</span>
                            <span class="font-mono font-bold text-gray-800 ml-1"><?php echo e($plate_area); ?> <?php echo e($plate_number); ?> <?php echo e($plate_series); ?></span>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['license_plate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <p class="mt-1 text-xs text-gray-500">Format: 1 huruf (kode wilayah) + 1-4 angka + 1-3 huruf</p>
                </div>


                <!-- STNK Number -->
                <div>
                    <label for="stnk_number" class="block text-sm font-medium text-gray-700 mb-1">
                        Nomor STNK <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="stnk_number"
                           wire:model.blur="stnk_number"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['stnk_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Enter STNK number">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['stnk_number'];
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

                <!-- Brand -->
                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">
                        Merek <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="brand"
                           wire:model="brand"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['brand'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Toyota, Honda, etc.">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['brand'];
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

                <!-- Model -->
                <div>
                    <label for="model" class="block text-sm font-medium text-gray-700 mb-1">
                        Model <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="model"
                           wire:model="model"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['model'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="Avanza, Brio, etc.">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['model'];
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

                <!-- Year -->
                <div>
                    <label for="year" class="block text-sm font-medium text-gray-700 mb-1">
                        Tahun <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="year"
                           wire:model="year"
                           min="1900"
                           max="<?php echo e(date('Y') + 1); ?>"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="<?php echo e(date('Y')); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['year'];
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

                <!-- Color -->
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">
                        Warna <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="color"
                           wire:model="color"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="White, Black, Silver, etc.">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['color'];
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
        </div>

        <!-- Documentation & Maintenance -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Dokumen & Pemeliharaan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- STNK Expiry -->
                <div>
                    <label for="stnk_expiry" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal STNK <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="stnk_expiry"
                           wire:model="stnk_expiry"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['stnk_expiry'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['stnk_expiry'];
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

                <!-- Last Oil Change -->
                <div>
                    <label for="last_oil_change" class="block text-sm font-medium text-gray-700 mb-1">
                        Tanggal Ganti oli terakhir
                    </label>
                    <input type="date" 
                           id="last_oil_change"
                           wire:model="last_oil_change"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['last_oil_change'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['last_oil_change'];
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

                <!-- Oil Change Interval -->
                <div>
                    <label for="oil_change_interval_km" class="block text-sm font-medium text-gray-700 mb-1">
                        Interval Ganti oli (KM)
                    </label>
                    <input type="number" 
                           id="oil_change_interval_km"
                           wire:model="oil_change_interval_km"
                           min="1000"
                           max="50000"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['oil_change_interval_km'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="5000">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['oil_change_interval_km'];
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

                <!-- Current Odometer -->
                <div>
                    <label for="current_odometer" class="block text-sm font-medium text-gray-700 mb-1">
                        Odometer saat ini (KM)
                    </label>
                    <input type="number" 
                           id="current_odometer"
                           wire:model="current_odometer"
                           min="0"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['current_odometer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['current_odometer'];
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
        </div>

        <!-- Pricing Information -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Harga</h3>
            
            <!-- Pricing Reference & Packages -->
            <div class="mb-6 bg-gray-50 rounded-lg p-4 border border-gray-200">
                <h4 class="text-sm font-medium text-gray-900 mb-3">Referensi & Paket Harga</h4>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Global Settings Info -->
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><span class="font-medium">Denda Keterlambatan:</span> Rp <?php echo e(number_format($settings->late_penalty_per_hour ?? 0, 0, ',', '.')); ?>/jam</p>
                        <p><span class="font-medium">Waktu Jeda:</span> <?php echo e($settings->buffer_time_hours ?? 0); ?> jam</p>
                        <p><span class="font-medium">Diskon Member:</span> <?php echo e($settings->member_discount_percentage ?? 0); ?>%</p>
                    </div>

                    <!-- Apply Package -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Terapkan Paket Harga</label>
                        <select wire:change="applyPackage($event.target.value)" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">-- Pilih Paket --</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($rentalPackages): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $rentalPackages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($package->id); ?>">
                                        <?php echo e($package->name); ?> (<?php echo e($package->duration_hours); ?> Jam) - Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Memilih paket akan otomatis mengisi harga harian/mingguan.</p>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Daily Rate -->
                <div x-data="{
                    raw: <?php if ((object) ('daily_rate') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('daily_rate'->value()); ?>')<?php echo e('daily_rate'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('daily_rate'); ?>')<?php endif; ?>,
                    get formatted() {
                        return this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                    },
                    set formatted(value) {
                        this.raw = value.replace(/\D/g, '');
                    }
                }">
                    <label for="daily_rate" class="block text-sm font-medium text-gray-700 mb-1">
                        Harga Harian (Rp)
                    </label>
                    <input type="text" 
                           id="daily_rate"
                           x-model="formatted"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['daily_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="300000">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['daily_rate'];
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

                <!-- Weekly Rate -->
                <div x-data="{
                    raw: <?php if ((object) ('weekly_rate') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('weekly_rate'->value()); ?>')<?php echo e('weekly_rate'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('weekly_rate'); ?>')<?php endif; ?>,
                    get formatted() {
                        return this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                    },
                    set formatted(value) {
                        this.raw = value.replace(/\D/g, '');
                    }
                }">
                    <label for="weekly_rate" class="block text-sm font-medium text-gray-700 mb-1">
                        Harga Mingguan (Rp)
                    </label>
                    <input type="text" 
                           id="weekly_rate"
                           x-model="formatted"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['weekly_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="1800000">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['weekly_rate'];
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

                <!-- Driver Fee Per Day -->
                <div x-data="{
                    raw: <?php if ((object) ('driver_fee_per_day') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('driver_fee_per_day'->value()); ?>')<?php echo e('driver_fee_per_day'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('driver_fee_per_day'); ?>')<?php endif; ?>,
                    get formatted() {
                        return this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                    },
                    set formatted(value) {
                        this.raw = value.replace(/\D/g, '');
                    }
                }">
                    <label for="driver_fee_per_day" class="block text-sm font-medium text-gray-700 mb-1">
                        Biaya Driver/Hari (Rp)
                    </label>
                    <input type="text" 
                           id="driver_fee_per_day"
                           x-model="formatted"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['driver_fee_per_day'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           placeholder="100000">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['driver_fee_per_day'];
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
        </div>

        <!-- Vehicle Status -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Status Kendaraan</h3>
            
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">
                    Status <span class="text-red-500">*</span>
                </label>
                <select id="status"
                        wire:model="status"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $statusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['status'];
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

        <!-- Vehicle Photos -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Foto Kendaraan</h3>
            <p class="text-sm text-gray-600 mb-6">Upload foto dari tiga sudut: depan, samping, dan belakang. Ukuran file maksimum: 2MB per foto.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Front Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Depan</label>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_photo_front && !$remove_photo_front && !$photo_front): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(asset('storage/' . $existing_photo_front)); ?>" 
                                 alt="Current front photo" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" 
                                    wire:click="removePhoto('front')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Remove current photo
                            </button>
                        </div>
                    <?php elseif($remove_photo_front): ?>
                        <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600">Foto akan dihapus ketika disimpan.</p>
                            <button type="button" 
                                    wire:click="restorePhoto('front')"
                                    class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                Keep current photo
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo_front): ?>
                        <div class="mb-3">
                            <img src="<?php echo e($photo_front->temporaryUrl()); ?>" 
                                 alt="New front photo preview" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <input type="file" 
                           wire:model="photo_front"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['photo_front'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['photo_front'];
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

                <!-- Side Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Samping</label>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_photo_side && !$remove_photo_side && !$photo_side): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(asset('storage/' . $existing_photo_side)); ?>" 
                                 alt="Current side photo" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" 
                                    wire:click="removePhoto('side')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Remove current photo
                            </button>
                        </div>
                    <?php elseif($remove_photo_side): ?>
                        <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600">Foto akan dihapus ketika disimpan.</p>
                            <button type="button" 
                                    wire:click="restorePhoto('side')"
                                    class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                Keep current photo
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo_side): ?>
                        <div class="mb-3">
                            <img src="<?php echo e($photo_side->temporaryUrl()); ?>" 
                                 alt="New side photo preview" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <input type="file" 
                           wire:model="photo_side"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['photo_side'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['photo_side'];
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

                <!-- Back Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Foto Belakang</label>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($existing_photo_back && !$remove_photo_back && !$photo_back): ?>
                        <div class="mb-3">
                            <img src="<?php echo e(asset('storage/' . $existing_photo_back)); ?>" 
                                 alt="Current back photo" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                            <button type="button" 
                                    wire:click="removePhoto('back')"
                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                Remove current photo
                            </button>
                        </div>
                    <?php elseif($remove_photo_back): ?>
                        <div class="mb-3 p-3 bg-red-50 border border-red-200 rounded-lg">
                            <p class="text-sm text-red-600">Foto akan dihapus ketika disimpan.</p>
                            <button type="button" 
                                    wire:click="restorePhoto('back')"
                                    class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                Keep current photo
                            </button>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($photo_back): ?>
                        <div class="mb-3">
                            <img src="<?php echo e($photo_back->temporaryUrl()); ?>" 
                                 alt="New back photo preview" 
                                 class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <input type="file" 
                           wire:model="photo_back"
                           accept="image/jpeg,image/png,image/jpg"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 <?php $__errorArgs = ['photo_back'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['photo_back'];
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
        </div>

        <!-- Form Actions -->
        <div class="bg-white rounded-lg shadow-sm border p-6">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    <span class="text-red-500">*</span> Wajib diisi
                </div>
                <div class="flex items-center space-x-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isEditing && $this->vehicle && $this->vehicle->id): ?>
                        <a href="<?php echo e(route('admin.vehicles.show', $this->vehicle)); ?>" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                    <?php else: ?>
                        <a href="<?php echo e(route('admin.vehicles.index')); ?>" 
                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <button type="submit" 
                            class="px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                            wire:loading.attr="disabled">
                        <span wire:loading.remove>
                            <?php echo e($isEditing ? 'Update Vehicle' : 'Create Vehicle'); ?>

                        </span>
                        <span wire:loading>
                            <?php echo e($isEditing ? 'Updating...' : 'Creating...'); ?>

                        </span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/vehicle-form.blade.php ENDPATH**/ ?>