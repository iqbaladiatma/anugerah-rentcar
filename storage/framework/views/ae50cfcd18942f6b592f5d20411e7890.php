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
            <?php echo e(__('Vehicle Reports')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Report Filters</h3>
                    <form method="GET" action="<?php echo e(route('admin.reports.vehicle')); ?>" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" 
                                   value="<?php echo e(request('start_date', now()->subYear()->format('Y-m-d'))); ?>"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" 
                                   value="<?php echo e(request('end_date', now()->format('Y-m-d'))); ?>"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="car_id" class="block text-sm font-medium text-gray-700">Specific Vehicle</label>
                            <select name="car_id" id="car_id" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="">All Vehicles</option>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = \App\Models\Car::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $car): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($car->id); ?>" <?php echo e(request('car_id') == $car->id ? 'selected' : ''); ?>>
                                        <?php echo e($car->license_plate); ?> - <?php echo e($car->brand); ?> <?php echo e($car->model); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
                            </button>
                        </div>
                        <div class="flex items-end space-x-2">
                            <a href="<?php echo e(route('admin.reports.vehicle', array_merge(request()->all(), ['format' => 'excel']))); ?>" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Excel
                            </a>
                            <a href="<?php echo e(route('admin.reports.vehicle', array_merge(request()->all(), ['format' => 'pdf']))); ?>" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($reportData)): ?>
            <!-- Fleet Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Fleet Summary (<?php echo e($reportData['period']['start_date']); ?> to <?php echo e($reportData['period']['end_date']); ?> - <?php echo e($reportData['period']['total_days']); ?> days)
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600"><?php echo e(number_format($reportData['fleet_summary']['total_vehicles'])); ?></div>
                            <div class="text-sm text-gray-500">Total Vehicles</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600"><?php echo e(number_format($reportData['fleet_summary']['average_utilization'], 1)); ?>%</div>
                            <div class="text-sm text-gray-500">Avg. Utilization</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">Rp <?php echo e(number_format($reportData['fleet_summary']['total_fleet_revenue'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Total Revenue</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">Rp <?php echo e(number_format($reportData['fleet_summary']['total_maintenance_costs'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Maintenance Costs</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Performers -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportData['fleet_summary']['most_profitable_vehicle'] || $reportData['fleet_summary']['highest_utilization_vehicle']): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportData['fleet_summary']['most_profitable_vehicle']): ?>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Most Profitable Vehicle</h4>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalf63dc849b36103e585bc591c17c3f2c6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf63dc849b36103e585bc591c17c3f2c6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.trophy','data' => ['class' => 'h-8 w-8 text-yellow-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.trophy'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-yellow-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf63dc849b36103e585bc591c17c3f2c6)): ?>
<?php $attributes = $__attributesOriginalf63dc849b36103e585bc591c17c3f2c6; ?>
<?php unset($__attributesOriginalf63dc849b36103e585bc591c17c3f2c6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf63dc849b36103e585bc591c17c3f2c6)): ?>
<?php $component = $__componentOriginalf63dc849b36103e585bc591c17c3f2c6; ?>
<?php unset($__componentOriginalf63dc849b36103e585bc591c17c3f2c6); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($reportData['fleet_summary']['most_profitable_vehicle']->license_plate); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($reportData['fleet_summary']['most_profitable_vehicle']->brand); ?> <?php echo e($reportData['fleet_summary']['most_profitable_vehicle']->model); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportData['fleet_summary']['highest_utilization_vehicle']): ?>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-medium text-gray-900 mb-2">Highest Utilization Vehicle</h4>
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal0eb582c370058102933a94667aeb70b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eb582c370058102933a94667aeb70b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.chart-bar','data' => ['class' => 'h-8 w-8 text-green-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.chart-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-green-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0eb582c370058102933a94667aeb70b4)): ?>
<?php $attributes = $__attributesOriginal0eb582c370058102933a94667aeb70b4; ?>
<?php unset($__attributesOriginal0eb582c370058102933a94667aeb70b4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0eb582c370058102933a94667aeb70b4)): ?>
<?php $component = $__componentOriginal0eb582c370058102933a94667aeb70b4; ?>
<?php unset($__componentOriginal0eb582c370058102933a94667aeb70b4); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900"><?php echo e($reportData['fleet_summary']['highest_utilization_vehicle']->license_plate); ?></div>
                                <div class="text-sm text-gray-500"><?php echo e($reportData['fleet_summary']['highest_utilization_vehicle']->brand); ?> <?php echo e($reportData['fleet_summary']['highest_utilization_vehicle']->model); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Vehicle Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Performance Details</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vehicle</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bookings</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilization</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Maintenance</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reportData['vehicles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($vehicleData['vehicle']->license_plate); ?></div>
                                                <div class="text-sm text-gray-500"><?php echo e($vehicleData['vehicle']->brand); ?> <?php echo e($vehicleData['vehicle']->model); ?> (<?php echo e($vehicleData['vehicle']->year); ?>)</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e($vehicleData['total_bookings']); ?> total<br>
                                        <span class="text-xs text-gray-500"><?php echo e($vehicleData['completed_bookings']); ?> completed</span><br>
                                        <span class="text-xs text-gray-500"><?php echo e($vehicleData['total_booked_days']); ?> days booked</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                            $utilization = $vehicleData['utilization_rate'];
                                            $utilizationClass = $utilization >= 70 ? 'text-green-600' : ($utilization >= 40 ? 'text-yellow-600' : 'text-red-600');
                                            $utilizationBg = $utilization >= 70 ? 'bg-green-100' : ($utilization >= 40 ? 'bg-yellow-100' : 'bg-red-100');
                                        ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($utilizationBg); ?> <?php echo e($utilizationClass); ?>">
                                            <?php echo e(number_format($utilization, 1)); ?>%
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp <?php echo e(number_format($vehicleData['total_revenue'], 0, ',', '.')); ?><br>
                                        <span class="text-xs text-gray-500">Rp <?php echo e(number_format($vehicleData['revenue_per_day'], 0, ',', '.')); ?>/day</span><br>
                                        <span class="text-xs text-gray-500">Avg: Rp <?php echo e(number_format($vehicleData['average_booking_value'], 0, ',', '.')); ?></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp <?php echo e(number_format($vehicleData['maintenance_costs'], 0, ',', '.')); ?><br>
                                        <span class="text-xs text-gray-500"><?php echo e($vehicleData['maintenance_frequency']); ?> services</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo e($vehicleData['net_revenue'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        Rp <?php echo e(number_format($vehicleData['net_revenue'], 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <?php
                                            $performance = 'Poor';
                                            $performanceClass = 'bg-red-100 text-red-800';
                                            
                                            if ($utilization >= 70 && $vehicleData['net_revenue'] > 0) {
                                                $performance = 'Excellent';
                                                $performanceClass = 'bg-green-100 text-green-800';
                                            } elseif ($utilization >= 50 && $vehicleData['net_revenue'] > 0) {
                                                $performance = 'Good';
                                                $performanceClass = 'bg-blue-100 text-blue-800';
                                            } elseif ($utilization >= 30 || $vehicleData['net_revenue'] > 0) {
                                                $performance = 'Fair';
                                                $performanceClass = 'bg-yellow-100 text-yellow-800';
                                            }
                                        ?>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($performanceClass); ?>">
                                            <?php echo e($performance); ?>

                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                        No vehicles found for the selected criteria.
                                    </td>
                                </tr>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Performance Notes -->
            <div class="bg-gray-50 overflow-hidden shadow-sm sm:rounded-lg mt-6">
                <div class="p-6">
                    <h4 class="text-md font-medium text-gray-900 mb-3">Performance Metrics Explanation</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <strong>Utilization Rate:</strong> Percentage of days the vehicle was booked during the period<br>
                            <strong>Revenue per Day:</strong> Total revenue divided by days actually booked<br>
                            <strong>Net Revenue:</strong> Total revenue minus maintenance costs
                        </div>
                        <div>
                            <strong>Performance Rating:</strong><br>
                            • Excellent: ≥70% utilization + positive net revenue<br>
                            • Good: ≥50% utilization + positive net revenue<br>
                            • Fair: ≥30% utilization OR positive net revenue<br>
                            • Poor: <30% utilization AND negative net revenue
                        </div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\reports\vehicle.blade.php ENDPATH**/ ?>