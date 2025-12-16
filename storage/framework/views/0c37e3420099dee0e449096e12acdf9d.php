<div class="overflow-hidden rounded-lg bg-white shadow">
    <div class="p-6">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-semibold leading-6 text-gray-900">Maintenance & Renewals</h3>
            <div class="flex items-center space-x-2">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->urgentCount > 0): ?>
                    <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800">
                        <?php echo e($this->urgentCount); ?> urgent
                    </span>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <button 
                    wire:click="refreshNotifications"
                    class="text-sm font-medium text-blue-600 hover:text-blue-500"
                    title="Refresh notifications"
                >
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <div class="mt-6 flow-root">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($this->notifications->count() > 0): ?>
                <ul role="list" class="-my-5 divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $this->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="py-4">
                            <div class="flex space-x-3">
                                <div class="flex-shrink-0">
                                    <?php
                                        $iconColors = [
                                            'high' => 'bg-red-100 text-red-600',
                                            'medium' => 'bg-yellow-100 text-yellow-600',
                                            'low' => 'bg-blue-100 text-blue-600',
                                        ];
                                    ?>
                                    <div class="flex h-6 w-6 items-center justify-center rounded-full <?php echo e($iconColors[$notification['priority']] ?? 'bg-gray-100 text-gray-600'); ?>">
                                        <?php echo $__env->make('components.icons.' . $notification['icon'], ['class' => 'h-4 w-4'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                                    </div>
                                </div>
                                <div class="min-w-0 flex-1">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900"><?php echo e($notification['title']); ?></p>
                                            <p class="text-sm text-gray-900"><?php echo e($notification['message']); ?></p>
                                            <p class="text-sm text-gray-500"><?php echo e($notification['details']); ?></p>
                                            
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification['type'] === 'oil_change' && $notification['days_overdue'] > 0): ?>
                                                <div class="mt-1">
                                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                                        <?php echo e($notification['days_overdue']); ?> days overdue
                                                    </span>
                                                </div>
                                            <?php elseif($notification['type'] === 'stnk_expiry' && $notification['days_left'] <= 7): ?>
                                                <div class="mt-1">
                                                    <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                                        Urgent: <?php echo e($notification['days_left']); ?> days left
                                                    </span>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                        
                                        <div class="flex items-center space-x-2 ml-4">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($notification['action_url'])): ?>
                                                <a href="<?php echo e($notification['action_url']); ?>" 
                                                   class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                                    View Vehicle
                                                </a>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification['type'] === 'oil_change'): ?>
                                                <button 
                                                    wire:click="markAsHandled('<?php echo e($notification['id']); ?>')"
                                                    class="text-sm font-medium text-green-600 hover:text-green-500"
                                                    title="Mark as completed"
                                                >
                                                    Complete
                                                </button>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </ul>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$showAll && $this->notifications->count() >= 5): ?>
                    <div class="mt-4 text-center">
                        <button 
                            wire:click="toggleShowAll"
                            class="text-sm font-medium text-blue-600 hover:text-blue-500"
                        >
                            Show all notifications
                        </button>
                    </div>
                <?php elseif($showAll): ?>
                    <div class="mt-4 text-center">
                        <button 
                            wire:click="toggleShowAll"
                            class="text-sm font-medium text-blue-600 hover:text-blue-500"
                        >
                            Show less
                        </button>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php else: ?>
                <div class="text-center py-8">
                    <div class="flex justify-center">
                        <?php echo $__env->make('components.icons.adjustments', ['class' => 'h-12 w-12 text-gray-400'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    </div>
                    <p class="mt-2 text-sm text-gray-500">No maintenance notifications</p>
                    <p class="text-xs text-gray-400">All vehicles are up to date</p>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\livewire\admin\maintenance-notifications.blade.php ENDPATH**/ ?>