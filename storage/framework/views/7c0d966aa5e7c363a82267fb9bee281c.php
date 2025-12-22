<div>
    <!-- Filters Section -->
    <div class="mb-4 sm:mb-6 bg-gray-50 p-3 sm:p-4 rounded-lg">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Cari Deskripsi</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       id="search"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm"
                       placeholder="Cari pengeluaran...">
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select wire:model.live="category" 
                        id="category"
                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                    <option value="">Semua Kategori</option>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($key); ?>"><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label for="start_date" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" 
                       wire:model.live="startDate" 
                       id="start_date"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
            </div>

            <div>
                <label for="end_date" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" 
                       wire:model.live="endDate" 
                       id="end_date"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mt-3 sm:mt-4">
            <!-- Amount Range -->
            <div>
                <label for="min_amount" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Jumlah Minimum</label>
                <input type="number" 
                       wire:model.live.debounce.300ms="minAmount" 
                       id="min_amount"
                       step="0.01"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm"
                       placeholder="0.00">
            </div>

            <div>
                <label for="max_amount" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1">Jumlah Maksimum</label>
                <input type="number" 
                       wire:model.live.debounce.300ms="maxAmount" 
                       id="max_amount"
                       step="0.01"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm"
                       placeholder="999999.99">
            </div>

            <div class="flex items-end">
                <button type="button" 
                        wire:click="clearFilters"
                        class="w-full inline-flex justify-center items-center px-3 py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="mb-3 sm:mb-4 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 text-xs sm:text-sm text-gray-600">
        <div>
            Showing <?php echo e($expenses->count()); ?> of <?php echo e($expenses->total()); ?> pengeluaran
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($totalAmount > 0): ?>
                | Total: <span class="font-semibold">Rp <?php echo e(number_format($totalAmount / 1000, 0)); ?>K</span>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        <div>
            <?php echo e($totalCount); ?> total records
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="lg:hidden space-y-3 mb-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
                <div class="flex justify-between items-start mb-3">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-900"><?php echo e($expense->expense_date->format('d M Y')); ?></div>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium mt-1
                            <?php switch($expense->category):
                                case ('salary'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                <?php case ('utilities'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                <?php case ('supplies'): ?> bg-green-100 text-green-800 <?php break; ?>
                                <?php case ('marketing'): ?> bg-purple-100 text-purple-800 <?php break; ?>
                                <?php default: ?> bg-gray-100 text-gray-800
                            <?php endswitch; ?>">
                            <?php echo e($expense->category_display_name); ?>

                        </span>
                    </div>
                    <div class="text-sm font-bold text-gray-900 ml-2">
                        Rp <?php echo e(number_format($expense->amount / 1000, 0)); ?>K
                    </div>
                </div>
                
                <div class="space-y-1 text-xs text-gray-600 mb-3">
                    <div><span class="font-medium">Deskripsi:</span> <?php echo e($expense->description); ?></div>
                    <div><span class="font-medium">Dibuat oleh:</span> <?php echo e($expense->creator->name ?? 'System'); ?></div>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expense->receipt_photo): ?>
                        <div>
                            <a href="<?php echo e($expense->receipt_photo_url); ?>" target="_blank" class="inline-flex items-center text-accent-600 hover:text-accent-900">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Lihat Receipt
                            </a>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
                
                <div class="flex flex-wrap gap-2">
                    <a href="<?php echo e(route('admin.expenses.show', $expense)); ?>" 
                       class="inline-flex items-center px-3 py-1.5 bg-blue-500 hover:bg-blue-600 text-white text-xs font-medium rounded-lg transition-colors">
                        View
                    </a>
                    <a href="<?php echo e(route('admin.expenses.edit', $expense)); ?>" 
                       class="inline-flex items-center px-3 py-1.5 bg-indigo-500 hover:bg-indigo-600 text-white text-xs font-medium rounded-lg transition-colors">
                        Edit
                    </a>
                    <button wire:click="deleteExpense(<?php echo e($expense->id); ?>)" 
                            wire:confirm="Are you sure you want to delete this expense?"
                            class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition-colors">
                        Delete
                    </button>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white border border-gray-200 rounded-lg p-8 text-center">
                <p class="text-sm text-gray-500">No expenses found matching your criteria.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Desktop Table View -->
    <div class="hidden lg:block overflow-x-auto bg-white rounded-lg shadow">
        <table class="w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('expense_date')">
                        <div class="flex items-center space-x-1">
                            <span>Tanggal</span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortField === 'expense_date'): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortDirection === 'asc'): ?>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('category')">
                        <div class="flex items-center space-x-1">
                            <span>Kategori</span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortField === 'category'): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortDirection === 'asc'): ?>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Deskripsi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('amount')">
                        <div class="flex items-center space-x-1">
                            <span>Jumlah</span>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortField === 'amount'): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortDirection === 'asc'): ?>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php else: ?>
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dibuat Oleh
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Receipt
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($expense->expense_date->format('d M Y')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                <?php switch($expense->category):
                                    case ('salary'): ?> bg-blue-100 text-blue-800 <?php break; ?>
                                    <?php case ('utilities'): ?> bg-yellow-100 text-yellow-800 <?php break; ?>
                                    <?php case ('supplies'): ?> bg-green-100 text-green-800 <?php break; ?>
                                    <?php case ('marketing'): ?> bg-purple-100 text-purple-800 <?php break; ?>
                                    <?php default: ?> bg-gray-100 text-gray-800
                                <?php endswitch; ?>">
                                <?php echo e($expense->category_display_name); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate" title="<?php echo e($expense->description); ?>">
                                <?php echo e($expense->description); ?>

                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp <?php echo e(number_format($expense->amount, 0, ',', '.')); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($expense->creator->name ?? 'System'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expense->receipt_photo): ?>
                                <a href="<?php echo e($expense->receipt_photo_url); ?>" 
                                   target="_blank"
                                   class="text-accent-600 hover:text-accent-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </a>
                            <?php else: ?>
                                <span class="text-gray-400">No receipt</span>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="<?php echo e(route('admin.expenses.show', $expense)); ?>" 
                                   class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="<?php echo e(route('admin.expenses.edit', $expense)); ?>" 
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <button wire:click="deleteExpense(<?php echo e($expense->id); ?>)" 
                                        wire:confirm="Are you sure you want to delete this expense?"
                                        class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No expenses found matching your criteria.
                        </td>
                    </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4 sm:mt-6">
        <?php echo e($expenses->links()); ?>

    </div>

    <!-- Flash Messages -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50"
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/expense-list.blade.php ENDPATH**/ ?>