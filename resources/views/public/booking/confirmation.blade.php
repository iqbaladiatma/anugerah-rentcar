<x-public-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success Header -->
            <div class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-4">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Booking Confirmed!</h1>
                <p class="text-lg text-gray-600">Your reservation has been successfully created</p>
                <p class="text-sm text-gray-500 mt-2">Booking Number: <span class="font-mono font-bold text-accent-600">{{ $booking->booking_number }}</span></p>
            </div>

            <!-- Booking Details Card -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="px-6 py-4 bg-accent-500 text-white">
                    <h2 class="text-xl font-semibold">Booking Details</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Vehicle Information -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Vehicle Information</h3>
                            <div class="border rounded-lg p-4">
                                <div class="flex items-center space-x-4">
                                    @if($booking->car->photo_front)
                                        <img src="{{ asset('storage/' . $booking->car->photo_front) }}" 
                                             alt="{{ $booking->car->brand }} {{ $booking->car->model }}"
                                             class="w-20 h-16 object-cover rounded">
                                    @else
                                        <div class="w-20 h-16 bg-gray-200 rounded flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                            </svg>
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-medium text-gray-900">{{ $booking->car->brand }} {{ $booking->car->model }}</h4>
                                        <p class="text-sm text-gray-500">{{ $booking->car->year }} • {{ $booking->car->color }} • {{ $booking->car->license_plate }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Details -->
                            <div class="mt-6">
                                <h4 class="font-medium text-gray-900 mb-3">Rental Details</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pickup Date:</span>
                                        <span class="font-medium">{{ $booking->start_date->format('M d, Y g:i A') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Return Date:</span>
                                        <span class="font-medium">{{ $booking->end_date->format('M d, Y g:i A') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Duration:</span>
                                        <span class="font-medium">{{ $booking->getDurationInDays() }} day(s)</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pickup Location:</span>
                                        <span class="text-right">{{ $booking->pickup_location }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Return Location:</span>
                                        <span class="text-right">{{ $booking->return_location }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">With Driver:</span>
                                        <span class="font-medium">{{ $booking->with_driver ? 'Yes' : 'No' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Out of Town:</span>
                                        <span class="font-medium">{{ $booking->is_out_of_town ? 'Yes' : 'No' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Customer & Pricing -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h3>
                            <div class="border rounded-lg p-4 mb-6">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Name:</span>
                                        <span class="font-medium">{{ $booking->customer->name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Email:</span>
                                        <span class="font-medium">{{ $booking->customer->email }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-medium">{{ $booking->customer->phone }}</span>
                                    </div>
                                    @if($booking->customer->is_member)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Status:</span>
                                            <span class="text-green-600 font-medium">Premium Member</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Pricing Summary -->
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pricing Summary</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>Vehicle Rental</span>
                                        <span>Rp {{ number_format($booking->base_amount, 0, ',', '.') }}</span>
                                    </div>
                                    @if($booking->driver_fee > 0)
                                        <div class="flex justify-between">
                                            <span>Driver Fee</span>
                                            <span>Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if($booking->out_of_town_fee > 0)
                                        <div class="flex justify-between">
                                            <span>Out of Town Fee</span>
                                            <span>Rp {{ number_format($booking->out_of_town_fee, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if($booking->member_discount > 0)
                                        <div class="flex justify-between text-green-600">
                                            <span>Member Discount</span>
                                            <span>-Rp {{ number_format($booking->member_discount, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    <div class="border-t pt-2">
                                        <div class="flex justify-between font-bold text-lg">
                                            <span>Total Amount</span>
                                            <span class="text-accent-600">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                                            <span>Deposit Required</span>
                                            <span>Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($booking->notes)
                        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                            <h4 class="font-medium text-gray-900 mb-2">Additional Notes</h4>
                            <p class="text-sm text-gray-600">{{ $booking->notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Instructions -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="px-6 py-4 bg-yellow-500 text-white">
                    <h2 class="text-xl font-semibold">Payment Instructions</h2>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Bank Transfer -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">Bank Transfer</h3>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-600">Bank:</span>
                                    <span class="font-medium ml-2">Bank Central Asia (BCA)</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Account Number:</span>
                                    <span class="font-mono font-medium ml-2">1234567890</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Account Name:</span>
                                    <span class="font-medium ml-2">PT Anugerah Rent Car</span>
                                </div>
                                <div class="mt-3 p-2 bg-yellow-50 rounded">
                                    <p class="text-xs text-yellow-800">
                                        <strong>Amount to Transfer:</strong> Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Cash Payment -->
                        <div class="border rounded-lg p-4">
                            <h3 class="font-semibold text-gray-900 mb-3">Cash Payment</h3>
                            <div class="space-y-2 text-sm">
                                <div>
                                    <span class="text-gray-600">Location:</span>
                                    <span class="font-medium ml-2">Office - Jl. Raya Utama No. 123</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Hours:</span>
                                    <span class="font-medium ml-2">Mon-Fri: 8AM-6PM, Sat: 8AM-4PM</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-medium ml-2">+62 123 456 7890</span>
                                </div>
                                <div class="mt-3 p-2 bg-accent-50 rounded">
                                    <p class="text-xs text-accent-800">
                                        <strong>Deposit Amount:</strong> Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-accent-50 border border-accent-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-accent-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-accent-800">
                                <p class="font-medium">Important Payment Information</p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Deposit payment is required to confirm your booking</li>
                                    <li>Remaining balance can be paid upon vehicle pickup</li>
                                    <li>Please bring payment confirmation and valid ID for pickup</li>
                                    <li>Booking will be automatically cancelled if deposit is not received within 24 hours</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                <div class="px-6 py-4 bg-green-600 text-white">
                    <h2 class="text-xl font-semibold">Next Steps</h2>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-green-600 font-bold text-sm">1</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Complete Payment</h3>
                                <p class="text-sm text-gray-600">Transfer the deposit amount or visit our office to pay in cash</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-green-600 font-bold text-sm">2</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Receive Confirmation</h3>
                                <p class="text-sm text-gray-600">We'll send you a confirmation email once payment is verified</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-8 h-8 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <span class="text-green-600 font-bold text-sm">3</span>
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">Vehicle Pickup</h3>
                                <p class="text-sm text-gray-600">Arrive at the pickup location with your ID, driving license, and payment confirmation</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('customer.bookings') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    View My Bookings
                </a>
                
                <a href="{{ route('vehicles.catalog') }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Browse More Vehicles
                </a>
            </div>

            <!-- Contact Support -->
            <div class="mt-8 text-center">
                <p class="text-sm text-gray-600">
                    Need help? Contact our support team at 
                    <a href="tel:+621234567890" class="text-accent-600 hover:text-accent-500 font-medium">+62 123 456 7890</a>
                    or 
                    <a href="mailto:support@anugerahrentcar.com" class="text-accent-600 hover:text-accent-500 font-medium">support@anugerahrentcar.com</a>
                </p>
            </div>
        </div>
    </div>
</x-public-layout>