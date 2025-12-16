<div>
    <!-- Search and Filters -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       id="search"
                       placeholder="Name, phone, email, or NIK..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="memberStatus" class="block text-sm font-medium text-gray-700 mb-1">Member Status</label>
                <select wire:model.live="memberStatus" 
                        id="memberStatus"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $memberStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            
            <div>
                <label for="blacklistStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="blacklistStatus" 
                        id="blacklistStatus"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $blacklistStatusOptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($value); ?>"><?php echo e($label); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </select>
            </div>
            
            <div class="flex items-end">
                <button wire:click="clearFilters" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Clear Filters
                </button>
            </div>
        </div>
        
        <!-- Quick Filter Buttons -->
        <div class="flex flex-wrap gap-2">
            <button wire:click="toggleMembersOnly" 
                    class="px-3 py-1 text-sm rounded-full <?php echo e($showMembersOnly ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700'); ?> hover:bg-green-600 hover:text-white">
                <?php if (isset($component)) { $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.star','data' => ['class' => 'w-3 h-3 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 inline mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $attributes = $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $component = $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
                Members Only
            </button>
            
            <button wire:click="toggleBlacklistedOnly" 
                    class="px-3 py-1 text-sm rounded-full <?php echo e($showBlacklistedOnly ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'); ?> hover:bg-red-600 hover:text-white">
                <?php if (isset($component)) { $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.ban','data' => ['class' => 'w-3 h-3 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.ban'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 inline mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $attributes = $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $component = $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
                Blacklisted Only
            </button>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="mb-4">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            Loading customers...
        </div>
    </div>

    <!-- Customer Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('name')">
                            <div class="flex items-center">
                                Name
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'name'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortDirection === 'asc'): ?>
                                        <?php if (isset($component)) { $__componentOriginald2582e4961d14e40b7c3acffd51eb9d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-up','data' => ['class' => 'w-4 h-4 ml-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9)): ?>
