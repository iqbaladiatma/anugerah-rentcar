<div class="space-y-6">
    <!-- Header and Controls -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Vehicle Availability Timeline</h2>
                <p class="text-sm text-gray-600 mt-1">Interactive Gantt chart showing vehicle booking schedules</p>
            </div>
            
            <!-- Quick Date Range Buttons -->
            <div class="flex flex-wrap gap-2">
                <button wire:click="selectDateRange('today')" 
                        class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                    Today
                </button>
                <button wire:click="selectDateRange('week')" 
                        class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                    This Week
                </button>
                <button wire:click="selectDateRange('month')" 
                        class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                    This Month
                </button>
                <button wire:click="selectDateRange('next_week')" 
                        class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                    Next Week
                </button>
                <button wire:click="selectDateRange('next_month')" 
                        class="px-3 py-1 text-xs font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-md transition-colors">
                    Next Month
                </button>
            </div>
        </div>

        <!-- Date Range and Vehicle Filters -->
        <div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-4">
            <!-- Date Range Selection -->
            <div class="lg:col-span-2 grid grid-cols-2 gap-4">
                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" 
                           id="start_date"
                           wire:model.live="startDate" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" 
                           id="end_date"
                           wire:model.live="endDate" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                </div>
            </div>

            <!-- Vehicle Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Filter</label>
                <div class="space-y-2">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               wire:model.live="showAllCars" 
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700">Show All Vehicles</span>
                    </label>
                    
                    @if (!$showAllCars)
                        <div class="max-h-32 overflow-y-auto border border-gray-200 rounded-md p-2 bg-gray-50">
                            @foreach ($allCars as $car)
                                <label class="flex items-center py-1">
                                    <input type="checkbox" 
                                           value="{{ $car->id }}" 
                                           wire:model.live="selectedCarIds" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                                    <span class="ml-2 text-xs text-gray-700">{{ $car->license_plate }} - {{ $car->brand }} {{ $car->model }}</span>
                                </label>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Fleet Summary -->
        @if (!empty($timelineData['summary']))
            <div class="mt-6 grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                    <div class="text-lg font-semibold text-green-800">{{ $timelineData['summary']['available_cars'] }}</div>
                    <div class="text-xs text-green-600">Available Vehicles</div>
                </div>
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <div class="text-lg font-semibold text-blue-800">{{ $timelineData['summary']['unavailable_cars'] }}</div>
                    <div class="text-xs text-blue-600">Unavailable Vehicles</div>
                </div>
                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3">
                    <div class="text-lg font-semibold text-gray-800">{{ $timelineData['summary']['total_cars'] }}</div>
                    <div class="text-xs text-gray-600">Total Fleet</div>
                </div>
                <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                    <div class="text-lg font-semibold text-purple-800">{{ number_format($timelineData['summary']['availability_rate'], 1) }}%</div>
                    <div class="text-xs text-purple-600">Availability Rate</div>
                </div>
            </div>
        @endif
    </div>

    <!-- Timeline Chart -->
    @if (!empty($timelineData['cars']))
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <!-- Legend -->
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <div class="flex flex-wrap items-center gap-4 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-green-200 border border-green-300 rounded"></div>
                        <span class="text-gray-700">Available</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-blue-200 border border-blue-300 rounded"></div>
                        <span class="text-gray-700">Booked</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-yellow-200 border border-yellow-300 rounded"></div>
                        <span class="text-gray-700">Rented</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-red-200 border border-red-300 rounded"></div>
                        <span class="text-gray-700">Maintenance</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-4 h-4 bg-gray-200 border border-gray-300 rounded"></div>
                        <span class="text-gray-700">Inactive</span>
                    </div>
                </div>
            </div>

            <!-- Timeline Grid -->
            <div class="overflow-x-auto">
                <div class="min-w-full">
                    <!-- Date Header -->
                    <div class="flex border-b border-gray-200 timeline-date-header">
                        <div class="w-48 flex-shrink-0 p-3 font-medium text-gray-900 border-r border-gray-200">
                            Vehicle
                        </div>
                        <div class="flex flex-1">
                            @foreach ($timelineData['date_range'] as $date)
                                <div class="flex-1 min-w-16 p-2 text-center border-r border-gray-200 last:border-r-0">
                                    <div class="text-xs font-medium text-gray-900 {{ $date['is_today'] ? 'text-blue-600' : '' }}">
                                        {{ $date['day_name'] }}
                                    </div>
                                    <div class="text-xs text-gray-600 {{ $date['is_today'] ? 'text-blue-600 font-medium' : '' }}">
                                        {{ $date['day_number'] }}
                                    </div>
                                    <div class="text-xs text-gray-500 {{ $date['is_today'] ? 'text-blue-500' : '' }}">
                                        {{ $date['month_name'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Vehicle Rows -->
                    @foreach ($timelineData['cars'] as $car)
                        <div class="flex border-b border-gray-200 timeline-vehicle-row">
                            <!-- Vehicle Info -->
                            <div class="w-48 flex-shrink-0 p-3 border-r border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm">{{ $car['license_plate'] }}</div>
                                        <div class="text-xs text-gray-600">{{ $car['brand'] }} {{ $car['model'] }}</div>
                                        <div class="flex items-center gap-1 mt-1">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                {{ $car['status'] === 'available' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $car['status'] === 'rented' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $car['status'] === 'maintenance' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $car['status'] === 'inactive' ? 'bg-gray-100 text-gray-800' : '' }}">
                                                {{ ucfirst($car['status']) }}
                                            </span>
                                            @if ($car['maintenance_due'])
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-orange-100 text-orange-800">
                                                    ⚠️
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Timeline Cells -->
                            <div class="flex flex-1">
                                @foreach ($car['calendar'] as $day)
                                    <div class="flex-1 min-w-16 p-1 border-r border-gray-200 last:border-r-0">
                                        @if ($day['booking'])
                                            <div class="timeline-cell timeline-booking-block h-8 rounded {{ $this->getStatusColor($day['status']) }} cursor-pointer"
                                                 wire:mouseenter="showBookingDetails({{ $day['booking']['id'] }})"
                                                 wire:mouseleave="hideBookingDetails"
                                                 title="Booking: {{ $day['booking']['booking_number'] }} - {{ $day['booking']['customer_name'] }}">
                                                <div class="h-full flex items-center justify-center">
                                                    <div class="text-xs {{ $this->getStatusTextColor($day['status']) }} font-medium truncate px-1">
                                                        {{ substr($day['booking']['customer_name'], 0, 8) }}{{ strlen($day['booking']['customer_name']) > 8 ? '...' : '' }}
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="timeline-cell h-8 rounded 
                                                {{ $day['status'] === 'available' ? 'timeline-available-block' : '' }}
                                                {{ $day['status'] === 'maintenance' ? 'timeline-maintenance-block' : '' }}
                                                {{ $this->getStatusColor($day['status']) }}">
                                                <div class="h-full flex items-center justify-center">
                                                    @if ($day['status'] === 'available')
                                                        <div class="text-xs text-green-600">✓</div>
                                                    @elseif ($day['status'] === 'maintenance')
                                                        <div class="text-xs text-red-600">🔧</div>
                                                    @elseif ($day['status'] === 'inactive')
                                                        <div class="text-xs text-gray-600">—</div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Booking Details Popup -->
        @if ($hoveredBooking)
            <div class="fixed inset-0 z-50 pointer-events-none">
                <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 pointer-events-auto">
                    <div class="booking-popup bg-white rounded-lg shadow-lg border border-gray-200 p-4 max-w-sm">
                        <div class="space-y-2">
                            <div class="font-medium text-gray-900">Booking Details</div>
                            <div class="text-sm text-gray-600">
                                <div><strong>Booking #:</strong> {{ $hoveredBooking->booking_number }}</div>
                                <div><strong>Customer:</strong> {{ $hoveredBooking->customer->name }}</div>
                                <div><strong>Vehicle:</strong> {{ $hoveredBooking->car->license_plate }}</div>
                                <div><strong>Start:</strong> {{ $hoveredBooking->start_date->format('M j, Y H:i') }}</div>
                                <div><strong>End:</strong> {{ $hoveredBooking->end_date->format('M j, Y H:i') }}</div>
                                <div><strong>Status:</strong> 
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        {{ $hoveredBooking->booking_status === 'confirmed' ? 'bg-blue-100 text-blue-800' : '' }}
                                        {{ $hoveredBooking->booking_status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                        {{ $hoveredBooking->booking_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                        {{ ucfirst($hoveredBooking->booking_status) }}
                                    </span>
                                </div>
                                @if ($hoveredBooking->with_driver)
                                    <div><strong>With Driver:</strong> Yes</div>
                                @endif
                                @if ($hoveredBooking->notes)
                                    <div><strong>Notes:</strong> {{ Str::limit($hoveredBooking->notes, 50) }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-12 text-center">
            <div class="text-gray-400 text-6xl mb-4">📅</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Data Available</h3>
            <p class="text-gray-600">Select a date range and vehicles to view the availability timeline.</p>
        </div>
    @endif

    <!-- Loading State -->
    <div wire:loading class="fixed inset-0 bg-black bg-opacity-25 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 shadow-lg">
            <div class="flex items-center space-x-3">
                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                <div class="text-gray-900">Loading timeline data...</div>
            </div>
        </div>
    </div>
</div>