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
                <?php echo e(__('Detail Pelanggan: ') . $customer->name); ?>

            </h2>
            <div class="flex space-x-2">
                <a href="<?php echo e(route('admin.customers.edit', $customer)); ?>" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <?php if (isset($component)) { $__componentOriginala687d0c4a8470932588e1457121dd0ea = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala687d0c4a8470932588e1457121dd0ea = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.cog','data' => ['class' => 'w-4 h-4 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.cog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 inline mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala687d0c4a8470932588e1457121dd0ea)): ?>
<?php $attributes = $__attributesOriginala687d0c4a8470932588e1457121dd0ea; ?>
<?php unset($__attributesOriginala687d0c4a8470932588e1457121dd0ea); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala687d0c4a8470932588e1457121dd0ea)): ?>
<?php $component = $__componentOriginala687d0c4a8470932588e1457121dd0ea; ?>
<?php unset($__componentOriginala687d0c4a8470932588e1457121dd0ea); ?>
<?php endif; ?>
                    Edit Pelanggan
                </a>
                <a href="<?php echo e(route('admin.customers.index')); ?>" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <?php if (isset($component)) { $__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.icons.arrow-left','data' => ['class' => 'w-4 h-4 inline mr-1']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('icons.arrow-left'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-4 h-4 inline mr-1']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7)): ?>
<?php $attributes = $__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7; ?>
<?php unset($__attributesOriginaldaf5ec6ced2e3a1b979bb241323f28e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7)): ?>
<?php $component = $__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7; ?>
<?php unset($__componentOriginaldaf5ec6ced2e3a1b979bb241323f28e7); ?>
<?php endif; ?>
                    Kembali ke Pelanggan
                </a>
            </div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php echo e(session('error')); ?>

                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- Informasi Pelanggan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($customer->name); ?></p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telepon</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($customer->phone); ?></p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($customer->email ?: 'Tidak disediakan'); ?></p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($customer->nik); ?></p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($customer->address); ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Anggota</label>
                                    <div class="mt-1 flex items-center">
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
                                                Anggota (Diskon <?php echo e($discountInfo['discount_percentage']); ?>%)
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Pelanggan Biasa
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-1">
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
                                                Daftar Hitam
                                            </span>
                                            <p class="mt-1 text-sm text-red-600"><?php echo e($customer->blacklist_reason); ?></p>
                                        <?php else: ?>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tingkat Loyalitas</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            <?php if($loyaltyTier === 'platinum'): ?> bg-purple-100 text-purple-800
                                            <?php elseif($loyaltyTier === 'gold'): ?> bg-yellow-100 text-yellow-800
                                            <?php elseif($loyaltyTier === 'silver'): ?> bg-gray-100 text-gray-800
                                            <?php else: ?> bg-orange-100 text-orange-800 <?php endif; ?>">
                                            <?php echo e(ucfirst($loyaltyTier)); ?>

                                        </span>
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Penilaian Risiko</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            <?php if($riskAssessment['risk_level'] === 'high'): ?> bg-red-100 text-red-800
                                            <?php elseif($riskAssessment['risk_level'] === 'medium'): ?> bg-yellow-100 text-yellow-800
                                            <?php else: ?> bg-green-100 text-green-800 <?php endif; ?>">
                                            Risiko <?php echo e(ucfirst($riskAssessment['risk_level'])); ?>

                                        </span>
                                    </p>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($riskAssessment['risk_factors'])): ?>
                                        <ul class="mt-1 text-xs text-gray-600">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $riskAssessment['risk_factors']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $factor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>• <?php echo e($factor); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </ul>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTP</label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->ktp_photo): ?>
                                <img src="<?php echo e($customer->ktp_photo_url); ?>" alt="Foto KTP" class="w-full h-48 object-cover rounded-lg border">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gray-100 rounded-lg border flex items-center justify-center">
                                    <span class="text-gray-500">Foto KTP tidak diunggah</span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto SIM</label>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->sim_photo): ?>
                                <img src="<?php echo e($customer->sim_photo_url); ?>" alt="Foto SIM" class="w-full h-48 object-cover rounded-lg border">
                            <?php else: ?>
                                <div class="w-full h-48 bg-gray-100 rounded-lg border flex items-center justify-center">
                                    <span class="text-gray-500">Foto SIM tidak diunggah</span>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Pemesanan</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600"><?php echo e($statistics['total_bookings']); ?></div>
                            <div class="text-sm text-blue-600">Total Pemesanan</div>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-green-600"><?php echo e($statistics['completed_bookings']); ?></div>
                            <div class="text-sm text-green-600">Selesai</div>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-600"><?php echo e($statistics['active_bookings']); ?></div>
                            <div class="text-sm text-yellow-600">Aktif</div>
                        </div>
                        
                        <div class="bg-red-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-red-600"><?php echo e($statistics['cancelled_bookings']); ?></div>
                            <div class="text-sm text-red-600">Dibatalkan</div>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">Rp <?php echo e(number_format($statistics['total_revenue'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-purple-600">Total Pendapatan</div>
                        </div>
                        
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-indigo-600">Rp <?php echo e(number_format($statistics['average_booking_value'], 0, ',', '.')); ?></div>
                            <div class="text-sm text-indigo-600">Rata-rata Nilai Pemesanan</div>
                        </div>
                        
                        <div class="bg-pink-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-pink-600"><?php echo e(number_format($statistics['completion_rate'], 1)); ?>%</div>
                            <div class="text-sm text-pink-600">Tingkat Penyelesaian</div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-gray-600">
                                <?php echo e($statistics['last_booking_date'] ? $statistics['last_booking_date']->format('M d, Y') : 'Belum pernah'); ?>

                            </div>
                            <div class="text-sm text-gray-600">Pemesanan Terakhir</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemesanan Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pemesanan Terbaru</h3>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->bookings->count() > 0): ?>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pemesanan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $customer->bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                <?php echo e($booking->booking_number); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($booking->car->license_plate ?? 'N/A'); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <?php echo e($booking->start_date->format('M d, Y')); ?> - <?php echo e($booking->end_date->format('M d, Y')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp <?php echo e(number_format($booking->total_amount, 0, ',', '.')); ?>

                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    <?php if($booking->booking_status === 'completed'): ?> bg-green-100 text-green-800
                                                    <?php elseif($booking->booking_status === 'active'): ?> bg-blue-100 text-blue-800
                                                    <?php elseif($booking->booking_status === 'confirmed'): ?> bg-yellow-100 text-yellow-800
                                                    <?php elseif($booking->booking_status === 'cancelled'): ?> bg-red-100 text-red-800
                                                    <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                                                    <?php echo e(ucfirst($booking->booking_status)); ?>

                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500">Tidak ada pemesanan ditemukan untuk pelanggan ini.</p>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/customers/show.blade.php ENDPATH**/ ?>