<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 leading-tight">
                {{ __('Pengeluaran Management') }}
            </h2>
            <a href="{{ route('admin.expenses.create') }}" 
               class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                <span class="hidden sm:inline">Tambah Pengeluaran Baru</span>
                <span class="sm:hidden">Tambah</span>
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.currency-dollar class="h-6 w-6 sm:h-8 sm:w-8 text-green-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Bulan Ini</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp {{ number_format($monthlySummary['total_amount'] / 1000, 0) }}K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.chart-bar class="h-6 w-6 sm:h-8 sm:w-8 text-blue-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Tahun Ini</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp {{ number_format($yearlySummary['total_amount'] / 1000, 0) }}K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.trending-up class="h-6 w-6 sm:h-8 sm:w-8 text-purple-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Rata-Rata</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900 truncate">
                                    Rp {{ number_format($yearlySummary['average_monthly'] / 1000, 0) }}K
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-3 sm:p-4 lg:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.receipt-tax class="h-6 w-6 sm:h-8 sm:w-8 text-red-500" />
                            </div>
                            <div class="ml-2 sm:ml-4 min-w-0">
                                <p class="text-xs sm:text-sm font-medium text-gray-500 truncate">Total Transaksi</p>
                                <p class="text-sm sm:text-lg lg:text-2xl font-semibold text-gray-900">
                                    {{ number_format($yearlySummary['total_count']) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense List Component -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-3 sm:p-4 lg:p-6">
                    @livewire('admin.expense-list')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>