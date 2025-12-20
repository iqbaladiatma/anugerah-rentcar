<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pengeluaran Management') }}
            </h2>
            <a href="{{ route('admin.expenses.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Tambah Pengeluaran Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.currency-dollar class="h-8 w-8 text-green-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Bulan Ini</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    Rp {{ number_format($monthlySummary['total_amount'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.chart-bar class="h-8 w-8 text-blue-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Tahun Ini</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    Rp {{ number_format($yearlySummary['total_amount'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.trending-up class="h-8 w-8 text-purple-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Rata-Rata Bulanan</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    Rp {{ number_format($yearlySummary['average_monthly'], 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.receipt-tax class="h-8 w-8 text-red-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Transaksi</p>
                                <p class="text-2xl font-semibold text-gray-900">
                                    {{ number_format($yearlySummary['total_count']) }} items
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense List Component -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @livewire('admin.expense-list')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>