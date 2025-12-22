<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Kendaraan') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.vehicle') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
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
                            <div>
                                <label for="car_id" class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                                <select name="car_id" id="car_id" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                                    <option value="">Semua</option>
                                    @foreach(\App\Models\Car::all() as $car)
                                        <option value="{{ $car->id }}" {{ request('car_id') == $car->id ? 'selected' : '' }}>
                                            {{ $car->license_plate }} - {{ $car->brand }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-accent-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-accent-700 transition ease-in-out duration-150">
                                    Laporan
                                </button>
                            </div>
                            <div class="flex items-end gap-2">
                                <a href="{{ route('admin.reports.vehicle', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">Excel</span>
                                </a>
                                <a href="{{ route('admin.reports.vehicle', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
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
            <!-- Fleet Summary -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">
                        Ringkasan Armada 
                        <span class="block sm:inline text-xs sm:text-sm text-gray-500 font-normal mt-1 sm:mt-0">
                            ({{ $reportData['period']['start_date'] }} - {{ $reportData['period']['end_date'] }} • {{ $reportData['period']['total_days'] }} hari)
                        </span>
                    </h3>
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-blue-600">{{ number_format($reportData['fleet_summary']['total_vehicles']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Total Kendaraan</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-green-600">{{ number_format($reportData['fleet_summary']['average_utilization'], 1) }}%</div>
                            <div class="text-xs sm:text-sm text-gray-500">Utilisasi Rata-rata</div>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-purple-600">Rp {{ number_format($reportData['fleet_summary']['total_fleet_revenue'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Total Pendapatan</div>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-red-600">Rp {{ number_format($reportData['fleet_summary']['total_maintenance_costs'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Biaya Pemeliharaan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top Performers -->
            @if($reportData['fleet_summary']['most_profitable_vehicle'] || $reportData['fleet_summary']['highest_utilization_vehicle'])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4 lg:gap-6 mb-4 sm:mb-6">
                @if($reportData['fleet_summary']['most_profitable_vehicle'])
                <div class="bg-gradient-to-r from-yellow-50 to-yellow-100 overflow-hidden shadow-sm rounded-lg border-2 border-yellow-200">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-yellow-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                            <h4 class="text-sm sm:text-lg font-bold text-yellow-900">Kendaraan Paling Laku</h4>
                        </div>
                        <div class="text-base sm:text-lg font-bold text-gray-900">{{ $reportData['fleet_summary']['most_profitable_vehicle']->license_plate }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">{{ $reportData['fleet_summary']['most_profitable_vehicle']->brand }} {{ $reportData['fleet_summary']['most_profitable_vehicle']->model }}</div>
                    </div>
                </div>
                @endif

                @if($reportData['fleet_summary']['highest_utilization_vehicle'])
                <div class="bg-gradient-to-r from-green-50 to-green-100 overflow-hidden shadow-sm rounded-lg border-2 border-green-200">
                    <div class="p-4 sm:p-6">
                        <div class="flex items-center mb-2">
                            <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            <h4 class="text-sm sm:text-lg font-bold text-green-900">Utilisasi Terendah</h4>
                        </div>
                        <div class="text-base sm:text-lg font-bold text-gray-900">{{ $reportData['fleet_summary']['highest_utilization_vehicle']->license_plate }}</div>
                        <div class="text-xs sm:text-sm text-gray-600">{{ $reportData['fleet_summary']['highest_utilization_vehicle']->brand }} {{ $reportData['fleet_summary']['highest_utilization_vehicle']->model }}</div>
                    </div>
                </div>
                @endif
            </div>
            @endif

            <!-- Vehicle Details -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">Detail Performa Kendaraan</h3>
                    
                    <!-- Mobile Card View -->
                    <div class="block lg:hidden space-y-3">
                        @forelse($reportData['vehicles'] as $vehicleData)
                        @php
                            $utilization = $vehicleData['utilization_rate'];
                            $performance = 'Poor';
                            $performanceClass = 'bg-red-100 text-red-800';
                            
                            if ($utilization >= 70 && $vehicleData['net_revenue'] > 0) {
                                $performance = 'Excellent';
                                $performanceClass = 'bg-green-100 text-green-800';
                            } elseif ($utilization >= 50 && $vehicleData['net_revenue'] > 0) {
                                $performance = 'Good';
                                $performanceClass = 'bg-blue-100 text-blue-800';
                            } elseif ($utilization >= 30 || $vehicleData['net_revenue'] > 0) {
                                $performance = 'Fair';
                                $performanceClass = 'bg-yellow-100 text-yellow-800';
                            }
                        @endphp
                        <div class="border rounded-lg p-4 {{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $vehicleData['vehicle']->license_plate }}</div>
                                    <div class="text-xs text-gray-500">{{ $vehicleData['vehicle']->brand }} {{ $vehicleData['vehicle']->model }} ({{ $vehicleData['vehicle']->year }})</div>
                                </div>
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $performanceClass }}">{{ $performance }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <div class="text-xs text-gray-500">Peminjaman</div>
                                    <div class="font-medium">{{ $vehicleData['total_bookings'] }} ({{ $vehicleData['total_booked_days'] }} hari)</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Utilisasi</div>
                                    @php
                                        $utilizationClass = $utilization >= 70 ? 'text-green-600' : ($utilization >= 40 ? 'text-yellow-600' : 'text-red-600');
                                    @endphp
                                    <div class="font-medium {{ $utilizationClass }}">{{ number_format($utilization, 1) }}%</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Pendapatan</div>
                                    <div class="font-medium">Rp {{ number_format($vehicleData['total_revenue'], 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Pemeliharaan</div>
                                    <div class="font-medium text-red-600">Rp {{ number_format($vehicleData['maintenance_costs'], 0, ',', '.') }}</div>
                                </div>
                                <div class="col-span-2">
                                    <div class="text-xs text-gray-500">Pendapatan Bersih</div>
                                    <div class="font-semibold {{ $vehicleData['net_revenue'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($vehicleData['net_revenue'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">Tidak ada kendaraan ditemukan.</div>
                        @endforelse
                    </div>
                    
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjaman</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utilisasi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemeliharaan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan Bersih</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Performa</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reportData['vehicles'] as $vehicleData)
                                @php
                                    $utilization = $vehicleData['utilization_rate'];
                                    $utilizationClass = $utilization >= 70 ? 'text-green-600' : ($utilization >= 40 ? 'text-yellow-600' : 'text-red-600');
                                    $utilizationBg = $utilization >= 70 ? 'bg-green-100' : ($utilization >= 40 ? 'bg-yellow-100' : 'bg-red-100');
                                    
                                    $performance = 'Poor';
                                    $performanceClass = 'bg-red-100 text-red-800';
                                    
                                    if ($utilization >= 70 && $vehicleData['net_revenue'] > 0) {
                                        $performance = 'Excellent';
                                        $performanceClass = 'bg-green-100 text-green-800';
                                    } elseif ($utilization >= 50 && $vehicleData['net_revenue'] > 0) {
                                        $performance = 'Good';
                                        $performanceClass = 'bg-blue-100 text-blue-800';
                                    } elseif ($utilization >= 30 || $vehicleData['net_revenue'] > 0) {
                                        $performance = 'Fair';
                                        $performanceClass = 'bg-yellow-100 text-yellow-800';
                                    }
                                @endphp
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $vehicleData['vehicle']->license_plate }}</div>
                                        <div class="text-sm text-gray-500">{{ $vehicleData['vehicle']->brand }} {{ $vehicleData['vehicle']->model }} ({{ $vehicleData['vehicle']->year }})</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $vehicleData['total_bookings'] }} total<br>
                                        <span class="text-xs text-gray-500">{{ $vehicleData['completed_bookings'] }} selesai • {{ $vehicleData['total_booked_days'] }} hari</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $utilizationBg }} {{ $utilizationClass }}">
                                            {{ number_format($utilization, 1) }}%
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($vehicleData['total_revenue'], 0, ',', '.') }}<br>
                                        <span class="text-xs text-gray-500">Avg: Rp {{ number_format($vehicleData['average_booking_value'], 0, ',', '.') }}</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($vehicleData['maintenance_costs'], 0, ',', '.') }}<br>
                                        <span class="text-xs text-gray-500">{{ $vehicleData['maintenance_frequency'] }} services</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm font-semibold {{ $vehicleData['net_revenue'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                        Rp {{ number_format($vehicleData['net_revenue'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $performanceClass }}">
                                            {{ $performance }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
                                        Tidak ada kendaraan ditemukan untuk kriteria yang dipilih.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Performance Notes -->
            <div class="bg-gray-50 overflow-hidden shadow-sm rounded-lg mt-4 sm:mt-6">
                <div class="p-4 sm:p-6">
                    <h4 class="text-sm font-medium text-gray-900 mb-3">Penjelasan Indikator Performa</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-xs sm:text-sm text-gray-600">
                        <div>
                            <strong>Utilisasi:</strong> Persentase hari yang kendaraan dipinjam<br>
                            <strong>Revenue per Day:</strong> Total pendapatan / hari dipinjam<br>
                            <strong>Net Revenue:</strong> Pendapatan - biaya pemeliharaan
                        </div>
                        <div>
                            <strong>Performa:</strong><br>
                            • Excellent: ≥70% Utilisasi + Net Revenue Positif<br>
                            • Good: ≥50% Utilisasi + Net Revenue Positif<br>
                            • Fair: ≥30% Utilisasi OR Net Revenue Positif<br>
                            • Poor: Rendah semua
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>