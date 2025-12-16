<x-public-layout>
    <div class="bg-white">
        <!-- Header -->
        <div class="bg-gray-50 border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <h1 class="text-3xl font-bold text-gray-900">My Bookings</h1>
                <p class="mt-2 text-gray-600">View and manage your rental bookings</p>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if($bookings->count() > 0)
                <div class="space-y-6">
                    @foreach($bookings as $booking)
                        <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            Booking #{{ $booking->booking_number }}
                                        </h3>
                                        <p class="text-sm text-gray-500">
                                            Booked on {{ $booking->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($booking->booking_status === 'active') bg-green-100 text-green-800
                                        @elseif($booking->booking_status === 'completed') bg-blue-100 text-blue-800
                                        @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($booking->booking_status === 'confirmed') bg-purple-100 text-purple-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Vehicle Info -->
                                    <div class="flex items-center space-x-4">
                                        @if($booking->car->photo_front)
                                            <img class="h-16 w-16 rounded-lg object-cover" 
                                                 src="{{ asset('storage/' . $booking->car->photo_front) }}" 
                                                 alt="{{ $booking->car->brand }} {{ $booking->car->model }}">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-medium text-gray-900">
                                                {{ $booking->car->brand }} {{ $booking->car->model }}
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $booking->car->year }} • {{ $booking->car->license_plate }}</p>
                                        </div>
                                    </div>

                                    <!-- Booking Details -->
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-gray-600">
                                                {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-gray-600">{{ $booking->pickup_location }}</span>
                                        </div>
                                        @if($booking->with_driver)
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-gray-600">With Driver</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Pricing -->
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-gray-900">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Payment: 
                                            <span class="font-medium
                                                @if($booking->payment_status === 'paid') text-green-600
                                                @elseif($booking->payment_status === 'partial') text-yellow-600
                                                @else text-red-600 @endif">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if($booking->notes)
                                    <div class="mt-4 p-3 bg-gray-50 rounded-md">
                                        <p class="text-sm text-gray-600">
                                            <strong>Notes:</strong> {{ $booking->notes }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        Duration: {{ $booking->start_date->diffInDays($booking->end_date) }} day(s)
                                    </div>
                                    <div class="flex space-x-3">
                                        @if($booking->canBeCancelled())
                                            <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" 
                                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="cancellation_reason" value="Cancelled by customer">
                                                <button type="submit" class="text-red-600 hover:text-red-500 text-sm font-medium">
                                                    Cancel Booking
                                                </button>
                                            </form>
                                        @endif
                                        @if($booking->canBeModified())
                                            <a href="{{ route('customer.bookings.edit', $booking) }}" 
                                               class="text-yellow-600 hover:text-yellow-500 text-sm font-medium">
                                                Modify
                                            </a>
                                        @endif
                                        @if(in_array($booking->booking_status, ['confirmed', 'active']))
                                            <a href="{{ route('customer.bookings.ticket', $booking) }}" 
                                               class="text-green-600 hover:text-green-500 text-sm font-medium">
                                                E-Ticket
                                            </a>
                                        @endif
                                        <a href="{{ route('customer.bookings.show', $booking) }}" 
                                           class="text-blue-600 hover:text-blue-500 text-sm font-medium">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Start by booking your first vehicle.</p>
                    <div class="mt-6">
                        <a href="{{ route('vehicles.catalog') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            Browse Vehicles
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>