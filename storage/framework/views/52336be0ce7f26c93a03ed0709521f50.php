<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Laporan Keuntungan Kendaraan')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="<?php echo e(route('admin.reports.profitability')); ?>" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" 
                                       value="<?php echo e(request('start_date', now()->subYear()->format('Y-m-d'))); ?>"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" 
                                       value="<?php echo e(request('end_date', now()->format('Y-m-d'))); ?>"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-accent-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-accent-700 focus:bg-accent-700 active:bg-accent-900 focus:outline-none focus:ring-2 focus:ring-accent-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">Hasilkan Laporan</span>
                                    <span class="sm:hidden">Generate</span>
                                </button>
                            </div>
                            <div class="flex items-end gap-2">
                                <a href="<?php echo e(route('admin.reports.profitability', array_merge(request()->all(), ['format' => 'excel']))); ?>" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">Excel</span>
                                </a>
                                <a href="<?php echo e(route('admin.reports.profitability', array_merge(request()->all(), ['format' => 'pdf']))); ?>" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">PDF</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($reportData)): ?>
            <!-- Summary Statistics -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 hidden sm:block">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="sm:ml-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Total Kendaraan</div>
                                <div class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900"><?php echo e(number_format($reportData['summary']['total_vehicles'])); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 hidden sm:block">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="sm:ml-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Profitable</div>
                                <div class="text-lg sm:text-xl lg:text-2xl font-bold text-green-600"><?php echo e(number_format($reportData['summary']['profitable_vehicles'])); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 hidden sm:block">
                                <div class="h-10 w-10 rounded-full bg-purple-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="sm:ml-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Keuntungan Bersih</div>
                                <div class="text-sm sm:text-lg lg:text-xl font-bold <?php echo e($reportData['summary']['total_net_profit'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    <span class="hidden sm:inline">Rp</span> <?php echo e(number_format($reportData['summary']['total_net_profit'], 0, ',', '.')); ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 hidden sm:block">
                                <div class="h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="sm:ml-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Margin Rata-rata</div>
                                <div class="text-lg sm:text-xl lg:text-2xl font-bold text-indigo-600"><?php echo e(number_format($reportData['summary']['average_profit_margin'], 1)); ?>%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Best and Worst Performers -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($reportData['summary']['best_performer']) && isset($reportData['summary']['worst_performer'])): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <!-- Best Performer -->
                <div class="bg-gradient-to-r from-green-50 to-green-100 overflow-hidden shadow-sm rounded-lg border-2 border-green-200">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <h3 class="text-sm sm:text-lg font-bold text-green-900">Kendaraan Terbaik</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="text-base sm:text-xl font-bold text-gray-900"><?php echo e($reportData['summary']['best_performer']['vehicle']->brand); ?> <?php echo e($reportData['summary']['best_performer']['vehicle']->model); ?></div>
                            <div class="text-xs sm:text-sm text-gray-600"><?php echo e($reportData['summary']['best_performer']['vehicle']->license_plate); ?></div>
                            <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-3 sm:mt-4">
                                <div>
                                    <div class="text-xs text-gray-500">Revenue</div>
                                    <div class="text-sm sm:text-lg font-bold text-green-600">Rp <?php echo e(number_format($reportData['summary']['best_performer']['revenue'] ?? 0, 0, ',', '.')); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Net Profit</div>
                                    <div class="text-sm sm:text-lg font-bold text-green-600">Rp <?php echo e(number_format($reportData['summary']['best_performer']['net_profit'] ?? 0, 0, ',', '.')); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Worst Performer -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 overflow-hidden shadow-sm rounded-lg border-2 border-red-200">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center mb-3 sm:mb-4">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <h3 class="text-sm sm:text-lg font-bold text-red-900">Perlu Perhatian</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="text-base sm:text-xl font-bold text-gray-900"><?php echo e($reportData['summary']['worst_performer']['vehicle']->brand); ?> <?php echo e($reportData['summary']['worst_performer']['vehicle']->model); ?></div>
                            <div class="text-xs sm:text-sm text-gray-600"><?php echo e($reportData['summary']['worst_performer']['vehicle']->license_plate); ?></div>
                            <div class="grid grid-cols-2 gap-3 sm:gap-4 mt-3 sm:mt-4">
                                <div>
                                    <div class="text-xs text-gray-500">Revenue</div>
                                    <div class="text-sm sm:text-lg font-bold text-gray-600">Rp <?php echo e(number_format($reportData['summary']['worst_performer']['revenue'] ?? 0, 0, ',', '.')); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Net Profit</div>
                                    <div class="text-sm sm:text-lg font-bold <?php echo e(($reportData['summary']['worst_performer']['net_profit'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        Rp <?php echo e(number_format($reportData['summary']['worst_performer']['net_profit'] ?? 0, 0, ',', '.')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Vehicle Profitability Table -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-3 sm:mb-4">
                        Analisis Keuntungan Kendaraan
                        <span class="block sm:inline text-xs sm:text-sm text-gray-500 font-normal mt-1 sm:mt-0 sm:ml-2">
                            (<?php echo e($reportData['period']['start_date']); ?> - <?php echo e($reportData['period']['end_date']); ?>)
                        </span>
                    </h3>
                    
                    <!-- Mobile Card View -->
                    <div class="block lg:hidden space-y-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reportData['vehicles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="border rounded-lg p-4 <?php echo e($loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white'); ?>">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="font-medium text-gray-900"><?php echo e($data['vehicle']->brand); ?> <?php echo e($data['vehicle']->model); ?></div>
                                    <div class="text-xs text-gray-500"><?php echo e($data['vehicle']->license_plate); ?></div>
                                </div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($data['net_profit'] ?? 0) > 0): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Profitable</span>
                                <?php elseif(($data['net_profit'] ?? 0) == 0): ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Break Even</span>
                                <?php else: ?>
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Loss</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <div class="text-xs text-gray-500">Pendapatan</div>
                                    <div class="font-medium">Rp <?php echo e(number_format($data['revenue'] ?? 0, 0, ',', '.')); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">B. Pemeliharaan</div>
                                    <div class="font-medium text-red-600">Rp <?php echo e(number_format($data['maintenance_costs'] ?? 0, 0, ',', '.')); ?></div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Keuntungan Bersih</div>
                                    <div class="font-semibold <?php echo e(($data['net_profit'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        Rp <?php echo e(number_format($data['net_profit'] ?? 0, 0, ',', '.')); ?>

                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Margin / Pesanan</div>
                                    <div class="font-medium">
                                        <span class="<?php echo e(($data['profit_margin'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e(number_format($data['profit_margin'] ?? 0, 1)); ?>%</span>
                                        <span class="text-gray-500">/ <?php echo e(number_format($data['vehicle']->bookings->count() ?? 0)); ?>x</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-8 text-gray-500">
                            Tidak ada data untuk periode yang dipilih.
                        </div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya Pemeliharaan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keuntungan Bersih</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Margin</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesanan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reportData['vehicles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="<?php echo e($loop->iteration % 2 == 0 ? 'bg-gray-50' : ''); ?>">
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($data['vehicle']->brand); ?> <?php echo e($data['vehicle']->model); ?></div>
                                        <div class="text-sm text-gray-500"><?php echo e($data['vehicle']->license_plate); ?></div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp <?php echo e(number_format($data['revenue'] ?? 0, 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-red-600">
                                        Rp <?php echo e(number_format($data['maintenance_costs'] ?? 0, 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold <?php echo e(($data['net_profit'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        Rp <?php echo e(number_format($data['net_profit'] ?? 0, 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm <?php echo e(($data['profit_margin'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        <?php echo e(number_format($data['profit_margin'] ?? 0, 1)); ?>%
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e(number_format($data['vehicle']->bookings->count() ?? 0)); ?>

                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(($data['net_profit'] ?? 0) > 0): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Profitable
                                            </span>
                                        <?php elseif(($data['net_profit'] ?? 0) == 0): ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Break Even
                                            </span>
                                        <?php else: ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Loss
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
                                        Tidak ada data untuk periode yang dipilih.
                                    </td>
                                </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/reports/profitability.blade.php ENDPATH**/ ?>