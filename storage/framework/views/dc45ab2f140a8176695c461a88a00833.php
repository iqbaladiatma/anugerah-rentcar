<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Notification Preferences</h2>
            <p class="text-sm text-gray-600">Customize how and when you receive notifications</p>
        </div>
        <div class="flex items-center space-x-3">
            <button wire:click="resetToDefaults" 
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Reset to Defaults
            </button>
            <button wire:click="savePreferences" 
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Save Preferences
            </button>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session()->has('message')): ?>
        <div class="bg-green-50 border border-green-200 rounded-md p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <?php if (isset($component)) { $__componentOriginald93033b2df08a1efea59e9d288d32c2d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald93033b2df08a1efea59e9d288d32c2d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.check-circle','data' => ['class' => 'h-5 w-5 text-green-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.check-circle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-5 w-5 text-green-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald93033b2df08a1efea59e9d288d32c2d)): ?>
<?php $attributes = $__attributesOriginald93033b2df08a1efea59e9d288d32c2d; ?>
<?php unset($__attributesOriginald93033b2df08a1efea59e9d288d32c2d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald93033b2df08a1efea59e9d288d32c2d)): ?>
<?php $component = $__componentOriginald93033b2df08a1efea59e9d288d32c2d; ?>
<?php unset($__componentOriginald93033b2df08a1efea59e9d288d32c2d); ?>
<?php endif; ?>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">
                        <?php echo e(session('message')); ?>

                    </p>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Global Settings -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Global Settings</h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Preferred Time for Daily Digest
                </label>
                <input type="time" 
                       wire:model="globalPreferredTime"
                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <p class="text-xs text-gray-500 mt-1">Time when daily digest emails will be sent</p>
            </div>
        </div>
    </div>

    <!-- Notification Type Settings -->
    <div class="space-y-6">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $notificationTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $info): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900"><?php echo e($info['label']); ?></h3>
                        <p class="text-sm text-gray-600"><?php echo e($info['description']); ?></p>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Delivery Methods -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Delivery Methods</h4>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.<?php echo e($type); ?>.email_enabled"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Email notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.<?php echo e($type); ?>.sms_enabled"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">SMS notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.<?php echo e($type); ?>.browser_enabled"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Browser notifications</span>
                            </label>
                        </div>
                    </div>

                    <!-- Timing -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Timing</h4>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.<?php echo e($type); ?>.instant_notifications"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Instant notifications</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       wire:model="preferences.<?php echo e($type); ?>.daily_digest"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Daily digest</span>
                            </label>
                        </div>
                    </div>

                    <!-- Priority Filter -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Priority Levels</h4>
                        <div class="space-y-3">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = ['high', 'medium', 'low']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $priority): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           <?php if(isset($preferences[$type]['priority_filter']) && in_array($priority, $preferences[$type]['priority_filter'])): ?> checked <?php endif; ?>
                                           wire:click="togglePriority('<?php echo e($type); ?>', '<?php echo e($priority); ?>')"
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 capitalize"><?php echo e($priority); ?> priority</span>
                                    <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        <?php echo e($priority === 'high' ? 'bg-red-100 text-red-800' : 
                                           ($priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                        <?php echo e(ucfirst($priority)); ?>

                                    </span>
                                </label>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Save Button (Bottom) -->
    <div class="flex justify-end">
        <button wire:click="savePreferences" 
                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Save All Preferences
        </button>
    </div>
</div>

    <?php
        $__scriptKey = '3761279078-1';
        ob_start();
    ?>
<script>
    $wire.on('preferences-saved', () => {
        // Optional: Show success toast or animation
    });
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\livewire\admin\notification-preferences.blade.php ENDPATH**/ ?>