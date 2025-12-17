<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen Pemesanan') }}
            </h2>
            <a href="{{ route('admin.bookings.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Pemesanan Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Tab Navigation -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                        <button onclick="showTab('list')" id="list-tab" 
                                class="tab-button active whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Daftar Pemesanan
                        </button>
                        <button onclick="showTab('search')" id="search-tab" 
                                class="tab-button whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm">
                            Pencarian Lanjutan
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content -->
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
                button.classList.remove('active', 'border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
            });
            
            // Tampilkan konten tab yang dipilih
            document.getElementById(tabName + '-content').classList.remove('hidden');
            
            // Tambahkan kelas aktif ke tab yang dipilih
            const activeTab = document.getElementById(tabName + '-tab');
            activeTab.classList.add('active', 'border-indigo-500', 'text-indigo-600');
            activeTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        }
        
        // Inisialisasi tab pertama sebagai aktif
        document.addEventListener('DOMContentLoaded', function() {
            const listTab = document.getElementById('list-tab');
            listTab.classList.add('border-indigo-500', 'text-indigo-600');
            listTab.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300');
        });
    </script>
    @endpush

    @push('styles')
    <style>
        .tab-button {
            @apply border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300;
        }
        .tab-button.active {
            @apply border-indigo-500 text-indigo-600;
        }
    </style>
    @endpush
</x-admin-layout>