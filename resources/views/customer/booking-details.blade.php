<x-public-layout>
    <div class="bg-white">
        <!-- Header -->
        <div class="bg-gray-50 border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Booking Details</h1>
                        <p class="mt-2 text-gray-600">Booking #{{ $booking->booking_number }}</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('customer.bookings') }}" 
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Back to Bookings
                        </a>
                        @if(in_array($booking->booking_status, ['confirmed', 'active']))
                            <a href="{{ route('customer.bookings.ticket', $booking) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Download E-Ticket
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Booking Status -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Booking Status</h2>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                @if($booking->booking_status === 'active') bg-green-100 text-green-800
                                @elseif($booking->booking_status === 'completed') bg-blue-100 text-blue-800
                                @elseif($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->booking_status === 'confirmed') bg-purple-100 text-purple-800
                                @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($booking->booking_status) }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500">Booking Date</p>
                                <p class="font-medium">{{ $booking->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Payment Status</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($booking->payment_status === 'paid') bg-green-100 text-green-800
                                    @elseif($booking->payment_status === 'partial') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($booking->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Vehicle Information -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Vehicle Information</h2>
                        <div class="flex items-start space-x-4">
                            @if($booking->car->photo_front)
                                <img class="h-24 w-24 rounded-lg object-cover" 
                                     src="{{ asset('storage/' . $booking->car->photo_front) }}" 
                                     alt="{{ $booking->car->brand }} {{ $booking->car->model }}">
                            @else
                                <div class="h-24 w-24 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    {{ $booking->car->brand }} {{ $booking->car->model }}
                                </h3>
                                <div class="mt-2 grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Year</p>
                                        <p class="font-medium">{{ $booking->car->year }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">License Plate</p>
                                        <p class="font-medium">{{ $booking->car->license_plate }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Color</p>
                                        <p class="font-medium">{{ $booking->car->color }}</p>
                                    </div>
                                    <div>
                                        <p class="text-gray-500">Daily Rate</p>
                                        <p class="font-medium">Rp {{ number_format($booking->car->daily_rate, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rental Details -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Rental Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="font-medium text-gray-900 mb-3">Dates & Duration</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Start Date:</span>
                                        <span class="font-medium">{{ $booking->start_date->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">End Date:</span>
                                        <span class="font-medium">{{ $booking->end_date->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Duration:</span>
                                        <span class="font-medium">{{ $booking->getDurationInDays() }} day(s)</span>
                                    </div>
                                    @if($booking->actual_return_date)
                                        <div class="flex justify-between">
                                            <span class="text-gray-500">Actual Return:</span>
                                            <span class="font-medium">{{ $booking->actual_return_date->format('M d, Y H:i') }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900 mb-3">Locations & Services</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Pickup:</span>
                                        <span class="font-medium">{{ $booking->pickup_location }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Return:</span>
                                        <span class="font-medium">{{ $booking->return_location }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Driver:</span>
                                        <span class="font-medium">{{ $booking->with_driver ? 'Yes' : 'No' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Out of Town:</span>
                                        <span class="font-medium">{{ $booking->is_out_of_town ? 'Yes' : 'No' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($booking->notes)
                        <!-- Notes -->
                        <div class="bg-white border border-gray-200 rounded-lg p-6">
                            <h2 class="text-lg font-semibold text-gray-900 mb-4">Notes</h2>
                            <p class="text-gray-700">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Pricing Breakdown -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pricing Breakdown</h2>
                        <div class="space-y-3 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Base Amount:</span>
                                <span class="font-medium">Rp {{ number_format($booking->base_amount, 0, ',', '.') }}</span>
                            </div>
                            @if($booking->driver_fee > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Driver Fee:</span>
                                    <span class="font-medium">Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @if($booking->out_of_town_fee > 0)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Out of Town Fee:</span>
                                    <span class="font-medium">Rp {{ number_format($booking->out_of_town_fee, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @if($booking->member_discount > 0)
                                <div class="flex justify-between text-green-600">
                                    <span>Member Discount:</span>
                                    <span class="font-medium">-Rp {{ number_format($booking->member_discount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            @if($booking->late_penalty > 0)
                                <div class="flex justify-between text-red-600">
                                    <span>Late Penalty:</span>
                                    <span class="font-medium">Rp {{ number_format($booking->late_penalty, 0, ',', '.') }}</span>
                                </div>
                            @endif
                            <hr class="my-3">
                            <div class="flex justify-between text-lg font-semibold">
                                <span>Total Amount:</span>
                                <span>Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                            </div>
                            @if($booking->deposit_amount > 0)
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Deposit:</span>
                                    <span>Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Actions</h2>
                        <div class="space-y-3">
                            @if($booking->canBeModified())
                                <a href="{{ route('customer.bookings.edit', $booking) }}" 
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-blue-300 rounded-md shadow-sm text-sm font-medium text-blue-700 bg-blue-50 hover:bg-blue-100">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Modify Booking
                                </a>
                            @endif
                            
                            @if($booking->canBeCancelled())
                                <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" 
                                      onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="cancellation_reason" value="Cancelled by customer">
                                    <button type="submit" 
                                            class="w-full inline-flex justify-center items-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-red-50 hover:bg-red-100">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                        </svg>
                                        Cancel Booking
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('customer.support') }}" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Contact Support
                            </a>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Need Help?</h3>
                        <p class="text-sm text-blue-700 mb-4">
                            Contact our customer service team for assistance with your booking.
                        </p>
                        <div class="space-y-2 text-sm">
                            <div class="flex items-center text-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                <span>+62 123 456 7890</span>
                            </div>
                            <div class="flex items-center text-blue-700">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                <span>support@anugerahrentcar.com</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>