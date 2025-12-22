<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuangan') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.financial') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" 
                                       value="{{ request('start_date', now()->subYear()->format('Y-m-d')) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" 
                                       value="{{ request('end_date', now()->format('Y-m-d')) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-accent-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-accent-700 transition ease-in-out duration-150">
                                    Lihat Laporan
                                </button>
                            </div>
                            <div class="flex items-end gap-2">
                                <a href="{{ route('admin.reports.financial', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">Excel</span>
                                </a>
                                <a href="{{ route('admin.reports.financial', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">PDF</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($reportData))
            <!-- Profit/Loss Summary -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 hidden sm:block">
                                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    </svg>
                                </div>
                            </div>
                            <div class="sm:ml-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Total Pendapatan</div>
                                <div class="text-lg sm:text-2xl font-bold text-gray-900">Rp {{ number_format($reportData['revenue']['total_net_revenue'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 hidden sm:block">
                                <div class="h-10 w-10 rounded-full bg-red-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="sm:ml-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Total Pengeluaran</div>
                                <div class="text-lg sm:text-2xl font-bold text-gray-900">Rp {{ number_format($reportData['expenses']['total'], 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 hidden sm:block">
                                <div class="h-10 w-10 rounded-full {{ $reportData['profit_loss']['gross_profit'] >= 0 ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center">
                                    <svg class="h-5 w-5 {{ $reportData['profit_loss']['gross_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                            </div>
                            <div class="sm:ml-4">
                                <div class="text-xs sm:text-sm font-medium text-gray-500">Keuntungan Bersih</div>
                                <div class="text-lg sm:text-2xl font-bold {{ $reportData['profit_loss']['gross_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($reportData['profit_loss']['gross_profit'], 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500">{{ number_format($reportData['profit_loss']['profit_margin'], 1) }}% margin</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">Pendapatan</h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-blue-600">Rp {{ number_format($reportData['revenue']['rental_income'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Pendapatan Sewa</div>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-purple-600">Rp {{ number_format($reportData['revenue']['driver_fees'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Biaya Driver</div>
                        </div>
                        <div class="text-center p-3 bg-indigo-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-indigo-600">Rp {{ number_format($reportData['revenue']['out_of_town_fees'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Biaya Luar Kota</div>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-yellow-600">Rp {{ number_format($reportData['revenue']['late_penalties'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Denda</div>
                        </div>
                    </div>
                    @if($reportData['revenue']['member_discounts'] > 0)
                    <div class="mt-4 text-center p-3 bg-red-50 rounded-lg">
                        <div class="text-sm sm:text-lg font-bold text-red-600">-Rp {{ number_format($reportData['revenue']['member_discounts'], 0, ',', '.') }}</div>
                        <div class="text-xs sm:text-sm text-gray-500">Diskon Member</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Expense Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">Pengeluaran</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-red-600">Rp {{ number_format($reportData['expenses']['operational'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Operasional</div>
                        </div>
                        <div class="text-center p-3 bg-orange-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-orange-600">Rp {{ number_format($reportData['expenses']['maintenance'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Pemeliharaan</div>
                        </div>
                        <div class="text-center p-3 bg-gray-100 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-gray-600">Rp {{ number_format($reportData['expenses']['total'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Total</div>
                        </div>
                    </div>

                    @if($reportData['expenses']['by_category']->count() > 0)
                    <div class="mt-4 sm:mt-6">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Pengeluaran Operasional</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-2 sm:gap-3">
                            @foreach($reportData['expenses']['by_category'] as $category => $data)
                            <div class="text-center p-2 border rounded-lg">
                                <div class="text-xs sm:text-lg font-bold text-gray-700">Rp {{ number_format($data['amount'], 0, ',', '.') }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ ucfirst($category) }}</div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Monthly Breakdown -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">Performa Bulanan</h3>
                    
                    <!-- Mobile Card View -->
                    <div class="block lg:hidden space-y-3">
                        @foreach($reportData['monthly_breakdown'] as $monthData)
                        <div class="border rounded-lg p-4">
                            <div class="font-medium text-gray-900 mb-2">{{ $monthData['month_name'] }}</div>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                <div>
                                    <span class="text-gray-500">Pendapatan:</span>
                                    <span class="font-medium">Rp {{ number_format($monthData['revenue'], 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Pengeluaran:</span>
                                    <span class="font-medium">Rp {{ number_format($monthData['expenses'], 0, ',', '.') }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Profit:</span>
                                    <span class="font-medium {{ $monthData['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($monthData['profit'], 0, ',', '.') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-500">Booking:</span>
                                    <span class="font-medium">{{ number_format($monthData['bookings_count']) }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bulan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengeluaran</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Profit</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Booking</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($reportData['monthly_breakdown'] as $monthData)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $monthData['month_name'] }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($monthData['revenue'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($monthData['expenses'], 0, ',', '.') }}</td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm {{ $monthData['profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($monthData['profit'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ number_format($monthData['bookings_count']) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Summary Statistics -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">
                        Periode 
                        <span class="block sm:inline text-xs sm:text-sm text-gray-500 font-normal">
                            ({{ $reportData['period']['start_date'] }} - {{ $reportData['period']['end_date'] }})
                        </span>
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="text-lg sm:text-xl font-bold text-blue-600">{{ number_format($reportData['summary']['total_bookings']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Total Booking</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-green-600">Rp {{ number_format($reportData['summary']['average_booking_value'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Avg. Booking</div>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <div class="text-lg sm:text-xl font-bold text-purple-600">{{ number_format($reportData['summary']['total_customers']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Customer</div>
                        </div>
                        <div class="text-center p-3 bg-indigo-50 rounded-lg">
                            <div class="text-lg sm:text-xl font-bold text-indigo-600">{{ number_format($reportData['summary']['period_days']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Hari</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>