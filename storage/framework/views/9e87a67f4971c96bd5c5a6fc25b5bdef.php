<div>
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Pricing Configuration</h3>
        <p class="text-sm text-gray-600">Configure penalty rates, buffer times, and member discounts.</p>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('success')): ?>
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <form wire:submit.prevent="save" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Late Penalty Rate -->
            <div>
                <label for="late_penalty_per_hour" class="block text-sm font-medium text-gray-700">
                    Late Penalty Rate (per hour)
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="number" 
                           id="late_penalty_per_hour" 
                           wire:model="late_penalty_per_hour"
                           step="0.01"
                           min="0"
                           class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php $__errorArgs = ['late_penalty_per_hour'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['late_penalty_per_hour'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Penalty charged per hour for late returns.</p>
            </div>

            <!-- Buffer Time -->
            <div>
                <label for="buffer_time_hours" class="block text-sm font-medium text-gray-700">
                    Buffer Time (hours)
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" 
                           id="buffer_time_hours" 
                           wire:model="buffer_time_hours"
                           min="0"
                           max="24"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php $__errorArgs = ['buffer_time_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">hrs</span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['buffer_time_hours'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Time reserved after return for vehicle cleaning.</p>
            </div>

            <!-- Member Discount -->
            <div>
                <label for="member_discount_percentage" class="block text-sm font-medium text-gray-700">
                    Member Discount
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" 
                           id="member_discount_percentage" 
                           wire:model="member_discount_percentage"
                           step="0.01"
                           min="0"
                           max="100"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm <?php $__errorArgs = ['member_discount_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-300 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">%</span>
                    </div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['member_discount_percentage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <p class="mt-1 text-sm text-gray-500">Default discount percentage for member customers.</p>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 mb-3">Configuration Preview</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Late Penalty:</span>
                    <span class="font-medium">Rp <?php echo e(number_format($late_penalty_per_hour ?? 0, 0, ',', '.')); ?>/hour</span>
                </div>
                <div>
                    <span class="text-gray-600">Buffer Time:</span>
                    <span class="font-medium"><?php echo e($buffer_time_hours ?? 0); ?> hours</span>
                </div>
                <div>
                    <span class="text-gray-600">Member Discount:</span>
                    <span class="font-medium"><?php echo e($member_discount_percentage ?? 0); ?>%</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between">
            <button type="button" 
                    wire:click="resetToDefaults"
                    wire:confirm="Are you sure you want to reset to default values?"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reset to Defaults
            </button>

            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Save Configuration</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\livewire\admin\pricing-settings.blade.php ENDPATH**/ ?>