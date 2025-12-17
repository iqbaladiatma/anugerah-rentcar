<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Keuntungan Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.profitability') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" 
                                   value="{{ request('start_date', now()->subYear()->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" 
                                   value="{{ request('end_date', now()->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Hasilkan Laporan
                            </button>
                        </div>
                        <div class="flex items-end space-x-2">
                            <a href="{{ route('admin.reports.profitability', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Excel
                            </a>
                            <a href="{{ route('admin.reports.profitability', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($reportData))
            <!-- Summary Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Kendaraan</div>
                                <div class="text-2xl font-bold text-gray-900">{{ number_format($reportData['summary']['total_vehicles']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Kendaraan Profitable</div>
                                <div class="text-2xl font-bold text-green-600">{{ number_format($reportData['summary']['profitable_vehicles']) }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Total Keuntungan Bersih</div>
                                <div class="text-2xl font-bold {{ $reportData['summary']['total_net_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($reportData['summary']['total_net_profit'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-8 w-8 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-500">Margin Keuntungan Rata-rata</div>
                                <div class="text-2xl font-bold text-indigo-600">{{ number_format($reportData['summary']['average_profit_margin'], 1) }}%</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Best and Worst Performers -->
            @if(isset($reportData['summary']['best_performer']) && isset($reportData['summary']['worst_performer']))
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Best Performer -->
                <div class="bg-gradient-to-r from-green-50 to-green-100 overflow-hidden shadow-sm sm:rounded-lg border-2 border-green-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <svg class="h-6 w-6 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-green-900">Pemilik Kendaraan Terbaik</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="text-xl font-bold text-gray-900">{{ $reportData['summary']['best_performer']['vehicle']->brand }} {{ $reportData['summary']['best_performer']['vehicle']->model }}</div>
                            <div class="text-sm text-gray-600">{{ $reportData['summary']['best_performer']['vehicle']->license_plate }}</div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <div class="text-xs text-gray-500">Revenue</div>
                                    <div class="text-lg font-bold text-green-600">Rp {{ number_format($reportData['summary']['best_performer']['revenue'] ?? 0, 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Net Profit</div>
                                    <div class="text-lg font-bold text-green-600">Rp {{ number_format($reportData['summary']['best_performer']['net_profit'] ?? 0, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Worst Performer -->
                <div class="bg-gradient-to-r from-red-50 to-red-100 overflow-hidden shadow-sm sm:rounded-lg border-2 border-red-200">
                    <div class="p-6">
                        <div class="flex items-center mb-4">
                            <svg class="h-6 w-6 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                            <h3 class="text-lg font-bold text-red-900">Perlu Perhatian</h3>
                        </div>
                        <div class="space-y-2">
                            <div class="text-xl font-bold text-gray-900">{{ $reportData['summary']['worst_performer']['vehicle']->brand }} {{ $reportData['summary']['worst_performer']['vehicle']->model }}</div>
                            <div class="text-sm text-gray-600">{{ $reportData['summary']['worst_performer']['vehicle']->license_plate }}</div>
                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <div class="text-xs text-gray-500">Revenue</div>
                                    <div class="text-lg font-bold text-gray-600">Rp {{ number_format($reportData['summary']['worst_performer']['revenue'] ?? 0, 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Net Profit</div>
                                    <div class="text-lg font-bold {{ ($reportData['summary']['worst_performer']['net_profit'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($reportData['summary']['worst_performer']['net_profit'] ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Vehicle Profitability Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Analisis Keuntungan Kendaraan ({{ $reportData['period']['start_date'] }} to {{ $reportData['period']['end_date'] }})
                    </h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Pendapatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Biaya Pemeliharaan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keuntungan Bersih</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Margin Keuntungan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pesan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reportData['vehicles'] as $data)
                                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $data['vehicle']->brand }} {{ $data['vehicle']->model }}</div>
                                        <div class="text-sm text-gray-500">{{ $data['vehicle']->license_plate }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($data['revenue'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600">
                                        Rp {{ number_format($data['maintenance_costs'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold {{ ($data['net_profit'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($data['net_profit'] ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm {{ ($data['profit_margin'] ?? 0) >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($data['profit_margin'] ?? 0, 1) }}%
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ number_format($data['vehicle']->bookings->count() ?? 0) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if(($data['net_profit'] ?? 0) > 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Profitable
                                            </span>
                                        @elseif(($data['net_profit'] ?? 0) == 0)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Break Even
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Loss
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No data available for the selected period.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>
