<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan Analitik Bisnis') }}</h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.analytics') }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ request('start_date', $reportData['period']['start_date']) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" value="{{ request('end_date', $reportData['period']['end_date']) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-accent-600 rounded-md text-xs text-white uppercase font-semibold hover:bg-accent-700">
                                    Hasilkan Laporan
                                </button>
                            </div>
                            <div class="flex items-end gap-2">
                                <a href="{{ route('admin.reports.analytics', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                                   class="flex-1 px-3 py-2 bg-green-600 rounded-md text-xs text-white text-center uppercase font-semibold hover:bg-green-700">Excel</a>
                                <a href="{{ route('admin.reports.analytics', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                                   class="flex-1 px-3 py-2 bg-red-600 rounded-md text-xs text-white text-center uppercase font-semibold hover:bg-red-700">PDF</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Key Metrics -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6">
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-500">Total Pendapatan</div>
                    <div class="text-sm sm:text-lg font-bold">Rp {{ number_format($reportData['analytics']['revenue_analytics']['total_revenue'] ?? 0, 0, ',', '.') }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-500">Total Pemesanan</div>
                    <div class="text-lg font-bold">{{ number_format($reportData['analytics']['revenue_analytics']['total_bookings'] ?? 0) }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-500">Bulan Terbaik</div>
                    <div class="text-sm sm:text-lg font-bold">{{ $reportData['seasonal_trends']['peak_month']['month_name'] ?? '-' }}</div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="text-xs sm:text-sm text-gray-500">Kuartal Terbaik</div>
                    <div class="text-sm sm:text-lg font-bold">{{ $reportData['seasonal_trends']['peak_quarter']['quarter'] ?? '-' }}</div>
                </div>
            </div>

            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4 sm:mb-6">
                <div class="bg-white p-4 rounded-lg shadow" x-data="monthlyRevenueChart(@js($reportData['seasonal_trends']['monthly_trends']))">
                    <h3 class="text-sm sm:text-lg font-medium mb-4">Tren Pendapatan Bulanan</h3>
                    <div class="h-48 sm:h-64"><canvas x-ref="canvas"></canvas></div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow" x-data="monthlyBookingsChart(@js($reportData['seasonal_trends']['monthly_trends']))">
                    <h3 class="text-sm sm:text-lg font-medium mb-4">Tren Pemesanan Bulanan</h3>
                    <div class="h-48 sm:h-64"><canvas x-ref="canvas"></canvas></div>
                </div>
            </div>

            <!-- Top Vehicles -->
            <div class="bg-white shadow-sm rounded-lg mb-4 sm:mb-6 p-4 sm:p-6">
                <h3 class="text-sm sm:text-lg font-medium mb-4">10 Kendaraan Paling Menguntungkan</h3>
                <div class="block lg:hidden space-y-3">
                    @forelse($reportData['profitability'] as $v)
                    <div class="border rounded-lg p-3">
                        <div class="font-medium">{{ $v['vehicle']->brand }} {{ $v['vehicle']->model }}</div>
                        <div class="text-xs text-gray-500 mb-2">{{ $v['vehicle']->license_plate }}</div>
                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <div><span class="text-gray-500 text-xs">Revenue</span><br>Rp {{ number_format($v['revenue'], 0, ',', '.') }}</div>
                            <div><span class="text-gray-500 text-xs">Net</span><br><span class="text-green-600">Rp {{ number_format($v['net_profit'], 0, ',', '.') }}</span></div>
                            <div><span class="text-gray-500 text-xs">Margin</span><br>{{ number_format($v['profit_margin'], 1) }}%</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">Tidak ada data</div>
                    @endforelse
                </div>
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50"><tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kendaraan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Revenue</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Net Profit</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Margin</th>
                        </tr></thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($reportData['profitability'] as $v)
                            <tr>
                                <td class="px-4 py-4"><div class="font-medium">{{ $v['vehicle']->brand }} {{ $v['vehicle']->model }}</div><div class="text-sm text-gray-500">{{ $v['vehicle']->license_plate }}</div></td>
                                <td class="px-4 py-4">Rp {{ number_format($v['revenue'], 0, ',', '.') }}</td>
                                <td class="px-4 py-4 text-green-600 font-medium">Rp {{ number_format($v['net_profit'], 0, ',', '.') }}</td>
                                <td class="px-4 py-4">{{ number_format($v['profit_margin'], 1) }}%</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Top Customers -->
            <div class="bg-white shadow-sm rounded-lg p-4 sm:p-6">
                <h3 class="text-sm sm:text-lg font-medium mb-4">Pelanggan Terbaik (LTV)</h3>
                <div class="block lg:hidden space-y-3">
                    @forelse($reportData['customer_ltv'] as $c)
                    <div class="border rounded-lg p-3">
                        <div class="font-medium">{{ $c['customer']->name }}</div>
                        <div class="text-xs text-gray-500 mb-2">{{ $c['customer']->email }}</div>
                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <div><span class="text-gray-500 text-xs">Booking</span><br>{{ $c['total_bookings'] }}</div>
                            <div><span class="text-gray-500 text-xs">LTV</span><br><span class="text-blue-600">Rp {{ number_format($c['lifetime_value'], 0, ',', '.') }}</span></div>
                            <div><span class="text-gray-500 text-xs">Avg</span><br>Rp {{ number_format($c['average_booking_value'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-gray-500">Tidak ada data</div>
                    @endforelse
                </div>
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50"><tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bookings</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">LTV</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Avg Value</th>
                        </tr></thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($reportData['customer_ltv'] as $c)
                            <tr>
                                <td class="px-4 py-4"><div class="font-medium">{{ $c['customer']->name }}</div><div class="text-sm text-gray-500">{{ $c['customer']->email }}</div></td>
                                <td class="px-4 py-4">{{ $c['total_bookings'] }}</td>
                                <td class="px-4 py-4 text-blue-600 font-medium">Rp {{ number_format($c['lifetime_value'], 0, ',', '.') }}</td>
                                <td class="px-4 py-4">Rp {{ number_format($c['average_booking_value'], 0, ',', '.') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-gray-500">Tidak ada data</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('monthlyRevenueChart', (data) => ({
                init() {
                    new Chart(this.$refs.canvas.getContext('2d'), {
                        type: 'line',
                        data: { labels: data.map(i => i.month_name), datasets: [{ data: data.map(i => i.total_revenue), borderColor: 'rgb(59, 130, 246)', backgroundColor: 'rgba(59, 130, 246, 0.1)', fill: true, tension: 0.4 }] },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                    });
                }
            }));
            Alpine.data('monthlyBookingsChart', (data) => ({
                init() {
                    new Chart(this.$refs.canvas.getContext('2d'), {
                        type: 'bar',
                        data: { labels: data.map(i => i.month_name), datasets: [{ data: data.map(i => i.total_bookings), backgroundColor: 'rgb(16, 185, 129)' }] },
                        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } } }
                    });
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>
