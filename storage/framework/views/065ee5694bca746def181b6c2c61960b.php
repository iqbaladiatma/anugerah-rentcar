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
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-base sm:text-lg lg:text-xl text-gray-800 leading-tight">
                <?php echo e(__('Manajemen Pemesanan')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-4 sm:py-6">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="mb-4 sm:mb-6">
                <div class="bg-white border-b border-gray-200 overflow-x-auto rounded-t-lg shadow-sm">
                    <nav class="-mb-px flex space-x-4 sm:space-x-8 px-3 sm:px-4" aria-label="Tabs">
                        <button onclick="showTab('list')" id="list-tab" 
                                class="tab-button active whitespace-nowrap py-2 sm:py-3 px-1 border-b-2 font-medium text-xs sm:text-sm">
                            <span class="hidden sm:inline">Daftar Pemesanan</span>
                            <span class="sm:hidden">Daftar</span>
                        </button>
                        <button onclick="showTab('search')" id="search-tab" 
                                class="tab-button whitespace-nowrap py-2 sm:py-3 px-1 border-b-2 font-medium text-xs sm:text-sm">
                            <span class="hidden sm:inline">Pencarian Lanjutan</span>
                            <span class="sm:hidden">Cari</span>
                        </button>
                    </nav>
                </div>
            </div>

            <div id="list-content" class="tab-content">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.booking-list', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-4184812111-0', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>

            <div id="search-content" class="tab-content hidden">
                <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('admin.booking-search', []);

$key = null;

$key ??= \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::generateKey('lw-4184812111-1', null);

$__html = app('livewire')->mount($__name, $__params, $key);

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        function showTab(tabName) {
            // Sembunyikan semua konten tab
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Hapus kelas aktif dari semua tab
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-accent-500', 'text-accent-600');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });
            
            // Tampilkan konten tab yang dipilih
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Tambahkan kelas aktif ke tab yang dipilih
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('active', 'border-accent-500', 'text-accent-600');
            activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        }
        
        // Inisialisasi tab pertama sebagai aktif
        document.addEventListener('DOMContentLoaded', function() {
            const listTab = document.getElementById('list-tab');
            listTab.classList.add('border-accent-500', 'text-accent-600');
            listTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
    </script>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('styles'); ?>
    <style>
        .tab-button {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors;
        }
        .tab-button.active {
            @apply border-accent-500 text-accent-600;
        }
    </style>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/bookings/index.blade.php ENDPATH**/ ?>