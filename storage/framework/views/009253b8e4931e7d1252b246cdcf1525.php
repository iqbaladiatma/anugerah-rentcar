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
        <div class="bg-gradient-to-r from-accent-500 to-accent-600 text-white">
            <div class="container-custom section-padding-sm">
                <div class="animate-fade-in">
                    <h1 class="heading-lg text-white mb-4">Katalog Kendaraan</h1>
                    <p class="text-xl text-accent-100">Pilih dari berbagai koleksi kendaraan rental berkualitas kami</p>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request()->hasAny(['start_date', 'end_date'])): ?>
                        <div class="mt-6 bg-accent-400 bg-opacity-30 rounded-xl p-4 border border-accent-300">
                            <p class="text-accent-50">
                                <span class="font-semibold">Menampilkan kendaraan tersedia untuk:</span>
                                <?php echo e(request('start_date') ? \Carbon\Carbon::parse(request('start_date'))->format('d M Y') : 'Tidak ditentukan'); ?>

                                -
                                <?php echo e(request('end_date') ? \Carbon\Carbon::parse(request('end_date'))->format('d M Y') : 'Tidak ditentukan'); ?>

                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(request('start_date') && request('end_date')): ?>
                                    (<?php echo e(\Carbon\Carbon::parse(request('start_date'))->diffInDays(\Carbon\Carbon::parse(request('end_date'))) + 1); ?> hari)
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </p>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>

        <div class="container-custom section-padding-sm">
            <div class="lg:grid lg:grid-cols-4 lg:gap-8">
                <!-- Filters Sidebar -->
                <div class="lg:col-span-1">
                    <div class="card p-6 sticky top-4 animate-slide-up">
                        <div class="flex items-center mb-6">
                            <div class="w-8 h-8 bg-gradient-to-r from-accent-500 to-accent-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <h3 class="heading-sm">Filter Pencarian</h3>
                        </div>
                        
                        <form method="GET" action="<?php echo e(route('vehicles.catalog')); ?>" class="space-y-6" id="filterForm">
                            <!-- Date Range -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-3">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                    </svg>
                                    Periode Rental
                                </label>
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tanggal Ambil</label>
                                        <input type="date" name="start_date" value="<?php echo e(request('start_date')); ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent text-sm"
                                               min="<?php echo e(date('Y-m-d')); ?>" id="startDate">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Tanggal Kembali</label>
                                        <input type="date" name="end_date" value="<?php echo e(request('end_date')); ?>" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent text-sm"
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
                                    Merek Kendaraan
                                </label>
                                <select name="brand" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent text-sm">
                                    <option value="">Semua Merek</option>
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
                                    Rentang Harga
                                </label>
                                <select name="max_price" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent text-sm">
                                    <option value="">Semua Harga</option>
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

                                           class="w-4 h-4 text-accent-600 border-gray-300 rounded focus:ring-accent-500">
                                    <span class="text-sm font-medium text-gray-700">
                                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                        </svg>
                                        Dengan Sopir
                                    </span>
                                </label>
                            </div>

                            <div class="space-y-3 pt-4 border-t border-gray-200">
                                <button type="submit" class="w-full bg-accent-500 text-white py-3 px-4 rounded-lg hover:bg-accent-600 transition-colors font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                                    </svg>
                                    Terapkan Filter
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
                                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-200 group flex flex-col">
                                    <!-- Vehicle Image -->
                                    <div class="relative overflow-hidden">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->photo_front): ?>
                                            <img src="<?php echo e(asset('storage/' . $vehicle->photo_front)); ?>" 
                                                 alt="<?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>"
                                                 class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-300">
                                        <?php else: ?>
                                            <div class="w-full h-52 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                                <svg class="w-20 h-20 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                </svg>
                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        
                                        <!-- Availability Badge -->
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-green-500 text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow-lg">
                                                Available
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Vehicle Info -->
                                    <div class="p-5 flex flex-col flex-grow">
                                        <!-- Title & Basic Info -->
                                        <div class="mb-4">
                                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-1">
                                                <?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>

                                            </h3>
                                            <div class="flex items-center text-sm text-gray-600 space-x-2">
                                                <span class="flex items-center">
                                                    <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <?php echo e($vehicle->year); ?>

                                                </span>
                                                <span class="text-gray-400">•</span>
                                                <span><?php echo e($vehicle->color); ?></span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-500 mt-1">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                                    <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                                                </svg>
                                                <?php echo e($vehicle->license_plate); ?>

                                            </div>
                                        </div>
                                        
                                        <!-- Features -->
                                        <div class="grid grid-cols-2 gap-3 mb-4 pb-4 border-b border-gray-100">
                                            <div class="flex items-center text-sm text-gray-700">
                                                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>Air Conditioning</span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-700">
                                                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>Manual Trans.</span>
                                            </div>
                                            <div class="flex items-center text-sm text-gray-700">
                                                <svg class="w-4 h-4 mr-2 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span>5 Seats</span>
                                            </div>
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->driver_fee_per_day > 0): ?>
                                                <div class="flex items-center text-sm text-accent-600 font-medium">
                                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                    </svg>
                                                    <span>Driver Available</span>
                                                </div>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>

                                        <!-- Pricing & Actions -->
                                        <div class="mt-auto">
                                            <div class="mb-4">
                                                <div class="flex items-baseline mb-1">
                                                    <span class="text-2xl font-bold text-accent-600">
                                                        Rp <?php echo e(number_format($vehicle->daily_rate, 0, ',', '.')); ?>

                                                    </span>
                                                    <span class="text-sm text-gray-500 ml-1">/day</span>
                                                </div>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->weekly_rate && $vehicle->weekly_rate < ($vehicle->daily_rate * 7)): ?>
                                                    <p class="text-xs text-green-600 font-medium">
                                                        Weekly: Rp <?php echo e(number_format($vehicle->weekly_rate, 0, ',', '.')); ?>

                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($vehicle->driver_fee_per_day > 0): ?>
                                                    <p class="text-xs text-gray-500 mt-0.5">
                                                        +Rp <?php echo e(number_format($vehicle->driver_fee_per_day, 0, ',', '.')); ?>/day with driver
                                                    </p>
                                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            </div>
                                            
                                            <!-- Action Buttons -->
                                            <div class="flex gap-2">
                                                <a href="<?php echo e(route('vehicles.show', $vehicle)); ?>" 
                                                   class="flex-1 text-center bg-white border-2 border-gray-300 text-gray-700 px-4 py-2.5 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all font-medium text-sm">
                                                    Details
                                                </a>
                                                <button 
                                                    onclick="openBookingModal(<?php echo e($vehicle->id); ?>, '<?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?>', <?php echo e($vehicle->daily_rate); ?>, '<?php echo e(request('start_date')); ?>', '<?php echo e(request('end_date')); ?>')"
                                                    class="flex-1 bg-accent-500 text-white px-4 py-2.5 rounded-lg hover:bg-accent-600 transition-all font-semibold shadow-md hover:shadow-lg text-sm">
                                                    Book Now
                                                </button>
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
                                       class="inline-flex items-center px-4 py-2 bg-accent-500 text-white rounded-lg hover:bg-accent-600 transition-colors">
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

    <!-- Booking Modal -->
    <div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50" onclick="closeBookingModal(event)">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4 transform transition-all" onclick="event.stopPropagation()">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-accent-500 to-accent-600 text-white px-6 py-4 rounded-t-2xl">
                <div class="flex items-center justify-between">
                    <h3 class="text-xl font-bold">Pesan Kendaraan</h3>
                    <button onclick="closeBookingModal()" class="text-white hover:text-gray-200 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Content -->
            <div class="p-6">
                <!-- Vehicle Info -->
                <div class="bg-accent-50 rounded-lg p-4 mb-6">
                    <div class="flex items-center mb-2">
                        <svg class="w-5 h-5 text-accent-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                        <span class="font-semibold text-gray-900" id="modalVehicleName"></span>
                    </div>
                    <div class="text-2xl font-bold text-accent-600" id="modalVehiclePrice"></div>
                </div>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
                    <!-- Logged In - Show Booking Options -->
                    <div class="space-y-4">
                        <p class="text-gray-700 text-center mb-4">Pilih tanggal rental untuk melanjutkan pemesanan</p>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                            <input type="date" id="modalStartDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-transparent" min="<?php echo e(date('Y-m-d')); ?>">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                            <input type="date" id="modalEndDate" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-transparent" min="<?php echo e(date('Y-m-d')); ?>">
                        </div>

                        <button onclick="proceedToBooking()" class="w-full bg-accent-500 text-white py-3 px-4 rounded-lg hover:bg-accent-600 transition-colors font-semibold shadow-md hover:shadow-lg">
                            Lanjutkan Pemesanan
                        </button>
                    </div>
                <?php else: ?>
                    <!-- Not Logged In - Show Login/Register Options -->
                    <div class="text-center space-y-4">
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-left">
                                    <h4 class="font-semibold text-yellow-800 mb-1">Akun Diperlukan</h4>
                                    <p class="text-sm text-yellow-700">Anda perlu masuk atau mendaftar untuk melakukan pemesanan kendaraan.</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <a href="<?php echo e(route('login')); ?>" class="block w-full bg-accent-500 text-white py-3 px-4 rounded-lg hover:bg-accent-600 transition-colors font-semibold shadow-md hover:shadow-lg">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                Masuk ke Akun
                            </a>
                            
                            <a href="<?php echo e(route('customer.register')); ?>" class="block w-full bg-white border-2 border-accent-500 text-accent-600 py-3 px-4 rounded-lg hover:bg-accent-50 transition-colors font-semibold">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                Daftar Akun Baru
                            </a>
                        </div>

                        <p class="text-sm text-gray-500 mt-4">
                            Sudah punya akun? <a href="<?php echo e(route('login')); ?>" class="text-accent-600 hover:text-accent-600 font-medium">Masuk di sini</a>
                        </p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        let currentVehicleId = null;

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

        // Modal functions
        function openBookingModal(vehicleId, vehicleName, vehiclePrice, startDate = '', endDate = '') {
            currentVehicleId = vehicleId;
            document.getElementById('modalVehicleName').textContent = vehicleName;
            document.getElementById('modalVehiclePrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(vehiclePrice) + '/day';
            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
            // Pre-fill dates if available
            if (startDate) {
                document.getElementById('modalStartDate').value = startDate;
            }
            if (endDate) {
                document.getElementById('modalEndDate').value = endDate;
            }
            
            // Setup date validation
            const modalStartInput = document.getElementById('modalStartDate');
            const modalEndInput = document.getElementById('modalEndDate');
            
            modalStartInput.addEventListener('change', function() {
                const start = new Date(this.value);
                const end = new Date(modalEndInput.value);
                
                if (!modalEndInput.value || end <= start) {
                    const nextDay = new Date(start);
                    nextDay.setDate(nextDay.getDate() + 1);
                    modalEndInput.value = nextDay.toISOString().split('T')[0];
                }
                
                modalEndInput.min = this.value;
            });
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            const modal = document.getElementById('bookingModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeBookingModal(event) {
            if (!event || event.target.id === 'bookingModal') {
                const modal = document.getElementById('bookingModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
        function proceedToBooking() {
            const startDate = document.getElementById('modalStartDate').value;
            const endDate = document.getElementById('modalEndDate').value;
            
            if (!startDate || !endDate) {
                alert('Mohon pilih tanggal mulai dan selesai rental');
                return;
            }
            
            // Redirect to booking wizard
            window.location.href = `<?php echo e(route('booking.wizard')); ?>?car_id=${currentVehicleId}&start_date=${startDate}&end_date=${endDate}`;
        }
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeBookingModal();
            }
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
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/public/vehicles/catalog.blade.php ENDPATH**/ ?>