<div class="space-y-4 sm:space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-medium"><?php echo e($statistics['total']); ?></span>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 min-w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total</dt>
                            <dd class="text-sm sm:text-lg font-medium text-gray-900"><?php echo e($statistics['total']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-medium"><?php echo e($statistics['pending']); ?></span>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 min-w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                            <dd class="text-sm sm:text-lg font-medium text-gray-900"><?php echo e($statistics['pending']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-medium"><?php echo e($statistics['confirmed']); ?></span>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 min-w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Dikonfirmasi</dt>
                            <dd class="text-sm sm:text-lg font-medium text-gray-900"><?php echo e($statistics['confirmed']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-medium"><?php echo e($statistics['active']); ?></span>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 min-w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Aktif</dt>
                            <dd class="text-sm sm:text-lg font-medium text-gray-900"><?php echo e($statistics['active']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-gray-400 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-medium"><?php echo e($statistics['completed']); ?></span>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 min-w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Selesai</dt>
                            <dd class="text-sm sm:text-lg font-medium text-gray-900"><?php echo e($statistics['completed']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-3 sm:p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-6 h-6 sm:w-8 sm:h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-xs sm:text-sm font-medium"><?php echo e($statistics['overdue']); ?></span>
                        </div>
                    </div>
                    <div class="ml-3 sm:ml-5 min-w-0 flex-1">
                        <dl>
                            <dt class="text-xs sm:text-sm font-medium text-gray-500 truncate">Terlambat</dt>
                            <dd class="text-sm sm:text-lg font-medium text-gray-900"><?php echo e($statistics['overdue']); ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="text-base sm:text-lg font-medium text-gray-900">Cari Pemesanan</h3>
                <button wire:click="toggleFilters" type="button" 
                        class="inline-flex items-center justify-center px-3 py-1.5 sm:px-3 sm:py-2 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <svg class="h-3 w-3 sm:h-4 sm:w-4 mr-1 sm:mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v4.586l-4-2v-2.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    <span class="hidden sm:inline"><?php echo e($show_filters ? 'Sembunyikan Filter' : 'Tampilkan Filter'); ?></span>
                    <span class="sm:hidden">Filter</span>
                </button>
            </div>
        </div>

        <div class="p-4 sm:p-6 space-y-4">
            <!-- Basic Search -->
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <div class="flex-1">
                    <input wire:model="search" type="text" placeholder="Cari nomor pemesanan, nama, telepon..." 
                           class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                </div>
                <div class="flex gap-2">
                    <select wire:model="sort_by" class="flex-1 sm:flex-none rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-xs sm:text-sm">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->getSortOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </select>
                    <button wire:click="sortBy('<?php echo e($sort_by); ?>')" type="button" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm rounded-lg text-gray-700 bg-white hover:bg-gray-50">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sort_direction === 'asc'): ?>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        <?php else: ?>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </button>
                </div>
            </div>

            <!-- Advanced Filters -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($show_filters): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 pt-4 border-t border-gray-200">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model="status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->getStatusOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>

                    <!-- Customer Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Pelanggan</label>
                        <select wire:model="customer_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            <option value="">Semua Pelanggan</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($customer['id']); ?>"><?php echo e($customer['name']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>

                    <!-- Vehicle Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                        <select wire:model="car_id" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            <option value="">Semua Kendaraan</option>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $cars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($car['id']); ?>"><?php echo e($car['license_plate']); ?> - <?php echo e($car['brand']); ?> <?php echo e($car['model']); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Status Pembayaran</label>
                        <select wire:model="payment_status" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->getPaymentStatusOptions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </select>
                    </div>

                    <!-- Start Date Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Tanggal Mulai Dari</label>
                        <input wire:model="start_date" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                    </div>

                    <!-- End Date Filter -->
                    <div>
                        <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Tanggal Selesai Sampai</label>
                        <input wire:model="end_date" type="date" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                    </div>

                    <!-- Checkboxes -->
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input wire:model="overdue_only" type="checkbox" id="overdue_only" class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded">
                            <label for="overdue_only" class="ml-2 block text-xs sm:text-sm text-gray-900">Hanya yang terlambat</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model="with_driver_only" type="checkbox" id="with_driver_only" class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-gray-300 rounded">
                            <label for="with_driver_only" class="ml-2 block text-xs sm:text-sm text-gray-900">Hanya dengan sopir</label>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    <div class="flex items-end">
                        <button wire:click="clearFilters" type="button" 
                                class="w-full inline-flex justify-center items-center px-3 py-2 border border-gray-300 shadow-sm text-xs sm:text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Hapus Filter
                        </button>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Results -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <h3 class="text-base sm:text-lg font-medium text-gray-900">
                    Hasil Pencarian (<?php echo e($filtered_count); ?> ditemukan)
                </h3>
                <div class="flex items-center gap-2">
                    <label class="text-xs sm:text-sm text-gray-700">Tampilkan:</label>
                    <select wire:model="per_page" class="rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-xs sm:text-sm">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($bookings->count() > 0): ?>
            <!-- Mobile Card View -->
            <div class="lg:hidden divide-y divide-gray-200">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="p-4 <?php echo e($this->isOverdue($booking) ? 'bg-red-50' : 'hover:bg-gray-50'); ?>">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1 min-w-0">
                                <div class="font-medium text-sm text-gray-900 truncate"><?php echo e($booking->booking_number); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($booking->created_at->format('d M Y')); ?></div>
                            </div>
                            <div class="flex flex-col gap-1 ml-2">
                                <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full <?php echo e($this->getStatusBadgeClass($booking->booking_status)); ?>">
                                    <?php echo e(ucfirst($booking->booking_status)); ?>

                                </span>
                                <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full <?php echo e($this->getPaymentStatusBadgeClass($booking->payment_status)); ?>">
                                    <?php echo e(ucfirst($booking->payment_status)); ?>

                                </span>
                            </div>
                        </div>
                        <div class="space-y-1 text-xs text-gray-600">
                            <div><span class="font-medium">Pelanggan:</span> <?php echo e($booking->customer->name); ?></div>
                            <div><span class="font-medium">Telepon:</span> <?php echo e($booking->customer->phone); ?></div>
                            <div><span class="font-medium">Kendaraan:</span> <?php echo e($booking->car->license_plate); ?> - <?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?></div>
                            <div><span class="font-medium">Periode:</span> <?php echo e($booking->start_date->format('d M Y')); ?> - <?php echo e($booking->end_date->format('d M Y')); ?></div>
                            <div><span class="font-medium">Jumlah:</span> <?php echo e($this->formatCurrency($booking->total_amount)); ?></div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->with_driver): ?>
                                <div class="text-blue-600 font-medium">Dengan Sopir</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isOverdue($booking)): ?>
                                <div class="text-red-600 font-medium">⚠️ Terlambat</div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="mt-3">
                            <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" 
                               class="inline-flex items-center px-3 py-1.5 bg-accent-500 hover:bg-accent-600 text-white text-xs font-medium rounded-lg transition-colors">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block overflow-x-auto">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th wire:click="sortBy('booking_number')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                No. Pemesanan
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sort_by === 'booking_number'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sort_direction === 'asc'): ?> ↑ <?php else: ?> ↓ <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                            <th wire:click="sortBy('start_date')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Tanggal
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sort_by === 'start_date'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sort_direction === 'asc'): ?> ↑ <?php else: ?> ↓ <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </th>
                            <th wire:click="sortBy('total_amount')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Jumlah
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sort_by === 'total_amount'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sort_direction === 'asc'): ?> ↑ <?php else: ?> ↓ <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50 <?php echo e($this->isOverdue($booking) ? 'bg-red-50' : ''); ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($booking->booking_number); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($booking->created_at->format('d M Y')); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($booking->customer->name); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($booking->customer->phone); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($booking->car->license_plate); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo e($booking->start_date->format('d M Y H:i')); ?></div>
                                    <div class="text-sm text-gray-500"><?php echo e($booking->end_date->format('d M Y H:i')); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($this->formatCurrency($booking->total_amount)); ?></div>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->with_driver): ?>
                                        <div class="text-xs text-blue-600">Dengan Sopir</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($this->getStatusBadgeClass($booking->booking_status)); ?>">
                                        <?php echo e(ucfirst($booking->booking_status)); ?>

                                    </span>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->isOverdue($booking)): ?>
                                        <div class="text-xs text-red-600 mt-1">Terlambat</div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($this->getPaymentStatusBadgeClass($booking->payment_status)); ?>">
                                        <?php echo e(ucfirst($booking->payment_status)); ?>

                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?php echo e(route('admin.bookings.show', $booking)); ?>" 
                                       class="text-accent-600 hover:text-accent-900">Lihat</a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-4 sm:px-6 py-3 sm:py-4 border-t border-gray-200">
                <?php echo e($bookings->links()); ?>

            </div>
        <?php else: ?>
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pemesanan ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba sesuaikan kriteria pencarian atau filter Anda.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/booking-search.blade.php ENDPATH**/ ?>