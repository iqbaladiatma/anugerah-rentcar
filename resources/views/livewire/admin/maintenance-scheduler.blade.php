<div class="p-6">
    <!-- Quick Actions -->
    <div class="mb-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Maintenance Scheduler</h3>
            <button wire:click="toggleScheduleForm" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                @if($showScheduleForm)
                    Cancel
                @else
                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                    </svg>
                    Schedule Maintenance
                @endif
            </button>
        </div>

        <!-- Schedule Form -->
        @if($showScheduleForm)
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                <h4 class="text-md font-medium text-gray-900 mb-4">Schedule New Maintenance</h4>
                
                <form wire:submit="scheduleMaintenance">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Vehicle Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle</label>
                            <select wire:model="carId" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Vehicle</option>
                                @foreach($cars as $car)
                                    <option value="{{ $car->id }}">{{ $car->license_plate }} - {{ $car->brand }} {{ $car->model }}</option>
                                @endforeach
                            </select>
                            @error('carId') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Maintenance Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                            <select wire:model="maintenanceType" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @foreach($maintenanceTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('maintenanceType') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Scheduled Date -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Scheduled Date</label>
                            <input type="date" wire:model="scheduledDate" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('scheduledDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Estimated Cost -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Cost (IDR)</label>
                            <input type="number" wire:model="estimatedCost" step="0.01" min="0"
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('estimatedCost') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Service Provider -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Service Provider</label>
                            <input type="text" wire:model="serviceProvider" 
                                   class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            @error('serviceProvider') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea wire:model="description" rows="3"
                                      class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end space-x-2">
                        <button type="button" wire:click="resetForm" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                            Reset
                        </button>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Schedule Maintenance
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- Maintenance Status Overview -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Overdue Maintenance -->
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-red-900">Overdue Maintenance</h3>
                    <p class="text-2xl font-bold text-red-600">{{ $overdueMaintenance->count() }}</p>
                </div>
            </div>
            @if($overdueMaintenance->count() > 0)
                <div class="mt-4">
                    @foreach($overdueMaintenance->take(3) as $maintenance)
                        <div class="flex justify-between items-center py-2 border-b border-red-200 last:border-b-0">
                            <div>
                                <div class="font-medium text-red-900">{{ $maintenance->car->license_plate }}</div>
                                <div class="text-sm text-red-700">{{ $maintenance->next_service_date->format('d M Y') }}</div>
                            </div>
                            <button wire:click="quickScheduleOilChange({{ $maintenance->car_id }})"
                                    class="text-xs bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded">
                                Schedule
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Due Soon -->
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-yellow-900">Due Soon (7 days)</h3>
                    <p class="text-2xl font-bold text-yellow-600">{{ $dueSoonMaintenance->count() }}</p>
                </div>
            </div>
            @if($dueSoonMaintenance->count() > 0)
                <div class="mt-4">
                    @foreach($dueSoonMaintenance->take(3) as $maintenance)
                        <div class="flex justify-between items-center py-2 border-b border-yellow-200 last:border-b-0">
                            <div>
                                <div class="font-medium text-yellow-900">{{ $maintenance->car->license_plate }}</div>
                                <div class="text-sm text-yellow-700">{{ $maintenance->next_service_date->format('d M Y') }}</div>
                            </div>
                            <button wire:click="quickScheduleOilChange({{ $maintenance->car_id }})"
                                    class="text-xs bg-yellow-600 hover:bg-yellow-700 text-white px-2 py-1 rounded">
                                Schedule
                            </button>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Upcoming Scheduled -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-medium text-green-900">Upcoming Scheduled</h3>
                    <p class="text-2xl font-bold text-green-600">{{ $upcomingMaintenance->count() }}</p>
                </div>
            </div>
            @if($upcomingMaintenance->count() > 0)
                <div class="mt-4">
                    @foreach($upcomingMaintenance->take(3) as $maintenance)
                        <div class="flex justify-between items-center py-2 border-b border-green-200 last:border-b-0">
                            <div>
                                <div class="font-medium text-green-900">{{ $maintenance->car->license_plate }}</div>
                                <div class="text-sm text-green-700">{{ $maintenance->service_date->format('d M Y') }}</div>
                            </div>
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">
                                {{ ucfirst($maintenance->maintenance_type) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions for Vehicles -->
    <div class="bg-white shadow overflow-hidden sm:rounded-md">
        <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
            <h3 class="text-lg leading-6 font-medium text-gray-900">Quick Actions</h3>
            <p class="mt-1 text-sm text-gray-500">Schedule common maintenance tasks for your vehicles</p>
        </div>

        <div class="divide-y divide-gray-200">
            @foreach($cars as $car)
                <div class="px-4 py-4 flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                <svg class="h-6 w-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">{{ $car->license_plate }}</div>
                            <div class="text-sm text-gray-500">{{ $car->brand }} {{ $car->model }}</div>
                            <div class="text-xs text-gray-400">
                                @if($car->last_oil_change)
                                    Last oil change: {{ $car->last_oil_change->format('d M Y') }}
                                @else
                                    No oil change recorded
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex space-x-2">
                        <button wire:click="quickScheduleOilChange({{ $car->id }})"
                                class="bg-blue-500 hover:bg-blue-700 text-white text-xs font-bold py-1 px-3 rounded">
                            Oil Change
                        </button>
                        @if($car->stnk_expiry)
                            <button wire:click="quickScheduleStnkRenewal({{ $car->id }})"
                                    class="bg-green-500 hover:bg-green-700 text-white text-xs font-bold py-1 px-3 rounded">
                                STNK Renewal
                            </button>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Upcoming Maintenance Schedule -->
    @if($upcomingMaintenance->count() > 0)
        <div class="mt-6 bg-white shadow overflow-hidden sm:rounded-md">
            <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Upcoming Maintenance Schedule</h3>
            </div>
            <div class="divide-y divide-gray-200">
                @foreach($upcomingMaintenance as $maintenance)
                    <div class="px-4 py-4 flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="h-10 w-10 rounded-full 
                                    @if($maintenance->maintenance_type === 'routine') bg-green-100
                                    @elseif($maintenance->maintenance_type === 'repair') bg-red-100
                                    @else bg-blue-100 @endif
                                    flex items-center justify-center">
                                    <svg class="h-6 w-6 
                                        @if($maintenance->maintenance_type === 'routine') text-green-600
                                        @elseif($maintenance->maintenance_type === 'repair') text-red-600
                                        @else text-blue-600 @endif" 
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">{{ $maintenance->car->license_plate }}</div>
                                <div class="text-sm text-gray-500">{{ $maintenance->description }}</div>
                                <div class="text-xs text-gray-400">{{ $maintenance->service_provider }}</div>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-medium text-gray-900">{{ $maintenance->service_date->format('d M Y') }}</div>
                            <div class="text-sm text-gray-500">{{ $maintenance->service_date->diffForHumans() }}</div>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($maintenance->maintenance_type === 'routine') bg-green-100 text-green-800
                                @elseif($maintenance->maintenance_type === 'repair') bg-red-100 text-red-800
                                @else bg-blue-100 text-blue-800 @endif">
                                {{ ucfirst($maintenance->maintenance_type) }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>