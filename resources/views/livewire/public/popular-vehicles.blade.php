<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($vehicles as $vehicle)
        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
            <!-- Vehicle Image -->
            <div class="h-48 bg-gray-200 relative">
                @if($vehicle->photo_front)
                    <img 
                        src="{{ Storage::url($vehicle->photo_front) }}" 
                        alt="{{ $vehicle->brand }} {{ $vehicle->model }}"
                        class="w-full h-full object-cover"
                    >
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                    </div>
                @endif
                
                <!-- Status Badge -->
                <div class="absolute top-2 right-2">
                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-medium">
                        Available
                    </span>
                </div>
            </div>

            <!-- Vehicle Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                    {{ $vehicle->brand }} {{ $vehicle->model }}
                </h3>
                
                <div class="flex items-center text-sm text-gray-600 mb-2">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                    {{ $vehicle->year }}
                </div>

                <div class="flex items-center text-sm text-gray-600 mb-3">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2v1a2 2 0 002 2h4a2 2 0 002-2V3a2 2 0 012 2v6a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3z" clip-rule="evenodd"/>
                    </svg>
                    {{ $vehicle->license_plate }}
                </div>

                <!-- Pricing -->
                <div class="flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format($vehicle->daily_rate, 0, ',', '.') }}
                        </span>
                        <span class="text-sm text-gray-500">/day</span>
                    </div>
                    
                    <a 
                        href="{{ route('vehicles.show', $vehicle) }}" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors"
                    >
                        View Details
                    </a>
                </div>

                @if($vehicle->weekly_rate)
                    <div class="mt-2 text-sm text-gray-600">
                        Weekly: Rp {{ number_format($vehicle->weekly_rate, 0, ',', '.') }}
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="col-span-full text-center py-12">
            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
            </svg>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No vehicles available</h3>
            <p class="text-gray-600">Check back later for available rental cars.</p>
        </div>
    @endforelse
</div>

@if($vehicles->count() > 0)
    <div class="text-center mt-8">
        <a 
            href="{{ route('vehicles.catalog') }}" 
            class="inline-flex items-center px-6 py-3 border border-blue-600 text-blue-600 font-medium rounded-lg hover:bg-blue-600 hover:text-white transition-colors"
        >
            View All Vehicles
            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"/>
            </svg>
        </a>
    </div>
@endif