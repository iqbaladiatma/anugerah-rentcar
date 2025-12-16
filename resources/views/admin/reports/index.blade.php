<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports Dashboard') }}
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
                                <h3 class="text-lg font-medium text-gray-900">Customer Reports</h3>
                                <p class="text-sm text-gray-500">Booking history and customer statistics</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.customer') }}" 
                               class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
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
                                <h3 class="text-lg font-medium text-gray-900">Financial Reports</h3>
                                <p class="text-sm text-gray-500">Profit/loss and revenue analysis</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.financial') }}" 
                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
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
                                <h3 class="text-lg font-medium text-gray-900">Vehicle Reports</h3>
                                <p class="text-sm text-gray-500">Utilization and revenue per vehicle</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.vehicle') }}" 
                               class="inline-flex items-center px-4 py-2 bg-purple-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-purple-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
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
                                <h3 class="text-lg font-medium text-gray-900">Analytics Dashboard</h3>
                                <p class="text-sm text-gray-500">Comprehensive business analytics and trends</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.analytics') }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Analytics
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
                                <h3 class="text-lg font-medium text-gray-900">Profitability Analysis</h3>
                                <p class="text-sm text-gray-500">Vehicle ROI and profit margin analysis</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.profitability') }}" 
                               class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Analyze Profitability
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
                                <h3 class="text-lg font-medium text-gray-900">Customer Lifetime Value</h3>
                                <p class="text-sm text-gray-500">Customer value and loyalty analysis</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.reports.customer-ltv') }}" 
                               class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 focus:bg-pink-700 active:bg-pink-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                View Customer LTV
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Statistics (Last 30 Days)</h3>
                    <livewire:admin.dashboard-stats />
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>