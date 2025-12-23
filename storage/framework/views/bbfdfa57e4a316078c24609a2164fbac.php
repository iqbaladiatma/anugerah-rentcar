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

<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Konfirmasi Pembayaran</h1>
        <p class="text-sm text-gray-500 mt-1">Nomor Booking: <span class="font-semibold text-gray-900"><?php echo e($booking->booking_number); ?></span></p>
    </div>

    <!-- Payment Info -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-6">
        <h2 class="font-semibold text-blue-900 mb-4">Informasi Pembayaran</h2>
        <div class="space-y-2 text-sm text-blue-800">
            <p><span class="font-medium">Total Pembayaran:</span> <span class="text-lg font-bold">Rp <?php echo e(number_format($booking->total_amount, 0, ',', '.')); ?></span></p>
            <p><span class="font-medium">Deposit:</span> <span class="font-semibold">Rp <?php echo e(number_format($booking->deposit_amount, 0, ',', '.')); ?></span></p>
            <p><span class="font-medium">Metode Pembayaran:</span> <?php echo e($booking->payment_method === 'bank_transfer' ? 'Transfer Bank' : 'Cash'); ?></p>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->payment_method === 'bank_transfer'): ?>
            <div class="mt-4 pt-4 border-t border-blue-300">
                <p class="font-medium text-blue-900 mb-2">Transfer ke Rekening:</p>
                <div class="bg-white rounded-lg p-4 space-y-1">
                    <p class="font-bold text-gray-900">Bank BCA</p>
                    <p class="text-gray-700">No. Rekening: <span class="font-mono font-bold">1234567890</span></p>
                    <p class="text-gray-700">Atas Nama: <span class="font-semibold">PT Anugerah Rentcar</span></p>
                </div>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- Payment Type Selection -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <h3 class="font-semibold text-gray-900 mb-4">Pilih Jenis Pembayaran</h3>
        
        <?php
            $isPartial = $booking->payment_status === 'partial';
            $remainingAmount = $booking->total_amount - $booking->deposit_amount;
        ?>

        <div class="space-y-3" x-data="{ paymentType: '<?php echo e($isPartial ? 'full' : 'deposit'); ?>' }">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!$isPartial): ?>
            <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors"
                   :class="paymentType === 'deposit' ? 'border-blue-500 bg-blue-50' : 'border-gray-300'"
                   @click="paymentType = 'deposit'">
                <input type="radio" name="payment_type" value="deposit" checked class="mt-1 w-4 h-4 text-blue-600" form="payment-form">
                <div class="ml-3 flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="font-semibold text-gray-900">Bayar Deposit</p>
                            <p class="text-sm text-gray-600 mt-1">Bayar deposit dulu, sisanya setelah mobil dikembalikan</p>
                        </div>
                        <p class="text-xl font-bold text-blue-600">Rp <?php echo e(number_format($booking->deposit_amount, 0, ',', '.')); ?></p>
                    </div>
                </div>
            </label>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            
            <label class="flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors"
                   :class="paymentType === 'full' ? 'border-green-500 bg-green-50' : 'border-gray-300'"
                   @click="paymentType = 'full'">
                <input type="radio" name="payment_type" value="full" class="mt-1 w-4 h-4 text-blue-600" form="payment-form">
                <div class="ml-3 flex-1">
                    <div class="flex justify-between items-start">
                        <div>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPartial): ?>
                                <p class="font-semibold text-gray-900">Pelunasan Sisa Pembayaran</p>
                                <p class="text-sm text-gray-600 mt-1">Lunasi sisa pembayaran untuk menyelesaikan transaksi</p>
                            <?php else: ?>
                                <p class="font-semibold text-gray-900">Bayar Lunas</p>
                                <p class="text-sm text-gray-600 mt-1">Bayar langsung lunas, tidak perlu bayar lagi</p>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <p class="text-xl font-bold text-green-600">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($isPartial): ?>
                                Rp <?php echo e(number_format($remainingAmount, 0, ',', '.')); ?>

                            <?php else: ?>
                                Rp <?php echo e(number_format($booking->total_amount, 0, ',', '.')); ?>

                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </p>
                    </div>
                </div>
            </label>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h2 class="text-lg font-semibold text-white">Upload Bukti Transfer</h2>
        </div>
        
        <form id="payment-form" action="<?php echo e(route('customer.bookings.payment.submit', $booking)); ?>" method="POST" enctype="multipart/form-data" class="p-6">
            <?php echo csrf_field(); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
                <div class="mb-4 bg-green-50 border border-green-200 rounded-lg p-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <span class="text-green-800 font-medium"><?php echo e(session('success')); ?></span>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-red-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-red-800 font-medium mb-1">Terjadi kesalahan:</p>
                            <ul class="list-disc list-inside text-sm text-red-700">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <!-- File Upload -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Bukti Transfer <span class="text-red-500">*</span>
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-500 transition-colors">
                    <input type="file" name="payment_proof" id="payment_proof" accept="image/*" required
                           class="hidden" onchange="previewImage(event)">
                    <label for="payment_proof" class="cursor-pointer">
                        <div id="preview-container" class="hidden mb-4">
                            <img id="preview-image" class="max-w-full h-48 mx-auto rounded-lg">
                        </div>
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <div class="mt-4">
                            <span class="text-blue-600 hover:text-blue-500 font-medium">Klik untuk upload</span>
                            <span class="text-gray-600"> atau drag and drop</span>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">PNG, JPG, JPEG hingga 5MB</p>
                    </label>
                </div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Catatan (Opsional)
                </label>
                <textarea name="notes" id="notes" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                          placeholder="Tambahkan catatan jika diperlukan..."></textarea>
            </div>

            <!-- Info -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <div class="text-sm text-yellow-800">
                        <p class="font-medium mb-1">Penting:</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Pastikan bukti transfer jelas dan mudah dibaca</li>
                            <li>Nominal transfer harus sesuai dengan jenis pembayaran yang dipilih</li>
                            <li>Pembayaran akan diverifikasi dalam 1x24 jam</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-3">
                <button type="submit"
                        class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                    Upload Bukti Pembayaran
                </button>
                <a href="<?php echo e(route('customer.bookings.show', $booking)); ?>"
                   class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-image').src = e.target.result;
            document.getElementById('preview-container').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $attributes = $__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__attributesOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06)): ?>
<?php $component = $__componentOriginal42b37f006f8ebbe12b66cfa27a5def06; ?>
<?php unset($__componentOriginal42b37f006f8ebbe12b66cfa27a5def06); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/customer/payment-confirmation.blade.php ENDPATH**/ ?>