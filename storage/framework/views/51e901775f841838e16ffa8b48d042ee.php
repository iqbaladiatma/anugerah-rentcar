<div>
    <!-- Controls -->
    <div class="mb-6 bg-white p-6 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select wire:model.live="selectedYear" 
                        id="year"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($year); ?>"><?php echo e($year); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>   
            </div>

            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Bulan (Opsional)</label>
                <select wire:model.live="selectedMonth" 
                        id="month"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Months</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($num); ?>"><?php echo e($name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <div>
                <label for="comparison" class="block text-sm font-medium text-gray-700 mb-1">Bandingkan Dengan</label>
                <select wire:model.live="comparisonPeriod" 
                        id="comparison"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="year">Tahun Lalu</option>
                    <option value="month">Bulan Lalu</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button wire:click="exportData('excel')" 
                        class="flex-1 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export Excel
                </button>
                <button wire:click="exportData('pdf')" 
                        class="flex-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Export PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            <?php echo e(number_format($yearlySummary['total_amount'] ?? 0, 0, ',', '.')); ?> IDR
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Catatan</p>
                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($yearlySummary['total_count'] ?? 0); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Rata-rata Bulanan</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            <?php echo e(number_format($yearlySummary['average_monthly'] ?? 0, 0, ',', '.')); ?> IDR
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($comparison['difference']['percentage'])): ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($comparison['difference']['percentage'] > 0): ?>
                                <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            <?php else: ?>
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php else: ?>
                            <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">vs <?php echo e($comparison['period2_label'] ?? 'Tahun Lalu'); ?></p>
                        <p class="text-2xl font-semibold <?php echo e(isset($comparison['difference']['percentage']) && $comparison['difference']['percentage'] > 0 ? 'text-red-600' : 'text-green-600'); ?>">
                            <?php if(isset($comparison['difference']['percentage'])): ?>
                                <?php echo e($comparison['difference']['percentage'] > 0 ? '+' : ''); ?><?php echo e(number_format($comparison['difference']['percentage'], 1)); ?>%
                            <?php else: ?>
                                N/A
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Trend Chart -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tren 12 Bulan</h3>
            <div class="h-64">
                <canvas id="trendChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Penjelasan Kategori</h3>
            <div class="h-64">
                <canvas id="categoryChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown Table -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($yearlySummary['monthly_breakdown'])): ?>
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Penjelasan Bulanan - <?php echo e($selectedYear); ?></h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% of Year</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $yearlySummary['monthly_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <?php echo e($data['month']); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e(number_format($data['amount'], 0, ',', '.')); ?> IDR
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php echo e($data['count']); ?>

                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($yearlySummary['total_amount'] > 0): ?>
                                    <?php echo e(number_format(($data['amount'] / $yearlySummary['total_amount']) * 100, 1)); ?>%
                                <?php else: ?>
                                    0%
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Category Details -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($categoryBreakdown)): ?>
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Category Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categoryBreakdown; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-900"><?php echo e($category['label']); ?></h4>
                        <span class="text-sm text-gray-500"><?php echo e(number_format($category['percentage'], 1)); ?>%</span>
                    </div>
                    <p class="text-2xl font-semibold text-gray-900 mb-1">
                        <?php echo e(number_format($category['total'], 0, ',', '.')); ?> IDR
                    </p>
                    <p class="text-sm text-gray-500"><?php echo e($category['count']); ?> transactions</p>
                    <div class="mt-2 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: <?php echo e($category['percentage']); ?>%"></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const trendData = <?php echo json_encode($trendData, 15, 512) ?>;
            
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => item.short_month),
                    datasets: [{
                        label: 'Monthly Expenses',
                        data: trendData.map(item => item.total),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Amount: ' + new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(context.parsed.y);
                                }
                            }
                        }
                    }
                }
            });

            // Category Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            const categoryData = <?php echo json_encode($categoryBreakdown, 15, 512) ?>;
            
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: categoryData.map(item => item.label),
                    datasets: [{
                        data: categoryData.map(item => item.total),
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(context.parsed);
                                    const percentage = ((context.parsed / categoryData.reduce((sum, item) => sum + item.total, 0)) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    <?php $__env->stopPush(); ?>

    <!-- Flash Messages -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('info')): ?>
        <div class="fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded z-50"
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            <?php echo e(session('info')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/expense-analytics.blade.php ENDPATH**/ ?>