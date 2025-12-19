
<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->sudahSerahKunci() || $booking->sudahTerimaKunci()): ?>
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <div class="bg-gradient-to-r from-accent-500 to-accent-600 px-6 py-4">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
            <h2 class="text-lg font-semibold text-white">Status Penyerahan Kunci</h2>
        </div>
    </div>
    
    <div class="p-6">
        
        <div class="space-y-6">
            
            <?php if($booking->sudahSerahKunci()): ?>
            <div class="relative pl-8">
                
                <div class="absolute left-0 top-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                
                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$booking->sudahTerimaKunci()): ?>
                <div class="absolute left-3 top-6 bottom-0 w-0.5 bg-gray-300"></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <div class="mb-2">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span>Kunci Diserahkan</span>
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Selesai
                        </span>
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e($booking->tanggal_serah_kunci->format('d M Y, H:i')); ?> WIB
                    </p>
                    <p class="text-sm text-gray-600">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Petugas: <?php echo e($booking->petugasSerahKunci->name ?? 'Staff'); ?>

                    </p>
                </div>

                
                <?php if($booking->foto_serah_kunci): ?>
                    <?php
                        $fotoSerah = json_decode($booking->foto_serah_kunci, true) ?? [];
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($fotoSerah) > 0): ?>
                    <div class="mt-3">
                        <p class="text-sm font-medium text-gray-700 mb-2">Foto Kondisi Kendaraan:</p>
                        <div class="grid grid-cols-4 gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($fotoSerah, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(asset('storage/' . $foto)); ?>" target="_blank" class="group">
                                    <img src="<?php echo e(asset('storage/' . $foto)); ?>" 
                                         alt="Foto <?php echo e($index + 1); ?>" 
                                         class="w-full h-16 object-cover rounded border border-gray-300 group-hover:opacity-75 transition">
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(count($fotoSerah) > 4): ?>
                            <p class="text-xs text-gray-500 mt-1">+<?php echo e(count($fotoSerah) - 4); ?> foto lainnya</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->catatan_serah_kunci): ?>
                <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                    <p class="text-sm font-medium text-gray-700 mb-1">Catatan:</p>
                    <p class="text-sm text-gray-600"><?php echo e($booking->catatan_serah_kunci); ?></p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->sudahTerimaKunci()): ?>
            <div class="relative pl-8">
                
                <div class="absolute left-0 top-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                
                <div class="mb-2">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span>Kunci Dikembalikan</span>
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Selesai
                        </span>
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                        </svg>
                        <?php echo e($booking->tanggal_terima_kunci->format('d M Y, H:i')); ?> WIB
                    </p>
                    <p class="text-sm text-gray-600">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                        </svg>
                        Petugas: <?php echo e($booking->petugasTerimaKunci->name ?? 'Staff'); ?>

                    </p>
                </div>

                
                <?php if($booking->foto_terima_kunci): ?>
                    <?php
                        $fotoTerima = json_decode($booking->foto_terima_kunci, true) ?? [];
                    ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($fotoTerima) > 0): ?>
                    <div class="mt-3">
                        <p class="text-sm font-medium text-gray-700 mb-2">Foto Kondisi Pengembalian:</p>
                        <div class="grid grid-cols-4 gap-2">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice($fotoTerima, 0, 4); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(asset('storage/' . $foto)); ?>" target="_blank" class="group">
                                    <img src="<?php echo e(asset('storage/' . $foto)); ?>" 
                                         alt="Foto <?php echo e($index + 1); ?>" 
                                         class="w-full h-16 object-cover rounded border border-gray-300 group-hover:opacity-75 transition">
                                </a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <?php if(count($fotoTerima) > 4): ?>
                            <p class="text-xs text-gray-500 mt-1">+<?php echo e(count($fotoTerima) - 4); ?> foto lainnya</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->catatan_terima_kunci): ?>
                <div class="mt-3 p-3 bg-gray-50 rounded border border-gray-200">
                    <p class="text-sm font-medium text-gray-700 mb-1">Catatan:</p>
                    <p class="text-sm text-gray-600"><?php echo e($booking->catatan_terima_kunci); ?></p>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>


            </div>
            <?php elseif($booking->sudahSerahKunci() && !$booking->sudahTerimaKunci()): ?>
            
            <div class="relative pl-8">
                
                <div class="absolute left-0 top-0 w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center animate-pulse">
                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
                
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span>Menunggu Pengembalian</span>
                        <span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            Dalam Proses
                        </span>
                    </h3>
                    <p class="text-sm text-gray-600 mt-1">
                        Kendaraan sedang digunakan. Harap kembalikan sesuai jadwal.
                    </p>
                    
                    
                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded">
                        <div class="flex">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-yellow-800">Tanggal Pengembalian:</p>
                                <p class="text-sm text-yellow-700"><?php echo e($booking->end_date->format('d M Y, H:i')); ?> WIB</p>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->isOverdue()): ?>
                                    <p class="text-xs text-red-600 font-semibold mt-1">⚠️ Terlambat! Segera kembalikan kendaraan.</p>
                                <?php else: ?>
                                    <?php
                                        $hoursLeft = now()->diffInHours($booking->end_date, false);
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($hoursLeft <= 24 && $hoursLeft > 0): ?>
                                        <p class="text-xs text-yellow-700 mt-1">⏰ Kurang dari 24 jam lagi</p>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>

        
        <div class="mt-6 p-4 bg-accent-50 border border-accent-200 rounded-lg">
            <div class="flex">
                <svg class="w-5 h-5 text-accent-600 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                <div class="text-sm">
                    <p class="font-medium text-accent-900">Informasi Penting</p>
                    <p class="text-accent-700 mt-1">
                        Foto dan catatan kondisi kendaraan tercatat dalam sistem untuk referensi Anda. 
                        Pastikan untuk memeriksa kondisi kendaraan dengan teliti saat penyerahan dan pengembalian.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
<?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/customer/partials/kunci-status.blade.php ENDPATH**/ ?>