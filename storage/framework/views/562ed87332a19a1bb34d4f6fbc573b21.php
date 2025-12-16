<?php if (isset($component)) { $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06 = $attributes; } ?>
<?php $component = App\View\Components\PublicLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('public-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\PublicLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="bg-white min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <h1 class="text-4xl font-bold mb-4">Vehicle Catalog</h1>
                <p class="text-xl text-blue-100">Choose from our wide selection of quality rental vehicles</p>
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['start_date', 'end_date'])): ?>
                    <div class="mt-4 bg-blue-500 bg-opacity-50 rounded-lg p-4">
                        <p class="text-sm">
                            <span class="font-medium">Showing available vehicles for:</span>
                            <?php echo e(request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('M d, Y') : 'Not specified'); ?>

                            -
                            <?php echo e(request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('M d, Y') : 'Not specified'); ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('start_date') && request('end_date')): ?>
                                (<?php echo e(\Carbon\Carbon::parse(request('start_date'))->diffInDays(\Carbon\Carbon::parse(request('end_date'))) + 1); ?> days)
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4 border border-gray-100">
                        <div class="flex items-center mb-6">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                            </svg>
                            <h3 class="text-lg font-semibold text-gray-900">Search Filters</h3>
                        </div>
                        
                        <form method="GET" action="<?php echo e(route('vehicles.catalog')); ?>" class="space-y-6" id="filterForm">
                            <!-- Date Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    Rental Period
                                </label>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Pickup Date</label>
                                        <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                               min="<?php echo e(date('Y-m-d')); ?>" id="startDate">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Return Date</label>
                                        <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm"
                                               min="<?php echo e(date('Y-m-d')); ?>" id="endDate">
                                    </div>
                                </div>
                            </div>

                            <!-- Brand Filter -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                    </svg>
                                    Vehicle Brand
                                </label>
                                <select name="brand" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">All Brands</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($brand); ?>" <?php echo e(request('brand') === $brand ? 'selected' : ''); ?>>
                                            <?php echo e($brand); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                    </svg>
                                    Price Range
                                </label>
                                <select name="max_price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                                    <option value="">Any Price</option>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $priceRanges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $range): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($range['value']); ?>" <?php echo e(request('max_price') == $range['value'] ? 'selected' : ''); ?>>
                                            <?php echo e($range['label']); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </select>
                            </div>

                            <!-- Driver Option -->
                            <div>
                                <label class="flex items-center space-x-3 cursor-pointer">
                                    <input type="checkbox" name="with_driver" value="1" 
                                           <?php echo e(request('with_driver') === '1' ? 'checked' : ''); ?>

                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        With Driver
                                    </span>
                                </label>
                            </div>

                            <div class="space-y-3 pt-4 border-t border-gray-200">
                                <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                    </svg>
                                    Apply Filters
                                </button>
                                
                                <?php if(request()->hasAny(['start_date', 'end_date', 'brand', 'max_price', 'with_driver'])): ?>
                                    <a href="<?php echo e(route('vehicles.catalog')); ?>" class="w-full bg-gray-100 text-gray-700 py-3 px-4 rounded-lg hover:bg-gray-200 transition-colors text-center block font-medium">
                                        <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Clear All Filters
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Vehicle Grid -->
                <div class="lg:col-span-3 mt-8 lg:mt-0">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicles->count() > 0): ?>
                        <!-- Results Summary -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="text-sm text-gray-600">
                                Showing <?php echo e($vehicles->firstItem()); ?>-<?php echo e($vehicles->lastItem()); ?> of <?php echo e($vehicles->total()); ?> vehicles
                            </div>
                            <div class="text-sm text-gray-500">
                                <?php echo e($vehicles->count()); ?> results on this page
                            </div>
                        </div>

                        <!-- Vehicle Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $vehicles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                                    <!-- Vehicle Image -->
                                    <div class="relative overflow-hidden">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->photo_front): ?>
                                            <img src="<?php echo e(asset('storage/' . $vehicle->photo_front)); ?>" 
                                                 alt="<?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>"
                                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                        <?php else: ?>
                                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <!-- Availability Badge -->
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-green-500 text-white text-xs font-medium px-2 py-1 rounded-full shadow-lg">
                                                Available
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Vehicle Info -->
                                    <div class="p-6">
                                        <div class="mb-4">
                                            <h3 class="text-xl font-bold text-gray-900 mb-1">
                                                <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>

                                            </h3>
                                            <p class="text-sm text-gray-600"><?php echo e($vehicle->year); ?> • <?php echo e($vehicle->color); ?> • <?php echo e($vehicle->license_plate); ?></p>
                                        </div>
                                        
                                        <!-- Features -->
                                        <div class="grid grid-cols-2 gap-2 mb-4">
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Air Conditioning
                                            </div>
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                Manual Trans.
                                            </div>
                                            <div class="flex items-center text-xs text-gray-600">
                                                <svg class="w-3 h-3 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                5 Seats
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->driver_fee_per_day > 0): ?>
                                                <div class="flex items-center text-xs text-blue-600">
                                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Driver Available
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>

                                        <!-- Pricing -->
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <div class="flex items-baseline space-x-1">
                                                    <span class="text-2xl font-bold text-blue-600">
                                                        Rp <?php echo e(number_format($vehicle->daily_rate, 0, ',', '.')); ?>

                                                    </span>
                                                    <span class="text-sm text-gray-500">/day</span>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->weekly_rate && $vehicle->weekly_rate < ($vehicle->daily_rate * 7)): ?>
                                                    <p class="text-xs text-green-600 font-medium">
                                                        Weekly: Rp <?php echo e(number_format($vehicle->weekly_rate, 0, ',', '.')); ?>

                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->driver_fee_per_day > 0): ?>
                                                    <p class="text-xs text-gray-500">
                                                        +Rp <?php echo e(number_format($vehicle->driver_fee_per_day, 0, ',', '.')); ?>/day driver
                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            <div class="flex space-x-2">
                                                <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" 
                                                   class="bg-gray-100 text-gray-700 px-3 py-2 rounded-lg hover:bg-gray-200 transition-colors font-medium text-sm">
                                                    Details
                                                </a>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['start_date', 'end_date'])): ?>
                                                    <a href="<?php echo e(route('booking.wizard', ['car_id' => $vehicle->id, 'start_date' => request('start_date'), 'end_date' => request('end_date')])); ?>" 
                                                       class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg text-sm">
                                                        Book Now
                                                    </a>
                                                <?php else: ?>
                                                    <button onclick="alert('Please select dates first')" 
                                                            class="bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg text-sm">
                                                        Book Now
                                                    </button>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>

                        <!-- Pagination -->
                        <div class="mt-12">
                            <?php echo e($vehicles->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-16">
                            <div class="max-w-md mx-auto">
                                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.175-5.5-2.709"/>
                                </svg>
                                <h3 class="text-xl font-medium text-gray-900 mb-2">No vehicles found</h3>
                                <p class="text-gray-500 mb-6">We couldn't find any vehicles matching your search criteria. Try adjusting your filters or check back later.</p>
                                
                                <?php if(request()->hasAny(['start_date', 'end_date', 'brand', 'max_price', 'with_driver'])): ?>
                                    <a href="<?php echo e(route('vehicles.catalog')); ?>" 
                                       class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                        </svg>
                                        Clear All Filters
                                    </a>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        // Auto-update end date when start date changes
        document.getElementById('startDate').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDateInput = document.getElementById('endDate');
            const currentEndDate = new Date(endDateInput.value);
            
            // If end date is before or same as start date, set it to start date + 1 day
            if (!endDateInput.value || currentEndDate <= startDate) {
                const nextDay = new Date(startDate);
                nextDay.setDate(nextDay.getDate() + 1);
                endDateInput.value = nextDay.toISOString().split('T')[0];
            }
            
            // Update minimum date for end date
            endDateInput.min = this.value;
        });

        // Real-time search functionality (optional enhancement)
        let searchTimeout;
        document.getElementById('filterForm').addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Could implement AJAX search here for better UX
                // For now, we'll rely on form submission
            }, 500);
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\public\vehicles\catalog.blade.php ENDPATH**/ ?>