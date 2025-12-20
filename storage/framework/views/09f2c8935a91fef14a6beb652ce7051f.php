<?php
    $settings = \App\Models\Setting::current();
?>

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
     <?php $__env->slot('title', null, []); ?> Pusat Bantuan - <?php echo e($settings->company_name ?? 'Anugerah Rentcar'); ?> <?php $__env->endSlot(); ?>

    <!-- Hero Section -->
    <section class="bg-gradient-to-r from-accent-600 to-accent-700 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                Pusat Bantuan
            </h1>
            <p class="text-xl text-accent-100 max-w-2xl mx-auto">
                Kami siap membantu menjawab pertanyaan dan menyelesaikan kendala Anda
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Contact Channels -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
            <!-- Phone/WA -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Telepon & WhatsApp</h3>
                <p class="text-gray-600 mb-6">Hubungi kami langsung untuk respon cepat</p>
                <div class="space-y-3">
                    <a href="tel:<?php echo e($settings->company_phone ?? '+62 897-7777-451'); ?>" class="block text-accent-600 font-semibold hover:underline">
                        <?php echo e($settings->company_phone ?? '+62 897-7777-451'); ?>

                    </a>
                    <a href="https://wa.me/<?php echo e(preg_replace('/[^0-9]/', '', $settings->whatsapp ?? '62897777451')); ?>" target="_blank" class="inline-flex items-center text-green-600 font-semibold hover:underline">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Chat WhatsApp
                    </a>
                </div>
            </div>

            <!-- Email -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Email</h3>
                <p class="text-gray-600 mb-6">Kirim pertanyaan Anda melalui email</p>
                <a href="mailto:<?php echo e($settings->company_email ?? 'info@anugerahrentcar.com'); ?>" class="text-accent-600 font-semibold hover:underline">
                    <?php echo e($settings->company_email ?? 'info@anugerahrentcar.com'); ?>

                </a>
            </div>

            <!-- Location -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center hover:shadow-xl transition-shadow">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Kunjungi Kami</h3>
                <p class="text-gray-600 mb-6">Datang langsung ke kantor kami</p>
                <p class="text-gray-800 font-medium">
                    <?php echo e($settings->company_address ?? 'Blora, Jawa Tengah'); ?>

                </p>
            </div>
        </div>

        <!-- FAQ Section -->
        <div class="max-w-3xl mx-auto">
            <h2 class="text-3xl font-bold text-gray-900 text-center mb-8">Pertanyaan Umum</h2>
            
            <div class="space-y-4" x-data="{ openFaq: null }">
                <!-- FAQ 1 -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 1 ? null : 1" 
                            class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-gray-50">
                        <span>Bagaimana cara melakukan pemesanan?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 1 }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 1" x-collapse class="px-4 pb-4 text-gray-600 border-t border-gray-100">
                        Anda dapat melakukan pemesanan melalui website kami dengan memilih kendaraan di halaman katalog, atau menghubungi customer service kami melalui WhatsApp.
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 2 ? null : 2" 
                            class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-gray-50">
                        <span>Apa saja syarat penyewaan lepas kunci?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 2 }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 2" x-collapse class="px-4 pb-4 text-gray-600 border-t border-gray-100">
                        Syarat utama adalah KTP, SIM A, dan Kartu Keluarga asli. Kami juga akan melakukan verifikasi data sebelum menyetujui penyewaan lepas kunci.
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
                    <button @click="openFaq = openFaq === 3 ? null : 3" 
                            class="w-full flex justify-between items-center p-4 text-left font-medium text-gray-900 hover:bg-gray-50">
                        <span>Apakah harga sudah termasuk BBM dan sopir?</span>
                        <svg class="w-5 h-5 transition-transform" :class="{ 'rotate-180': openFaq === 3 }" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div x-show="openFaq === 3" x-collapse class="px-4 pb-4 text-gray-600 border-t border-gray-100">
                        Harga dasar yang tertera adalah untuk sewa unit kendaraan saja (lepas kunci). Layanan sopir dan BBM merupakan biaya tambahan kecuali disebutkan lain dalam paket promo.
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-8">
                <a href="<?php echo e(route('terms')); ?>#faq" class="text-accent-600 font-medium hover:text-accent-700 hover:underline">
                    Lihat FAQ Selengkapnya &rarr;
                </a>
            </div>
        </div>

        <!-- Ticket Support CTA for Logged In Users -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(auth()->guard('customer')->check()): ?>
        <div class="mt-16 bg-primary-50 rounded-xl p-8 text-center border border-primary-100">
            <h3 class="text-2xl font-bold text-gray-900 mb-4">Butuh Bantuan Teknis?</h3>
            <p class="text-gray-600 mb-6 max-w-2xl mx-auto">
                Buat tiket dukungan melalui dashboard pelanggan Anda untuk mendapatkan bantuan terkait akun atau transaksi spesifik.
            </p>
            <a href="<?php echo e(route('customer.support')); ?>" class="inline-block bg-primary-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-700 transition-colors">
                Buat Tiket Dukungan
            </a>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
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
<?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/pages/support.blade.php ENDPATH**/ ?>