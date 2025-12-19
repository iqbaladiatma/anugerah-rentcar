<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pusat Notifikasi</h2>
            <p class="text-sm text-gray-600">Kelola dan lihat notifikasi sistem</p>
        </div>
        <div class="flex items-center space-x-3">
            <button wire:click="refreshNotifications" 
                    class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <?php if (isset($component)) { $__componentOriginal1e798d8930f2907b8243830ae38d457e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1e798d8930f2907b8243830ae38d457e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-path','data' => ['class' => 'w-4 h-4 mr-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-path'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 mr-2']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1e798d8930f2907b8243830ae38d457e)): ?>
<?php $attributes = $__attributesOriginal1e798d8930f2907b8243830ae38d457e; ?>
<?php unset($__attributesOriginal1e798d8930f2907b8243830ae38d457e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1e798d8930f2907b8243830ae38d457e)): ?>
<?php $component = $__componentOriginal1e798d8930f2907b8243830ae38d457e; ?>
<?php unset($__componentOriginal1e798d8930f2907b8243830ae38d457e); ?>
<?php endif; ?>
                Refresh
            </button>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($unreadCount > 0): ?>
                <button wire:click="markAllAsRead" 
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Mark All Read (<?php echo e($unreadCount); ?>)
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <div class="flex flex-wrap items-center gap-4">
            <!-- Unread Filter -->
            <label class="flex items-center">
                <input type="checkbox" wire:model.live="showUnreadOnly" 
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <span class="ml-2 text-sm text-gray-700">Tampilkan yang belum dibaca</span>
            </label>

            <!-- Type Filter -->
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Jenis:</label>
                <select wire:model.live="selectedType" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $notificationTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <!-- Priority Filter -->
            <div class="flex items-center space-x-2">
                <label class="text-sm font-medium text-gray-700">Prioritas:</label>
                <select wire:model.live="selectedPriority" 
                        class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 text-sm">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $priorityOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>

            <!-- Clear Filters -->
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showUnreadOnly || $selectedType || $selectedPriority): ?>
                <button wire:click="clearFilters" 
                        class="text-sm text-blue-600 hover:text-blue-800">
                    Clear filters
                </button>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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

    <!-- Notifications List -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notifications->count() > 0): ?>
            <ul class="divide-y divide-gray-200">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="relative <?php echo e($notification->isUnread() ? 'bg-blue-50' : 'bg-white'); ?>">
                        <div class="px-4 py-4 flex items-start space-x-4">
                            <!-- Icon -->
                            <div class="flex-shrink-0">
                                <div class="w-10 h-10 rounded-full flex items-center justify-center <?php echo e($notification->priority_color); ?>">
                                    <?php if (isset($component)) { $__componentOriginal511d4862ff04963c3c16115c05a86a9d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal511d4862ff04963c3c16115c05a86a9d = $attributes; } ?>
<?php $component = Illuminate\View\DynamicComponent::resolve(['component' => 'icons.' . $notification->icon_class] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('dynamic-component'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\DynamicComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-5 h-5']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $attributes = $__attributesOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__attributesOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal511d4862ff04963c3c16115c05a86a9d)): ?>
<?php $component = $__componentOriginal511d4862ff04963c3c16115c05a86a9d; ?>
<?php unset($__componentOriginal511d4862ff04963c3c16115c05a86a9d); ?>
<?php endif; ?>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">
                                            <?php echo e($notification->title); ?>

                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->isUnread()): ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 ml-2">
                                                    Baru
                                                </span>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <?php echo e($notification->message); ?>

                                        </p>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->details): ?>
                                            <p class="text-xs text-gray-500 mt-1">
                                                <?php echo e($notification->details); ?>

                                            </p>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="text-xs text-gray-500">
                                                <?php echo e($notification->time_ago); ?>

                                            </span>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                <?php echo e($notification->priority === 'high' ? 'bg-red-100 text-red-800' : 
                                                   ($notification->priority === 'medium' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800')); ?>">
                                                <?php echo e(ucfirst($notification->priority)); ?>

                                            </span>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->action_url): ?>
                                            <a href="<?php echo e($notification->action_url); ?>" 
                                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                Lihat
                                            </a>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->isUnread()): ?>
                                            <button wire:click="markAsRead(<?php echo e($notification->id); ?>)" 
                                                    class="text-gray-400 hover:text-gray-600">
                                                <?php if (isset($component)) { $__componentOriginald437fe0064eab6d7fb2abdae5ed6f550 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald437fe0064eab6d7fb2abdae5ed6f550 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.check','data' => ['class' => 'w-4 h-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.check'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald437fe0064eab6d7fb2abdae5ed6f550)): ?>
<?php $attributes = $__attributesOriginald437fe0064eab6d7fb2abdae5ed6f550; ?>
<?php unset($__attributesOriginald437fe0064eab6d7fb2abdae5ed6f550); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald437fe0064eab6d7fb2abdae5ed6f550)): ?>
<?php $component = $__componentOriginald437fe0064eab6d7fb2abdae5ed6f550; ?>
<?php unset($__componentOriginald437fe0064eab6d7fb2abdae5ed6f550); ?>
<?php endif; ?>
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </ul>

            <!-- Pagination -->
            <div class="bg-white px-4 py-3 border-t border-gray-200">
                <?php echo e($notifications->links()); ?>

            </div>
        <?php else: ?>
            <div class="text-center py-12">
                <?php if (isset($component)) { $__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.bell','data' => ['class' => 'mx-auto h-12 w-12 text-gray-400']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.bell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'mx-auto h-12 w-12 text-gray-400']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7)): ?>
<?php $attributes = $__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7; ?>
<?php unset($__attributesOriginal4525404018e5b2e94f2d1e4dc53d4ad7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7)): ?>
<?php $component = $__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7; ?>
<?php unset($__componentOriginal4525404018e5b2e94f2d1e4dc53d4ad7); ?>
<?php endif; ?>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada notifikasi</h3>
                <p class="mt-1 text-sm text-gray-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($showUnreadOnly || $selectedType || $selectedPriority): ?>
                        Tidak ada notifikasi yang cocok dengan filter yang Anda pilih.
                    <?php else: ?>
                        Anda sudah terpangkat! Tidak ada notifikasi untuk ditampilkan.
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

    <?php
        $__scriptKey = '1376646460-0';
        ob_start();
    ?>
<script>
    // Auto-refresh notifications every 30 seconds
    setInterval(() => {
        $wire.dispatch('refresh-notifications');
    }, 30000);

    // Listen for notification events
    $wire.on('notification-read', () => {
        // Optional: Show toast or update UI
    });

    $wire.on('notifications-marked-read', (event) => {
        // Optional: Show toast with count
    });

    $wire.on('notifications-refreshed', () => {
        // Optional: Show refresh indicator
    });
</script>
    <?php
        $__output = ob_get_clean();

        \Livewire\store($this)->push('scripts', $__output, $__scriptKey)
    ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/livewire/admin/notification-center.blade.php ENDPATH**/ ?>