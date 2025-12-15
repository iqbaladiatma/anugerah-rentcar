<div>
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Vehicle Management</h2>
                <p class="text-gray-600">Manage your fleet of rental vehicles</p>
            </div>
            <a href="{{ route('admin.vehicles.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center gap-2">
                <x-icons.plus class="w-5 h-5" />
                Add Vehicle
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm border p-4 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search"
                       placeholder="License plate, brand, model..."
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="status" 
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Status</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Maintenance Due Toggle -->
            <div class="flex items-end">
                <label class="flex items-center">
                    <input type="checkbox" 
                           wire:model.live="showMaintenanceDue"
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-700">Maintenance Due Only</span>
                </label>
            </div>

            <!-- Results Count -->
            <div class="flex items-end justify-end">
                <span class="text-sm text-gray-600">
                    {{ $vehicles->total() }} vehicles found
                </span>
            </div>
        </div>
    </div>

    <!-- Vehicle Table -->
    <div class="bg-white rounded-lg shadow-sm border overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th wire:click="sortBy('license_plate')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            <div class="flex items-center gap-1">
                                License Plate
                                @if($sortBy === 'license_plate')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Vehicle Info
                        </th>
                        <th wire:click="sortBy('status')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            <div class="flex items-center gap-1">
                                Status
                                @if($sortBy === 'status')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th wire:click="sortBy('daily_rate')" 
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                            <div class="flex items-center gap-1">
                                Daily Rate
                                @if($sortBy === 'daily_rate')
                                    @if($sortDirection === 'asc')
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                        </svg>
                                    @else
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"/>
                                        </svg>
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Notifications
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($vehicles as $vehicle)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $vehicle->license_plate }}</div>
                                <div class="text-sm text-gray-500">STNK: {{ $vehicle->stnk_number }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $vehicle->brand }} {{ $vehicle->model }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $vehicle->year }} • {{ $vehicle->color }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ number_format($vehicle->current_odometer) }} km
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($vehicle->status === 'available') bg-green-100 text-green-800
                                        @elseif($vehicle->status === 'rented') bg-blue-100 text-blue-800
                                        @elseif($vehicle->status === 'maintenance') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($vehicle->status) }}
                                    </span>
                                    
                                    @if($vehicle->status !== 'rented')
                                        <select wire:change="updateVehicleStatus({{ $vehicle->id }}, $event.target.value)"
                                                class="text-xs border border-gray-300 rounded px-2 py-1">
                                            @foreach($statusOptions as $value => $label)
                                                @if($value !== 'rented' || $vehicle->status === 'rented')
                                                    <option value="{{ $value }}" 
                                                            @if($vehicle->status === $value) selected @endif>
                                                        {{ $label }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4">
                                @if(isset($maintenanceNotifications[$vehicle->id]))
                                    <div class="space-y-1">
                                        @foreach($maintenanceNotifications[$vehicle->id] as $notification)
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full
                                                    @if($notification['priority'] === 'high') bg-red-100 text-red-800
                                                    @else bg-yellow-100 text-yellow-800
                                                    @endif">
                                                    @if($notification['type'] === 'oil_change')
                                                        Oil Change Due
                                                    @elseif($notification['type'] === 'stnk_expiry')
                                                        STNK Expiring
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-gray-400">No issues</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.vehicles.show', $vehicle) }}" 
                                       class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <x-icons.car class="w-12 h-12 mx-auto mb-4 text-gray-300" />
                                    <p class="text-lg font-medium">No vehicles found</p>
                                    <p class="text-sm">Get started by adding your first vehicle to the fleet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($vehicles->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $vehicles->links() }}
            </div>
        @endif
    </div>
</div>