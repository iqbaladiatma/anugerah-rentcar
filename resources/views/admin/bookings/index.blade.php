<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-base sm:text-lg lg:text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Pemesanan') }}
            </h2>
        </div>
    </x-slot>

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
                <livewire:admin.booking-list />
            </div>

            <div id="search-content" class="tab-content hidden">
                <livewire:admin.booking-search />
            </div>
        </div>
    </div>

    @push('scripts')
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
    @endpush

    @push('styles')
    <style>
        .tab-button {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 transition-colors;
        }
        .tab-button.active {
            @apply border-accent-500 text-accent-600;
        }
    </style>
    @endpush
</x-admin-layout>