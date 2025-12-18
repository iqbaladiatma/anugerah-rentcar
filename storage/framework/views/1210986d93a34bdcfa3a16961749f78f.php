<div wire:poll.<?php echo e($refreshInterval); ?>ms="refreshStats" class="space-y-6">
    <!-- Quick Stats -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Vehicles -->
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-accent-500">
                        <?php echo $__env->make('components.icons.truck', ['class' => 'h-5 w-5 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Total Kendaraan</dt>
                        <dd class="text-lg font-medium text-gray-900"><?php echo e($this->stats['total_vehicles']); ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Active Bookings -->
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-green-500">
                        <?php echo $__env->make('components.icons.clipboard-list', ['class' => 'h-5 w-5 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Pemesanan Aktif</dt>
                        <dd class="text-lg font-medium text-gray-900"><?php echo e($this->stats['active_bookings']); ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Available Vehicles -->
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-yellow-500">
                        <?php echo $__env->make('components.icons.car', ['class' => 'h-5 w-5 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Tersedia Sekarang</dt>
                        <dd class="text-lg font-medium text-gray-900"><?php echo e($this->stats['available_vehicles']); ?></dd>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Monthly Revenue -->
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <div class="flex h-8 w-8 items-center justify-center rounded-md bg-purple-500">
                        <?php echo $__env->make('components.icons.currency-dollar', ['class' => 'h-5 w-5 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                </div>
                <div class="ml-5 w-0 flex-1">
                    <dl>
                        <dt class="truncate text-sm font-medium text-gray-500">Pendapatan Bulanan</dt>
                        <dd class="text-lg font-medium text-gray-900">Rp <?php echo e(number_format($this->stats['monthly_revenue'], 0, ',', '.')); ?></dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="rounded-lg bg-white shadow">
        <div class="p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Tren Pendapatan</h3>
                <div class="flex items-center space-x-2">
                    <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                        12 Bulan Terakhir
                    </span>
                </div>
            </div>
            <div class="mt-6">
                <div id="revenue-chart" wire:ignore></div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Notifications -->
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <!-- Recent Bookings -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Pemesanan Terbaru</h3>
                    <a href="<?php echo e(route('admin.bookings.index')); ?>" class="text-sm font-medium text-accent-600 hover:text-accent-500">Lihat semua</a>
                </div>
                <div class="mt-6 flow-root">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->recentBookings->count() > 0): ?>
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="py-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-600">
                                                    <?php echo e(substr($booking->customer->name, 0, 2)); ?>

                                                </span>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="truncate text-sm font-medium text-gray-900"><?php echo e($booking->customer->name); ?></p>
                                            <p class="truncate text-sm text-gray-500"><?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?> - <?php echo e($booking->car->license_plate); ?></p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <?php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'confirmed' => 'bg-accent-100 text-accent-800',
                                                    'active' => 'bg-green-100 text-green-800',
                                                    'completed' => 'bg-gray-100 text-gray-800',
                                                    'cancelled' => 'bg-red-100 text-red-800',
                                                ];
                                                $statusLabels = [
                                                    'pending' => 'Menunggu',
                                                    'confirmed' => 'Dikonfirmasi',
                                                    'active' => 'Aktif',
                                                    'completed' => 'Selesai',
                                                    'cancelled' => 'Dibatalkan',
                                                ];
                                            ?>
                                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium <?php echo e($statusColors[$booking->booking_status] ?? 'bg-gray-100 text-gray-800'); ?>">
                                                <?php echo e($statusLabels[$booking->booking_status] ?? ucfirst($booking->booking_status)); ?>

                                            </span>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="flex justify-center">
                                <?php echo $__env->make('components.icons.clipboard-list', ['class' => 'h-12 w-12 text-gray-400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Tidak ada pemesanan terbaru</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Notifications & Alerts -->
        <div class="overflow-hidden rounded-lg bg-white shadow">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">Notifikasi & Peringatan</h3>
                    <?php
                        $urgentCount = collect($this->notifications)->where('priority', 'high')->count();
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($urgentCount > 0): ?>
                        <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                            <?php echo e($urgentCount); ?> mendesak
                        </span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                <div class="mt-6 flow-root">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($this->notifications) > 0): ?>
                        <ul role="list" class="-my-5 divide-y divide-gray-200">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="py-4">
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <?php
                                                $iconColors = [
                                                    'high' => 'bg-red-100 text-red-600',
                                                    'medium' => 'bg-yellow-100 text-yellow-600',
                                                    'low' => 'bg-accent-100 text-accent-600',
                                                ];
                                            ?>
                                            <div class="flex h-6 w-6 items-center justify-center rounded-full <?php echo e($iconColors[$notification['priority']] ?? 'bg-gray-100 text-gray-600'); ?>">
                                                <?php echo $__env->make('components.icons.' . $notification['icon'], ['class' => 'h-4 w-4'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm text-gray-900"><?php echo e($notification['message']); ?></p>
                                            <p class="text-sm text-gray-500"><?php echo e($notification['details']); ?></p>
                                        </div>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($notification['action_url'])): ?>
                                            <div class="flex-shrink-0">
                                                <a href="<?php echo e($notification['action_url']); ?>" class="text-sm font-medium text-accent-600 hover:text-accent-500">
                                                    Lihat
                                                </a>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    <?php else: ?>
                        <div class="text-center py-8">
                            <div class="flex justify-center">
                                <?php echo $__env->make('components.icons.adjustments', ['class' => 'h-12 w-12 text-gray-400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Tidak ada notifikasi</p>
                            <p class="text-xs text-gray-400">Semua sistem berjalan lancar</p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="rounded-lg bg-white shadow">
        <div class="p-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Aksi Cepat</h3>
            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <a href="<?php echo e(route('admin.bookings.create')); ?>" class="relative group rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-accent-500">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-accent-500">
                            <?php echo $__env->make('components.icons.plus', ['class' => 'h-6 w-6 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Pemesanan Baru</p>
                        <p class="text-sm text-gray-500 truncate">Buat sewa baru</p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="relative group rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-accent-500">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-600">
                            <?php echo $__env->make('components.icons.arrow-right', ['class' => 'h-6 w-6 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Keluar</p>
                        <p class="text-sm text-gray-500 truncate">Proses pengiriman kendaraan</p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="relative group rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-accent-500">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-600">
                            <?php echo $__env->make('components.icons.arrow-left', ['class' => 'h-6 w-6 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Masuk</p>
                        <p class="text-sm text-gray-500 truncate">Proses pengembalian kendaraan</p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.availability.timeline')); ?>" class="relative group rounded-lg border border-gray-300 bg-white px-6 py-5 shadow-sm flex items-center space-x-3 hover:border-gray-400 focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-accent-500">
                    <div class="flex-shrink-0">
                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-yellow-600">
                            <?php echo $__env->make('components.icons.calendar', ['class' => 'h-6 w-6 text-white'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="absolute inset-0" aria-hidden="true"></span>
                        <p class="text-sm font-medium text-gray-900">Linimasa</p>
                        <p class="text-sm text-gray-500 truncate">Lihat ketersediaan</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let chart;
    
    function initChart() {
        const chartData = <?php echo json_encode($this->revenueChartData, 15, 512) ?>;
        
        const options = {
            series: chartData.series,
            chart: {
                type: 'area',
                height: 350,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 2
            },
            xaxis: {
                categories: chartData.categories,
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                labels: {
                    formatter: function (val) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                    },
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },
            colors: ['#f97316'],
            grid: {
                borderColor: '#E5E7EB',
                strokeDashArray: 3
            }
        };

        if (chart) {
            chart.destroy();
        }
        
        chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
        chart.render();
    }
    
    // Initialize chart
    initChart();
    
    // Listen for Livewire updates
    Livewire.on('stats-refreshed', () => {
        setTimeout(() => {
            initChart();
        }, 100);
    });
});
</script>
<?php $__env->stopPush(); ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/dashboard-stats.blade.php ENDPATH**/ ?>