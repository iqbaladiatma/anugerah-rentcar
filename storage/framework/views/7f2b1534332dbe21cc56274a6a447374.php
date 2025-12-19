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
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Pengeluaran Management')); ?>

            </h2>
            <a href="<?php echo e(route('admin.expenses.create')); ?>" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Pengeluaran Baru
            </a>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginalbb585b916ac9791b47ae751e31e7a162 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbb585b916ac9791b47ae751e31e7a162 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.currency-dollar','data' => ['class' => 'h-8 w-8 text-green-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.currency-dollar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-green-500']); ?>
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
                                <p class="text-sm font-medium text-gray-500">Bulan Ini</p>
                                <p class="text-2xl font-semibold text-gray-900" id="monthly-total">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginal0eb582c370058102933a94667aeb70b4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0eb582c370058102933a94667aeb70b4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.chart-bar','data' => ['class' => 'h-8 w-8 text-blue-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.chart-bar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-blue-500']); ?>
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
                                <p class="text-sm font-medium text-gray-500">Tahun Ini</p>
                                <p class="text-2xl font-semibold text-gray-900" id="yearly-total">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if (isset($component)) { $__componentOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale3cfc6d82aed862a6b5ad8b5605db5e2 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.trending-up','data' => ['class' => 'h-8 w-8 text-purple-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.trending-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-8 w-8 text-purple-500']); ?>
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
                                <p class="text-sm font-medium text-gray-500">Rata-Rata Bulanan</p>
                                <p class="text-2xl font-semibold text-gray-900" id="average-monthly">Loading...</p>
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
                                <p class="text-sm font-medium text-gray-500">Total Pengeluaran</p>
                                <p class="text-2xl font-semibold text-gray-900" id="total-count">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense List Component -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.expense-list');

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-3655809870-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadSummaryData();
        });

        function loadSummaryData() {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1;

            console.log('Loading summary data...', { year: currentYear, month: currentMonth });

            // Load monthly summary
            fetch(`<?php echo e(route('admin.expenses.monthly-summary')); ?>?year=${currentYear}&month=${currentMonth}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Monthly summary data:', data);
                    document.getElementById('monthly-total').textContent = 
                        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.total_amount);
                })
                .catch(error => {
                    console.error('Error loading monthly summary:', error);
                    document.getElementById('monthly-total').textContent = 'Error';
                    document.getElementById('monthly-total').title = error.message;
                });

            // Load yearly summary
            fetch(`<?php echo e(route('admin.expenses.yearly-summary')); ?>?year=${currentYear}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Yearly summary data:', data);
                    document.getElementById('yearly-total').textContent = 
                        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.total_amount);
                    document.getElementById('average-monthly').textContent = 
                        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.average_monthly);
                    document.getElementById('total-count').textContent = data.total_count + ' items';
                })
                .catch(error => {
                    console.error('Error loading yearly summary:', error);
                    document.getElementById('yearly-total').textContent = 'Error';
                    document.getElementById('average-monthly').textContent = 'Error';
                    document.getElementById('total-count').textContent = 'Error';
                });
        }
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/expenses/index.blade.php ENDPATH**/ ?>