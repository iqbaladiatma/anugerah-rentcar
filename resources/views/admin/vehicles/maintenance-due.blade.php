<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Kendaraan yang perlu Pemeliharaan
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kendaraan yang perlu oil changes, STNK renewals, atau perawatan lainnya.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.vehicles.index') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-icons.arrow-left class="w-4 h-4 mr-2" />
                    Kembali ke Armada Kendaraan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Maintenance Notifications Component -->
        <livewire:admin.maintenance-notifications :show-all="true" />
        
        <!-- Vehicles Needing Maintenance -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Kendaraan yang perlu perhatian</h3>
            </div>
            <div class="overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kendaraan
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Issue
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Priority
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $maintenanceVehicles = \App\Models\Car::where(function ($query) {
                                    $query->where('last_oil_change', '<=', now()->subDays(90))
                                          ->orWhere('stnk_expiry', '<=', now()->addDays(30));
                                })->get();
                            @endphp
                            
                            @forelse($maintenanceVehicles as $vehicle)
                                @php
                                    $notifications = $vehicle->getMaintenanceNotifications();
                                @endphp
                                @foreach($notifications as $notification)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $vehicle->license_plate }}
                                                    </div>
                                                    <div class="text-sm text-gray-500">
                                                        {{ $vehicle->brand }} {{ $vehicle->model }}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $notification['message'] }}</div>
                                            <div class="text-sm text-gray-500">
                                                @if($notification['type'] === 'oil_change')
                                                    Last oil change: {{ $vehicle->last_oil_change?->format('d M Y') ?? 'Not recorded' }}
                                                @elseif($notification['type'] === 'stnk_expiry')
                                                    STNK expires: {{ $vehicle->stnk_expiry?->format('d M Y') }}
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($notification['priority'] === 'high') bg-red-100 text-red-800
                                                @else bg-yellow-100 text-yellow-800
                                                @endif">
                                                {{ ucfirst($notification['priority']) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($vehicle->status === 'available') bg-green-100 text-green-800
                                                @elseif($vehicle->status === 'rented') bg-blue-100 text-blue-800
                                                @elseif($vehicle->status === 'maintenance') bg-yellow-100 text-yellow-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst($vehicle->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex items-center justify-end space-x-2">
                                                @if($vehicle->status !== 'maintenance')
                                                    <form action="{{ route('admin.vehicles.update-status', $vehicle) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="status" value="maintenance">
                                                        <input type="hidden" name="reason" value="Scheduled maintenance">
                                                        <button type="submit" 
                                                                class="text-yellow-600 hover:text-yellow-900 text-sm">
                                                            Tandai untuk Pemeliharaan
                                                        </button>
                                                    </form>
                                                @endif
                                                <a href="{{ route('admin.vehicles.show', $vehicle) }}" 
                                                   class="text-blue-600 hover:text-blue-900 text-sm">Lihat</a>
                                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                                                   class="text-indigo-600 hover:text-indigo-900 text-sm">Edit</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <x-icons.wrench class="w-12 h-12 mx-auto mb-4 text-gray-300" />
                                            <p class="text-lg font-medium">Tidak ada kendaraan yang perlu pemeliharaan</p>
                                            <p class="text-sm">Semua kendaraan sudah up to date dengan jadwal pemeliharaan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>