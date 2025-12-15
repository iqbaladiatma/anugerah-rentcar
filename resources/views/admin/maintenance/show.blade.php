<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Maintenance Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.maintenance.edit', $maintenance) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-icons.pencil class="w-4 h-4 inline mr-1" />
                    Edit
                </a>
                <a href="{{ route('admin.maintenance.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <x-icons.arrow-left class="w-4 h-4 inline mr-1" />
                    Back to List
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Maintenance Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Vehicle Information -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Vehicle</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        <div class="font-semibold">{{ $maintenance->car->license_plate }}</div>
                                        <div class="text-gray-600">{{ $maintenance->car->brand }} {{ $maintenance->car->model }}</div>
                                        <div class="text-gray-500">{{ $maintenance->car->year }}</div>
                                    </div>
                                </div>

                                <!-- Maintenance Type -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Maintenance Type</label>
                                    <div class="mt-1">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($maintenance->maintenance_type === 'routine') bg-green-100 text-green-800
                                            @elseif($maintenance->maintenance_type === 'repair') bg-red-100 text-red-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ ucfirst($maintenance->maintenance_type) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Service Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Service Date</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $maintenance->service_date->format('d F Y') }}
                                        <span class="text-gray-500">({{ $maintenance->service_date->diffForHumans() }})</span>
                                    </div>
                                </div>

                                <!-- Next Service Date -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Next Service Date</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        @if($maintenance->next_service_date)
                                            <div class="@if($maintenance->isNextServiceDue()) text-red-600 font-semibold @elseif($maintenance->isNextServiceDueSoon()) text-yellow-600 font-semibold @endif">
                                                {{ $maintenance->next_service_date->format('d F Y') }}
                                                @if($maintenance->isNextServiceDue())
                                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded-full ml-2">Overdue</span>
                                                @elseif($maintenance->isNextServiceDueSoon())
                                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full ml-2">Due Soon</span>
                                                @endif
                                            </div>
                                            @if($maintenance->getDaysUntilNextService() !== null)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $maintenance->getDaysUntilNextService() }} days until next service
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400">Not scheduled</span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Cost -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Cost</label>
                                    <div class="mt-1 text-lg font-semibold text-gray-900">
                                        Rp {{ number_format($maintenance->cost, 0, ',', '.') }}
                                    </div>
                                </div>

                                <!-- Odometer Reading -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Odometer Reading</label>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ number_format($maintenance->odometer_at_service, 0, ',', '.') }} km
                                    </div>
                                </div>

                                <!-- Service Provider -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Service Provider</label>
                                    <div class="mt-1 text-sm text-gray-900">{{ $maintenance->service_provider }}</div>
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Description</label>
                                    <div class="mt-1 text-sm text-gray-900 whitespace-pre-line">{{ $maintenance->description }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Receipt Photo -->
                    @if($maintenance->receipt_photo)
                        <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Receipt Photo</h3>
                                <div class="text-center">
                                    <img src="{{ $maintenance->receipt_photo_url }}" 
                                         alt="Maintenance Receipt" 
                                         class="max-w-full h-auto rounded-lg shadow-lg mx-auto"
                                         style="max-height: 500px;">
                                    <div class="mt-2">
                                        <a href="{{ $maintenance->receipt_photo_url }}" 
                                           target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 text-sm">
                                            View Full Size
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Quick Actions -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('admin.maintenance.edit', $maintenance) }}" 
                                   class="w-full bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    Edit Maintenance
                                </a>
                                <a href="{{ route('admin.vehicles.show', $maintenance->car) }}" 
                                   class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    View Vehicle
                                </a>
                                <a href="{{ route('admin.maintenance.car-history', $maintenance->car) }}" 
                                   class="w-full bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded text-center block">
                                    Vehicle History
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Cost Analysis -->
                    @if($maintenance->getCostPerKilometer())
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Cost Analysis</h3>
                                <div class="space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-sm text-gray-600">Cost per km:</span>
                                        <span class="text-sm font-medium">Rp {{ number_format($maintenance->getCostPerKilometer(), 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Related Maintenance -->
                    @if($relatedMaintenances->count() > 0)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Recent Maintenance</h3>
                                <div class="space-y-3">
                                    @foreach($relatedMaintenances as $related)
                                        <div class="border-l-4 border-gray-200 pl-3">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">
                                                        {{ $related->service_date->format('d M Y') }}
                                                    </div>
                                                    <div class="text-xs text-gray-600">
                                                        {{ ucfirst($related->maintenance_type) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 truncate" style="max-width: 200px;">
                                                        {{ $related->description }}
                                                    </div>
                                                </div>
                                                <div class="text-right">
                                                    <div class="text-sm font-medium text-gray-900">
                                                        Rp {{ number_format($related->cost, 0, ',', '.') }}
                                                    </div>
                                                    <a href="{{ route('admin.maintenance.show', $related) }}" 
                                                       class="text-xs text-blue-600 hover:text-blue-800">
                                                        View
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>