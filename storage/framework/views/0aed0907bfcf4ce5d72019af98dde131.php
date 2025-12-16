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
            <?php echo e(__('Financial Reports')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Report Filters</h3>
                    <form method="GET" action="<?php echo e(route('admin.reports.financial')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
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
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
                            </button>
                        </div>
                        <div class="flex items-end space-x-2">
                            <a href="<?php echo e(route('admin.reports.financial', array_merge(request()->all(), ['format' => 'excel']))); ?>" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Excel
                            </a>
                            <a href="<?php echo e(route('admin.reports.financial', array_merge(request()->all(), ['format' => 'pdf']))); ?>" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($reportData)): ?>
            <!-- Profit/Loss Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.trending-up','data' => ['class' => 'h-8 w-8 text-green-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.trending-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-green-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2)): ?>
<?php $attributes = $__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2; ?>
<?php unset($__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2)): ?>
<?php $component = $__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2; ?>
<?php unset($__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Revenue</div>
                                <div class="text-2xl font-bold text-gray-900">Rp <?php echo e(number_format($reportData['revenue']['total_net_revenue'], 0, ',', '.')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalec84bc158a25135b58f1df8c1cc48af1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec84bc158a25135b58f1df8c1cc48af1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.receipt-tax','data' => ['class' => 'h-8 w-8 text-red-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.receipt-tax'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-red-500']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalec84bc158a25135b58f1df8c1cc48af1)): ?>
<?php $attributes = $__attributesOriginalec84bc158a25135b58f1df8c1cc48af1; ?>
<?php unset($__attributesOriginalec84bc158a25135b58f1df8c1cc48af1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalec84bc158a25135b58f1df8c1cc48af1)): ?>
<?php $component = $__componentOriginalec84bc158a25135b58f1df8c1cc48af1; ?>
<?php unset($__componentOriginalec84bc158a25135b58f1df8c1cc48af1); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Expenses</div>
                                <div class="text-2xl font-bold text-gray-900">Rp <?php echo e(number_format($reportData['expenses']['total'], 0, ',', '.')); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalbb585b916ac9791b47ae751e31e7a162 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb585b916ac9791b47ae751e31e7a162 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.currency-dollar','data' => ['class' => 'h-8 w-8 '.e($reportData['profit_loss']['gross_profit'] >= 0 ? 'text-green-500' : 'text-red-500').'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.currency-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 '.e($reportData['profit_loss']['gross_profit'] >= 0 ? 'text-green-500' : 'text-red-500').'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbb585b916ac9791b47ae751e31e7a162)): ?>
<?php $attributes = $__attributesOriginalbb585b916ac9791b47ae751e31e7a162; ?>
<?php unset($__attributesOriginalbb585b916ac9791b47ae751e31e7a162); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbb585b916ac9791b47ae751e31e7a162)): ?>
<?php $component = $__componentOriginalbb585b916ac9791b47ae751e31e7a162; ?>
<?php unset($__componentOriginalbb585b916ac9791b47ae751e31e7a162); ?>
<?php endif; ?>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Net Profit</div>
                                <div class="text-2xl font-bold <?php echo e($reportData['profit_loss']['gross_profit'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                    Rp <?php echo e(number_format($reportData['profit_loss']['gross_profit'], 0, ',', '.')); ?>

                                </div>
                                <div class="text-sm text-gray-500"><?php echo e(number_format($reportData['profit_loss']['profit_margin'], 1)); ?>% margin</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Breakdown</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($reportData['revenue']['rental_income'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Rental Income</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-purple-600">Rp <?php echo e(number_format($reportData['revenue']['driver_fees'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Driver Fees</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-indigo-600">Rp <?php echo e(number_format($reportData['revenue']['out_of_town_fees'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Out-of-Town Fees</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-yellow-600">Rp <?php echo e(number_format($reportData['revenue']['late_penalties'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Late Penalties</div>
                        </div>
                    </div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportData['revenue']['member_discounts'] > 0): ?>
                    <div class="mt-4 text-center">
                        <div class="text-lg font-bold text-red-600">-Rp <?php echo e(number_format($reportData['revenue']['member_discounts'], 0, ',', '.')); ?></div>
                        <div class="text-sm text-gray-500">Member Discounts Given</div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Expense Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Expense Breakdown</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-red-600">Rp <?php echo e(number_format($reportData['expenses']['operational'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Operational Expenses</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-orange-600">Rp <?php echo e(number_format($reportData['expenses']['maintenance'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Maintenance Costs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-gray-600">Rp <?php echo e(number_format($reportData['expenses']['total'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Total Expenses</div>
                        </div>
                    </div>

                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportData['expenses']['by_category']->count() > 0): ?>
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Operational Expenses by Category</h4>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['expenses']['by_category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-700">Rp <?php echo e(number_format($data['amount'], 0, ',', '.')); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e(ucfirst($category)); ?></div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>

            <!-- Monthly Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Performance</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bookings</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['monthly_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $monthData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo e($monthData['month_name']); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp <?php echo e(number_format($monthData['revenue'], 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp <?php echo e(number_format($monthData['expenses'], 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo e($monthData['profit'] >= 0 ? 'text-green-600' : 'text-red-600'); ?>">
                                        Rp <?php echo e(number_format($monthData['profit'], 0, ',', '.')); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <?php echo e(number_format($monthData['bookings_count'])); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Period Summary (<?php echo e($reportData['period']['start_date']); ?> to <?php echo e($reportData['period']['end_date']); ?>)
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-blue-600"><?php echo e(number_format($reportData['summary']['total_bookings'])); ?></div>
                            <div class="text-sm text-gray-500">Total Bookings</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-green-600">Rp <?php echo e(number_format($reportData['summary']['average_booking_value'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-gray-500">Avg. Booking Value</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-purple-600"><?php echo e(number_format($reportData['summary']['total_customers'])); ?></div>
                            <div class="text-sm text-gray-500">Unique Customers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-indigo-600"><?php echo e(number_format($reportData['summary']['period_days'])); ?></div>
                            <div class="text-sm text-gray-500">Days in Period</div>
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\reports\financial.blade.php ENDPATH**/ ?>