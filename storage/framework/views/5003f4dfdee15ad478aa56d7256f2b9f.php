<div class="space-y-4 sm:space-y-6">
    <!-- Quick Filters and Actions -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex-1">
                <select wire:model.live="quick_filter" class="w-full sm:w-auto rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->getQuickFilterOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2 sm:gap-3">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show_actions): ?>
                    <div class="flex items-center gap-2">
                        <select wire:model="bulk_action" class="flex-1 sm:flex-none rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->getBulkActionOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                        <button wire:click="processBulkAction" type="button" 
                                class="px-3 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 whitespace-nowrap">
                            Terapkan
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <a href="<?php echo e(route('admin.bookings.create')); ?>" 
                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 transition-colors">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span class="hidden sm:inline">Pemesanan Baru</span>
                    <span class="sm:hidden">Baru</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-3">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bookings->count() > 0): ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-white shadow rounded-lg p-4 <?php echo e($this->isOverdue($booking) ? 'border-l-4 border-red-500' : ''); ?>">
                    <!-- Header -->
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <input type="checkbox" wire:model="selected_bookings" value="<?php echo e($booking->id); ?>" 
                                       class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded">
                                <div class="text-sm font-semibold text-gray-900"><?php echo e($booking->booking_number); ?></div>
                            </div>
                            <div class="text-xs text-gray-500">Dibuat <?php echo e($booking->created_at->format('d M Y')); ?></div>
                        </div>
                        <div class="flex flex-col items-end gap-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($this->getStatusBadgeClass($booking->booking_status)); ?>">
                                <?php echo e(ucfirst($booking->booking_status)); ?>

                            </span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isOverdue($booking)): ?>
                                <span class="text-xs text-red-600 font-medium">TERLAMBAT</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>

                    <!-- Customer & Vehicle Info -->
                    <div class="space-y-2 mb-3 text-sm">
                        <div>
                            <div class="text-gray-500 text-xs">Pelanggan</div>
                            <div class="font-medium text-gray-900"><?php echo e($booking->customer?->name ?? '-'); ?></div>
                            <div class="text-gray-600 text-xs"><?php echo e($booking->customer?->phone ?? '-'); ?></div>
                        </div>
                        <div>
                            <div class="text-gray-500 text-xs">Kendaraan</div>
                            <div class="font-medium text-gray-900"><?php echo e($booking->car->license_plate); ?></div>
                            <div class="text-gray-600 text-xs"><?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?></div>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->with_driver && $booking->driver): ?>
                            <div class="text-xs text-accent-600">
                                <span class="font-medium">Sopir:</span> <?php echo e($booking->driver->name); ?>

                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Dates -->
                    <div class="bg-gray-50 rounded-lg p-2 mb-3 text-xs space-y-1">
                        <div class="flex justify-between">
                            <span class="text-gray-500">Mulai:</span>
                            <span class="text-gray-900"><?php echo e($booking->start_date->format('d M Y H:i')); ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Selesai:</span>
                            <span class="text-gray-900"><?php echo e($booking->end_date->format('d M Y H:i')); ?></span>
                        </div>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->actual_return_date): ?>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Dikembalikan:</span>
                                <span class="text-gray-900"><?php echo e($booking->actual_return_date->format('d M Y H:i')); ?></span>
                            </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    <!-- Amount & Payment Status -->
                    <div class="flex items-center justify-between mb-3">
                        <div>
                            <div class="text-xs text-gray-500">Total</div>
                            <div class="text-base font-bold text-gray-900"><?php echo e($this->formatCurrency($booking->total_amount)); ?></div>
                        </div>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($this->getPaymentStatusBadgeClass($booking->payment_status)); ?>">
                            <?php echo e(ucfirst($booking->payment_status)); ?>

                        </span>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-wrap gap-2">
                        <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" 
                           class="flex-1 text-center px-3 py-1.5 bg-gray-100 text-gray-700 rounded text-xs font-medium hover:bg-gray-200">
                            Lihat
                        </a>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->booking_status === 'pending'): ?>
                            <button wire:click="confirmBooking(<?php echo e($booking->id); ?>)" 
                                    class="flex-1 px-3 py-1.5 bg-green-500 text-white rounded text-xs font-medium hover:bg-green-600">
                                Konfirmasi
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->booking_status === 'confirmed'): ?>
                            <button wire:click="activateBooking(<?php echo e($booking->id); ?>)" 
                                    class="flex-1 px-3 py-1.5 bg-accent-500 text-white rounded text-xs font-medium hover:bg-accent-600">
                                Keluar
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->booking_status === 'active'): ?>
                            <button wire:click="completeBooking(<?php echo e($booking->id); ?>)" 
                                    class="flex-1 px-3 py-1.5 bg-purple-500 text-white rounded text-xs font-medium hover:bg-purple-600">
                                Masuk
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->canBeCancelled()): ?>
                            <button wire:click="cancelBooking(<?php echo e($booking->id); ?>)" 
                                    class="flex-1 px-3 py-1.5 bg-red-500 text-white rounded text-xs font-medium hover:bg-red-600">
                                Batal
                            </button>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->canBeModified()): ?>
                            <a href="<?php echo e(route('admin.bookings.edit', $booking)); ?>" 
                               class="flex-1 text-center px-3 py-1.5 bg-yellow-500 text-white rounded text-xs font-medium hover:bg-yellow-600">
                                Edit
                            </a>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                        <!-- Delete Button -->
                        <button wire:click="deleteBooking(<?php echo e($booking->id); ?>)" 
                                class="px-3 py-1.5 bg-gray-800 text-white rounded text-xs font-medium hover:bg-gray-900"
                                title="Hapus">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Mobile Pagination -->
            <div class="mt-4">
                <?php echo e($bookings->links()); ?>

            </div>
        <?php else: ?>
            <div class="bg-white shadow rounded-lg px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pemesanan ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat pemesanan baru.</p>
                <div class="mt-6">
                    <a href="<?php echo e(route('admin.bookings.create')); ?>" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Pemesanan Baru
                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block bg-white shadow rounded-lg overflow-hidden">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bookings->count() > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" wire:model.live="select_all" 
                                       class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Detail Pemesanan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Pelanggan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kendaraan
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Jumlah
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 <?php echo e($this->isOverdue($booking) ? 'bg-red-50' : ''); ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" wire:model="selected_bookings" value="<?php echo e($booking->id); ?>" 
                                           class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($booking->booking_number); ?></div>
                                            <div class="text-sm text-gray-500">Dibuat <?php echo e($booking->created_at->format('d M Y')); ?></div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->with_driver && $booking->driver): ?>
                                                <div class="text-xs text-accent-600">Sopir: <?php echo e($booking->driver->name); ?></div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($booking->customer?->name ?? '-'); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($booking->customer?->phone ?? '-'); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($booking->car->license_plate); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div>Mulai: <?php echo e($booking->start_date->format('d M Y H:i')); ?></div>
                                        <div>Selesai: <?php echo e($booking->end_date->format('d M Y H:i')); ?></div>
                                    </div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->actual_return_date): ?>
                                        <div class="text-xs text-gray-500">
                                            Dikembalikan: <?php echo e($booking->actual_return_date->format('d M Y H:i')); ?>

                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($this->formatCurrency($booking->total_amount)); ?></div>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($this->getPaymentStatusBadgeClass($booking->payment_status)); ?>">
                                        <?php echo e(ucfirst($booking->payment_status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($this->getStatusBadgeClass($booking->booking_status)); ?>">
                                        <?php echo e(ucfirst($booking->booking_status)); ?>

                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isOverdue($booking)): ?>
                                        <div class="text-xs text-red-600 mt-1 font-medium">TERLAMBAT</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Button -->
                                        <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" 
                                           class="text-accent-600 hover:text-accent-800">
                                            Lihat
                                        </a>

                                        <!-- Status-specific Actions -->
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->booking_status === 'pending'): ?>
                                            <button wire:click="confirmBooking(<?php echo e($booking->id); ?>)" 
                                                    class="text-green-600 hover:text-green-900">
                                                Konfirmasi
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->booking_status === 'confirmed'): ?>
                                            <button wire:click="activateBooking(<?php echo e($booking->id); ?>)" 
                                                    class="text-accent-600 hover:text-accent-800">
                                                Keluar
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->booking_status === 'active'): ?>
                                            <button wire:click="completeBooking(<?php echo e($booking->id); ?>)" 
                                                    class="text-purple-600 hover:text-purple-900">
                                                Masuk
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->canBeCancelled()): ?>
                                            <button wire:click="cancelBooking(<?php echo e($booking->id); ?>)" 
                                                    class="text-red-600 hover:text-red-900">
                                                Batal
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->canBeModified()): ?>
                                            <a href="<?php echo e(route('admin.bookings.edit', $booking)); ?>" 
                                               class="text-yellow-600 hover:text-yellow-900">
                                                Edit
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                        <!-- Delete Button -->
                                        <button wire:click="deleteBooking(<?php echo e($booking->id); ?>)" 
                                                class="text-gray-600 hover:text-gray-900"
                                                title="Hapus">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Desktop Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($bookings->links()); ?>

            </div>
        <?php else: ?>
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pemesanan ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat pemesanan baru.</p>
                <div class="mt-6">
                    <a href="<?php echo e(route('admin.bookings.create')); ?>" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Pemesanan Baru
                    </a>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Confirmation Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show_confirm_modal): ?>
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="relative w-full max-w-sm mx-auto p-4 sm:p-6 border shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Konfirmasi Pemesanan</h3>
                    <div class="mt-2 py-3">
                        <p class="text-sm text-gray-500">
                            Apakah Anda yakin ingin mengonfirmasi pemesanan ini? Ini akan menandai kendaraan sebagai disewa dan pemesanan sebagai dikonfirmasi.
                        </p>
                    </div>
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-center gap-2 sm:gap-3 mt-4">
                        <button wire:click="closeConfirmModal" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                            Batal
                        </button>
                        <button wire:click="processConfirmation" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-green-500 text-white text-sm font-medium rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-colors">
                            Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Cancellation Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show_cancel_modal): ?>
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="relative w-full max-w-sm mx-auto p-4 sm:p-6 border shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4 text-center">Batalkan Pemesanan</h3>
                    <div class="mt-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700">Alasan Pembatalan (Opsional)</label>
                        <textarea wire:model="cancellation_reason" id="cancellation_reason" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm"
                                  placeholder="Masukkan alasan pembatalan..."></textarea>
                    </div>
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-center gap-2 sm:gap-3 mt-4">
                        <button wire:click="closeCancelModal" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-gray-500 text-white text-sm font-medium rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                            Kembali
                        </button>
                        <button wire:click="processCancellation" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-red-500 text-white text-sm font-medium rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300 transition-colors">
                            Batalkan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Delete Modal -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show_delete_modal): ?>
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 z-50 flex items-center justify-center p-4">
            <div class="relative w-full max-w-sm mx-auto p-4 sm:p-6 border shadow-lg rounded-lg bg-white max-h-[90vh] overflow-y-auto">
                <div>
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-gray-800">
                        <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4 text-center">Hapus Pemesanan</h3>
                    <p class="text-sm text-gray-500 mt-2 text-center">Tindakan ini tidak dapat dibatalkan. Data pemesanan akan dihapus permanen.</p>
                    <div class="mt-4">
                        <label for="delete_reason" class="block text-sm font-medium text-gray-700">Alasan Penghapusan <span class="text-red-500">*</span></label>
                        <textarea wire:model="delete_reason" id="delete_reason" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm"
                                  placeholder="Masukkan alasan penghapusan (min. 10 karakter)..."></textarea>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['delete_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs mt-1"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="flex flex-col-reverse sm:flex-row sm:justify-center gap-2 sm:gap-3 mt-4">
                        <button wire:click="closeDeleteModal" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-gray-300 text-gray-700 text-sm font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300 transition-colors">
                            Batal
                        </button>
                        <button wire:click="processDelete" 
                                class="w-full sm:w-auto px-4 py-2.5 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 transition-colors">
                            Hapus Permanen
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/booking-list.blade.php ENDPATH**/ ?>