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
                <?php echo e(__('Expense Details')); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.expenses.edit', $expense)); ?>" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Expense
                </a>
                <form method="POST" action="<?php echo e(route('admin.expenses.destroy', $expense)); ?>" 
                      onsubmit="return confirm('Are you sure you want to delete this expense?')" class="inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" 
                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </form>
                <a href="<?php echo e(route('admin.expenses.index')); ?>" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Expenses
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Expense Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Expense Information</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Category</label>
                                    <div class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            <?php echo e($expense->category_display_name); ?>

                                        </span>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Description</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($expense->description); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Amount</label>
                                    <p class="mt-1 text-2xl font-bold text-green-600">
                                        <?php echo e(number_format($expense->amount, 0, ',', '.')); ?> IDR
                                    </p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Expense Date</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($expense->expense_date->format('d F Y')); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Created By</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($expense->creator->name ?? 'Unknown'); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Created At</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($expense->created_at->format('d F Y H:i')); ?></p>
                                </div>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expense->updated_at != $expense->created_at): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($expense->updated_at->format('d F Y H:i')); ?></p>
                                </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>

                        <!-- Receipt Photo -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Receipt Photo</h3>
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($expense->receipt_photo): ?>
                                <div class="border rounded-lg p-4">
                                    <img src="<?php echo e($expense->receipt_photo_url); ?>" 
                                         alt="Receipt for <?php echo e($expense->description); ?>" 
                                         class="w-full rounded-lg shadow-md cursor-pointer"
                                         onclick="openImageModal(this.src)">
                                    <p class="mt-2 text-sm text-gray-500 text-center">
                                        Click to view full size
                                    </p>
                                </div>
                            <?php else: ?>
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                                    <?php if (isset($component)) { $__componentOriginalec84bc158a25135b58f1df8c1cc48af1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalec84bc158a25135b58f1df8c1cc48af1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.receipt-tax','data' => ['class' => 'mx-auto h-12 w-12 text-gray-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.receipt-tax'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mx-auto h-12 w-12 text-gray-400']); ?>
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
                                    <p class="mt-2 text-sm text-gray-500">No receipt photo uploaded</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 bg-black bg-opacity-75 hidden z-50 flex items-center justify-center p-4">
        <div class="relative max-w-4xl max-h-full">
            <button onclick="closeImageModal()" 
                    class="absolute top-4 right-4 text-white hover:text-gray-300 text-2xl font-bold z-10">
                ×
            </button>
            <img id="modalImage" src="" alt="Receipt" class="max-w-full max-h-full rounded-lg">
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function openImageModal(src) {
            document.getElementById('modalImage').src = src;
            document.getElementById('imageModal').classList.remove('hidden');
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\expenses\show.blade.php ENDPATH**/ ?>