<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Financial Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Report Filters</h3>
                    <form method="GET" action="{{ route('admin.reports.financial') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                            <input type="date" name="start_date" id="start_date" 
                                   value="{{ request('start_date', now()->subYear()->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                            <input type="date" name="end_date" id="end_date" 
                                   value="{{ request('end_date', now()->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Report
                            </button>
                        </div>
                        <div class="flex items-end space-x-2">
                            <a href="{{ route('admin.reports.financial', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Excel
                            </a>
                            <a href="{{ route('admin.reports.financial', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($reportData))
            <!-- Profit/Loss Summary -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.trending-up class="h-8 w-8 text-green-500" />
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Revenue</div>
                                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($reportData['revenue']['total_net_revenue'], 0, ',', '.') }}</div>
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
                                <div class="text-sm font-medium text-gray-500">Total Expenses</div>
                                <div class="text-2xl font-bold text-gray-900">Rp {{ number_format($reportData['expenses']['total'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.currency-dollar class="h-8 w-8 {{ $reportData['profit_loss']['gross_profit'] >= 0 ? 'text-green-500' : 'text-red-500' }}" />
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Net Profit</div>
                                <div class="text-2xl font-bold {{ $reportData['profit_loss']['gross_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($reportData['profit_loss']['gross_profit'], 0, ',', '.') }}
                                </div>
                                <div class="text-sm text-gray-500">{{ number_format($reportData['profit_loss']['profit_margin'], 1) }}% margin</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Revenue Breakdown</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-blue-600">Rp {{ number_format($reportData['revenue']['rental_income'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Rental Income</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-purple-600">Rp {{ number_format($reportData['revenue']['driver_fees'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Driver Fees</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-indigo-600">Rp {{ number_format($reportData['revenue']['out_of_town_fees'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Out-of-Town Fees</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-yellow-600">Rp {{ number_format($reportData['revenue']['late_penalties'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Late Penalties</div>
                        </div>
                    </div>
                    @if($reportData['revenue']['member_discounts'] > 0)
                    <div class="mt-4 text-center">
                        <div class="text-lg font-bold text-red-600">-Rp {{ number_format($reportData['revenue']['member_discounts'], 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-500">Member Discounts Given</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Expense Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Expense Breakdown</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-red-600">Rp {{ number_format($reportData['expenses']['operational'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Operational Expenses</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-orange-600">Rp {{ number_format($reportData['expenses']['maintenance'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Maintenance Costs</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-gray-600">Rp {{ number_format($reportData['expenses']['total'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Total Expenses</div>
                        </div>
                    </div>

                    @if($reportData['expenses']['by_category']->count() > 0)
                    <div class="mt-6">
                        <h4 class="text-md font-medium text-gray-900 mb-3">Operational Expenses by Category</h4>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                            @foreach($reportData['expenses']['by_category'] as $category => $data)
                            <div class="text-center">
                                <div class="text-lg font-bold text-gray-700">Rp {{ number_format($data['amount'], 0, ',', '.') }}</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($category) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Monthly Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Performance</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Expenses</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bookings</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportData['monthly_breakdown'] as $monthData)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $monthData['month_name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($monthData['revenue'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($monthData['expenses'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ $monthData['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($monthData['profit'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($monthData['bookings_count']) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Period Summary ({{ $reportData['period']['start_date'] }} to {{ $reportData['period']['end_date'] }})
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-xl font-bold text-blue-600">{{ number_format($reportData['summary']['total_bookings']) }}</div>
                            <div class="text-sm text-gray-500">Total Bookings</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-green-600">Rp {{ number_format($reportData['summary']['average_booking_value'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Avg. Booking Value</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-purple-600">{{ number_format($reportData['summary']['total_customers']) }}</div>
                            <div class="text-sm text-gray-500">Unique Customers</div>
                        </div>
                        <div class="text-center">
                            <div class="text-xl font-bold text-indigo-600">{{ number_format($reportData['summary']['period_days']) }}</div>
                            <div class="text-sm text-gray-500">Days in Period</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>