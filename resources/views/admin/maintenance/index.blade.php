<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Pemeliharaan Management') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.maintenance.create') }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <x-icons.plus class="w-3 h-3 sm:w-4 sm:h-4 mr-1" />
                    <span class="hidden sm:inline">Tambah Pemeliharaan</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
                <button onclick="window.location.href='{{ route('admin.maintenance.export') }}'" 
                        class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-green-500 hover:bg-green-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <span class="hidden sm:inline">Export Data</span>
                    <span class="sm:hidden">Export</span>
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Statistics Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.currency-dollar class="h-6 w-6 sm:h-8 sm:w-8 text-green-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Biaya</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp {{ number_format($totalCost / 1000, 0) }}K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.calendar class="h-6 w-6 sm:h-8 sm:w-8 text-blue-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Bulan Ini</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp {{ number_format($thisMonthCost / 1000, 0) }}K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.wrench class="h-6 w-6 sm:h-8 sm:w-8 text-red-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Terlambat</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900">{{ $overdueMaintenance }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.clock class="h-6 w-6 sm:h-8 sm:w-8 text-yellow-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Hampir Jatuh Tempo</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900">{{ $dueSoonMaintenance }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="border-b border-gray-200 overflow-x-auto">
                    <nav class="-mb-px flex space-x-4 sm:space-x-8 px-3 sm:px-4" aria-label="Tabs">
                        <button onclick="showTab('maintenance-list')" 
                                class="tab-button active border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 sm:py-3 px-1 border-b-2 font-medium text-xs sm:text-sm">
                            <span class="hidden sm:inline">Riwayat Pemeliharaan</span>
                            <span class="sm:hidden">Riwayat</span>
                        </button>
                        <button onclick="showTab('maintenance-scheduler')" 
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 sm:py-3 px-1 border-b-2 font-medium text-xs sm:text-sm">
                            <span class="hidden sm:inline">Jadwal & Pengingat</span>
                            <span class="sm:hidden">Jadwal</span>
                        </button>
                        <button onclick="showTab('maintenance-analytics')" 
                                class="tab-button border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap py-2 sm:py-3 px-1 border-b-2 font-medium text-xs sm:text-sm">
                            <span class="hidden sm:inline">Analisis & Laporan</span>
                            <span class="sm:hidden">Analisis</span>
                        </button>
                    </nav>
                </div>

                <!-- Tab Contents -->
                <div id="maintenance-list" class="tab-content">
                    <livewire:admin.maintenance-list />
                </div>

                <div id="maintenance-scheduler" class="tab-content hidden">
                    <livewire:admin.maintenance-scheduler />
                </div>

                <div id="maintenance-analytics" class="tab-content hidden">
                    <livewire:admin.maintenance-analytics />
                </div>
            </div>
        </div>
    </div>

    <script>
        function showTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active class from all tab buttons
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('active', 'border-accent-500', 'text-accent-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById(tabName).classList.remove('hidden');
            
            // Add active class to clicked button
            event.target.classList.remove('border-transparent', 'text-gray-500');
            event.target.classList.add('active', 'border-accent-500', 'text-accent-600');
        }
    </script>

    <style>
        .tab-button.active {
            border-color: #f97316;
            color: #ea580c;
        }
    </style>
</x-admin-layout>