<?php $attributes = $__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9; ?>
<?php unset($__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald2582e4961d14e40b7c3acffd51eb9d9)): ?>
<?php $component = $__componentOriginald2582e4961d14e40b7c3acffd51eb9d9; ?>
<?php unset($__componentOriginald2582e4961d14e40b7c3acffd51eb9d9); ?>
<?php endif; ?>
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-down','data' => ['class' => 'w-4 h-4 ml-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7)): ?>
<?php $attributes = $__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7; ?>
<?php unset($__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7)): ?>
<?php $component = $__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7; ?>
<?php unset($__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7); ?>
<?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Contact
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Bookings
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('created_at')">
                            <div class="flex items-center">
                                Registered
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortBy === 'created_at'): ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sortDirection === 'asc'): ?>
                                        <?php if (isset($component)) { $__componentOriginald2582e4961d14e40b7c3acffd51eb9d9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-up','data' => ['class' => 'w-4 h-4 ml-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-up'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9)): ?>
<?php $attributes = $__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9; ?>
<?php unset($__attributesOriginald2582e4961d14e40b7c3acffd51eb9d9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald2582e4961d14e40b7c3acffd51eb9d9)): ?>
<?php $component = $__componentOriginald2582e4961d14e40b7c3acffd51eb9d9; ?>
<?php unset($__componentOriginald2582e4961d14e40b7c3acffd51eb9d9); ?>
<?php endif; ?>
                                    <?php else: ?>
                                        <?php if (isset($component)) { $__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-down','data' => ['class' => 'w-4 h-4 ml-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-down'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 ml-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7)): ?>
<?php $attributes = $__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7; ?>
<?php unset($__attributesOriginalb812c3d4fc32bd0e54d75382d6e107c7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7)): ?>
<?php $component = $__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7; ?>
<?php unset($__componentOriginalb812c3d4fc32bd0e54d75382d6e107c7); ?>
<?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <?php if (isset($component)) { $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.user','data' => ['class' => 'h-6 w-6 text-gray-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.user'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-6 w-6 text-gray-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $attributes = $__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__attributesOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35)): ?>
<?php $component = $__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35; ?>
<?php unset($__componentOriginalb8c2af2c7c4a456e77f6ae42c74e5e35); ?>
<?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            <?php echo e($customer->name); ?>

                                        </div>
                                        <div class="text-sm text-gray-500">
                                            NIK: <?php echo e($customer->nik); ?>

                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900"><?php echo e($customer->phone); ?></div>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->email): ?>
                                    <div class="text-sm text-gray-500"><?php echo e($customer->email); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_member): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <?php if (isset($component)) { $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.star','data' => ['class' => 'w-3 h-3 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.star'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $attributes = $__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__attributesOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf)): ?>
<?php $component = $__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf; ?>
<?php unset($__componentOriginal53f1cd79c3eb94f304ba111c60ed8ebf); ?>
<?php endif; ?>
                                            Member (<?php echo e($customer->getMemberDiscountPercentage()); ?>%)
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_blacklisted): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <?php if (isset($component)) { $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.ban','data' => ['class' => 'w-3 h-3 mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.ban'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-3 h-3 mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $attributes = $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $component = $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
                                            Blacklisted
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Active
                                        </span>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($customerStats[$customer->id])): ?>
                                    <?php $stats = $customerStats[$customer->id] ?>
                                    <div class="text-sm">
                                        <div>Total: <?php echo e($stats['total_bookings']); ?></div>
                                        <div class="text-gray-500">Active: <?php echo e($stats['active_bookings']); ?></div>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?php echo e($customer->created_at->format('M d, Y')); ?>

                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="<?php echo e(route('admin.customers.show', $customer)); ?>" 
                                       class="text-blue-600 hover:text-blue-900">
                                        View
                                    </a>
                                    
                                    <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </a>
                                    
                                    <!-- Member Status Toggle -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$customer->is_blacklisted): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_member): ?>
                                            <button wire:click="updateMemberStatus(<?php echo e($customer->id); ?>, false)"
                                                    class="text-yellow-600 hover:text-yellow-900"
                                                    wire:confirm="Remove member status from <?php echo e($customer->name); ?>?">
                                                Remove Member
                                            </button>
                                        <?php else: ?>
                                            <button wire:click="updateMemberStatus(<?php echo e($customer->id); ?>, true, 10)"
                                                    class="text-green-600 hover:text-green-900">
                                                Make Member
                                            </button>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    
                                    <!-- Blacklist Toggle -->
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_blacklisted): ?>
                                        <button wire:click="updateBlacklistStatus(<?php echo e($customer->id); ?>, false)"
                                                class="text-green-600 hover:text-green-900"
                                                wire:confirm="Remove <?php echo e($customer->name); ?> from blacklist?">
                                            Unblock
                                        </button>
                                    <?php else: ?>
                                        <button onclick="blacklistCustomer(<?php echo e($customer->id); ?>, '<?php echo e($customer->name); ?>')"
                                                class="text-red-600 hover:text-red-900">
                                            Blacklist
                                        </button>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $memberStatus !== '' || $blacklistStatus !== ''): ?>
                                    No customers found matching your criteria.
                                <?php else: ?>
                                    No customers registered yet.
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customers->hasPages()): ?>
            <div class="px-6 py-3 border-t border-gray-200">
                <?php echo e($customers->links()); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Blacklist Modal -->
    <div x-data="{ showBlacklistModal: false, customerId: null, customerName: '' }" 
         x-on:blacklist-customer.window="showBlacklistModal = true; customerId = $event.detail.id; customerName = $event.detail.name">
        
        <div x-show="showBlacklistModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="updateBlacklistStatus(customerId, true, $refs.blacklistReason.value)">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <?php if (isset($component)) { $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.ban','data' => ['class' => 'h-6 w-6 text-red-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.ban'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'h-6 w-6 text-red-600']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $attributes = $__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__attributesOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33)): ?>
<?php $component = $__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33; ?>
<?php unset($__componentOriginal9f5c6099a040a8adaa35e0485a8e9e33); ?>
<?php endif; ?>
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Blacklist Customer
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            You are about to blacklist <strong x-text="customerName"></strong>. 
                                            This will prevent them from making new bookings and cancel any pending bookings.
                                        </p>
                                        <div class="mt-4">
                                            <label for="blacklistReason" class="block text-sm font-medium text-gray-700">
                                                Reason for blacklisting *
                                            </label>
                                            <textarea x-ref="blacklistReason"
                                                      id="blacklistReason"
                                                      rows="3"
                                                      required
                                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                                      placeholder="Enter the reason for blacklisting this customer..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Blacklist Customer
                            </button>
                            <button type="button"
                                    @click="showBlacklistModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function blacklistCustomer(customerId, customerName) {
    window.dispatchEvent(new CustomEvent('blacklist-customer', {
        detail: { id: customerId, name: customerName }
    }));
}
</script><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\livewire\admin\customer-list.blade.php ENDPATH**/ ?>