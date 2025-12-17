<div class="p-6">
    <!-- Filters Section -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Date Range Selector -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                <select wire:model.live="dateRange" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="7">Last 7 days</option>
                    <option value="30">Last 30 days</option>
                    <option value="90">Last 90 days</option>
                    <option value="365">Last year</option>
                    <option value="custom">Custom range</option>
                </select>
            </div>

            <!-- Vehicle Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mobil</label>
                <select wire:model.live="selectedCar" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Mobil</option>
                    @foreach($cars as $car)
                        <option value="{{ $car->id }}">{{ $car->license_plate }} - {{ $car->brand }} {{ $car->model }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Type Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Pemeliharaan</label>
                <select wire:model.live="selectedType" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Jenis</option>
                    @foreach($maintenanceTypes as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Export Button -->
            <div class="flex items-end">
                <button wire:click="exportData" 
                        class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export Data
                </button>
            </div>
        </div>

        <!-- Custom Date Range -->
        @if($dateRange === 'custom')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                    <input type="date" wire:model.live="startDate" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                    <input type="date" wire:model.live="endDate" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>
        @endif
    </div>

    <!-- Summary Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Biaya</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        Rp {{ number_format($analyticsData['total_cost'], 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Record</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $analyticsData['total_count'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Rata-rata Biaya</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        Rp {{ number_format($analyticsData['average_cost'], 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Upcoming</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $upcomingCount }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Analytics -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Cost by Type Chart -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Biaya berdasarkan jenis pemeliharaan</h3>
            @if($analyticsData['cost_by_type']->count() > 0)
                <div class="space-y-4">
                    @foreach($analyticsData['cost_by_type'] as $typeData)
                        <div>
                            <div class="flex justify-between items-center mb-1">
                                <span class="text-sm font-medium text-gray-700">{{ $typeData['type'] }}</span>
                                <span class="text-sm text-gray-500">{{ $typeData['count'] }} records</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" 
                                     style="width: {{ $analyticsData['total_cost'] > 0 ? ($typeData['total_cost'] / $analyticsData['total_cost']) * 100 : 0 }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                <span>Rp {{ number_format($typeData['total_cost'], 0, ',', '.') }}</span>
                                <span>Avg: Rp {{ number_format($typeData['average_cost'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No data available for the selected period</p>
                </div>
            @endif
        </div>

        <!-- Monthly Trends -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Tren Bulanan</h3>
            @if($analyticsData['monthly_trends']->count() > 0)
                <div class="space-y-3">
                    @foreach($analyticsData['monthly_trends'] as $trend)
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $trend['month_name'] }}</div>
                                <div class="text-xs text-gray-500">{{ $trend['count'] }} maintenance records</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($trend['total_cost'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No monthly data available</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Top Service Providers -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Top Provider</h3>
            @if($analyticsData['top_providers']->count() > 0)
                <div class="space-y-3">
                    @foreach($analyticsData['top_providers'] as $provider)
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $provider['provider'] }}</div>
                                <div class="text-xs text-gray-500">{{ $provider['count'] }} services</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($provider['total_cost'], 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Avg: Rp {{ number_format($provider['average_cost'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <p>No service provider data available</p>
                </div>
            @endif
        </div>

        <!-- Vehicle Costs (only show if not filtering by specific car) -->
        @if(!$selectedCar && $analyticsData['vehicle_costs']->count() > 0)
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Biaya Pemeliharaan Mobil</h3>
                <div class="space-y-3">
                    @foreach($analyticsData['vehicle_costs'] as $vehicleData)
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $vehicleData['license_plate'] }}</div>
                                <div class="text-xs text-gray-500">{{ $vehicleData['vehicle_name'] }} • {{ $vehicleData['count'] }} services</div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm font-semibold text-gray-900">
                                    Rp {{ number_format($vehicleData['total_cost'], 0, ',', '.') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Avg: Rp {{ number_format($vehicleData['average_cost'], 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    <!-- Status Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-yellow-900">Upcoming Maintenance</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $upcomingCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-red-900">Terlambat Pemeliharaan</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $overdueCount }}</p>
                </div>
            </div>
        </div>

        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5zM4 19h5v-5H4v5zM13 13h5V8h-5v5zM4 13h5V8H4v5zM13 3h5v5h-5V3zM4 3h5v5H4V3z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-orange-900">Hampir Terlambat (7 days)</h3>
                    <p class="text-2xl font-bold text-orange-600">{{ $dueSoonCount }}</p>
                </div>
            </div>
        </div>
    </div>
</div>