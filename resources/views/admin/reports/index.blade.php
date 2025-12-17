<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Report Categories -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Customer Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.users class="h-8 w-8 text-blue-500" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Laporan Pelanggan</h3>
                                <p class="text-sm text-gray-500">Riwayat pemesanan dan statistik pelanggan</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.customer') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hasilkan Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Financial Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.currency-dollar class="h-8 w-8 text-green-500" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Laporan Keuangan</h3>
                                <p class="text-sm text-gray-500">Profit/Loss dan analisis pendapatan</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.financial') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hasilkan Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Vehicle Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.car class="h-8 w-8 text-purple-500" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Laporan Kendaraan</h3>
                                <p class="text-sm text-gray-500">Utilisasi dan pendapatan per kendaraan</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.vehicle') }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hasilkan Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advanced Reports -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Analytics Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.chart-bar class="h-8 w-8 text-indigo-500" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Laporan Analitik</h3>
                                <p class="text-sm text-gray-500">Analisis bisnis dan tren</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.analytics') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hasilkan Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Profitability Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.trending-up class="h-8 w-8 text-emerald-500" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Analisis Keuntungan</h3>
                                <p class="text-sm text-gray-500">ROI kendaraan dan margin keuntungan</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.profitability') }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hasilkan Laporan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Customer LTV Reports -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.user-group class="h-8 w-8 text-pink-500" />
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-medium text-gray-900">Pelanggan Lifetime Value</h3>
                                <p class="text-sm text-gray-500">Nilai pelanggan dan analisis loyalitas</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.customer-ltv') }}" 
                               class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hasilkan Laporan
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Statistik Cepat (30 Hari Terakhir)</h3>
                    <livewire:admin.dashboard-stats />
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>