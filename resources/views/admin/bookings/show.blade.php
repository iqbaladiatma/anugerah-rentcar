<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Booking Details - {{ $booking->booking_number }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Created on {{ $booking->created_at->format('F j, Y \a\t g:i A') }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                @if($booking->canBeModified())
                    <a href="{{ route('admin.bookings.edit', $booking) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none focus:ring ring-yellow-300 transition ease-in-out duration-150">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Booking
                    </a>
                @endif
                <a href="{{ route('admin.bookings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring ring-gray-300 transition ease-in-out duration-150">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Bookings
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Status and Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->booking_status === 'confirmed') bg-blue-100 text-blue-800
                                @elseif($booking->booking_status === 'active') bg-green-100 text-green-800
                                @elseif($booking->booking_status === 'completed') bg-gray-100 text-gray-800
                                @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($booking->booking_status) }}
                            </span>
                        </div>
                        <div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($booking->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->payment_status === 'partial') bg-orange-100 text-orange-800
                                @elseif($booking->payment_status === 'paid') bg-green-100 text-green-800
                                @elseif($booking->payment_status === 'refunded') bg-purple-100 text-purple-800
                                @endif">
                                Payment: {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                        @if($booking->isOverdue())
                            <div>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    OVERDUE
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        @if($booking->booking_status === 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Confirm Booking
                                </button>
                            </form>
                        @endif

                        @if($booking->booking_status === 'confirmed')
                            <form action="{{ route('admin.bookings.activate', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Check Out Vehicle
                                </button>
                            </form>
                        @endif

                        @if($booking->booking_status === 'active')
                            <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="actual_return_date" value="{{ now() }}">
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    Check In Vehicle
                                </button>
                            </form>
                        @endif

                        @if($booking->canBeCancelled())
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Are you sure you want to cancel this booking?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Cancel Booking
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Booking Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Booking Information</h3>
                    
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Booking Number</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->booking_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Duration</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->getDurationInDays() }} days ({{ $booking->getDurationInHours() }} hours)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Start Date & Time</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->start_date->format('F j, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">End Date & Time</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->end_date->format('F j, Y \a\t g:i A') }}</dd>
                        </div>
                        @if($booking->actual_return_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Actual Return Date</dt>
                                <dd class="text-sm text-gray-900">{{ $booking->actual_return_date->format('F j, Y \a\t g:i A') }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Pickup Location</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->pickup_location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Return Location</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->return_location }}</dd>
                        </div>
                        @if($booking->with_driver)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Driver</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($booking->driver)
                                        {{ $booking->driver->name }} ({{ $booking->driver->phone }})
                                    @else
                                        Driver requested (not assigned)
                                    @endif
                                </dd>
                            </div>
                        @endif
                        @if($booking->is_out_of_town)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Out of Town Fee</dt>
                                <dd class="text-sm text-gray-900">Rp {{ number_format($booking->out_of_town_fee, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                        @if($booking->notes)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Notes</dt>
                                <dd class="text-sm text-gray-900">{{ $booking->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Customer Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex-1">
                            <h4 class="text-base font-medium text-gray-900">{{ $booking->customer->name }}</h4>
                            <p class="text-sm text-gray-500">{{ $booking->customer->phone }}</p>
                            @if($booking->customer->email)
                                <p class="text-sm text-gray-500">{{ $booking->customer->email }}</p>
                            @endif
                        </div>
                        @if($booking->customer->is_member)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Member
                            </span>
                        @endif
                    </div>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">NIK</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->customer->nik }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->customer->address }}</dd>
                        </div>
                        @if($booking->customer->is_member)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Member Discount</dt>
                                <dd class="text-sm text-gray-900">{{ $booking->customer->member_discount ?? 10 }}%</dd>
                            </div>
                        @endif
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('admin.customers.show', $booking->customer) }}" 
                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View Customer Profile →
                        </a>
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Information</h3>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex-1">
                            <h4 class="text-base font-medium text-gray-900">{{ $booking->car->license_plate }}</h4>
                            <p class="text-sm text-gray-500">{{ $booking->car->brand }} {{ $booking->car->model }} ({{ $booking->car->year }})</p>
                            <p class="text-sm text-gray-500">{{ $booking->car->color }}</p>
                        </div>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            @if($booking->car->status === 'available') bg-green-100 text-green-800
                            @elseif($booking->car->status === 'rented') bg-blue-100 text-blue-800
                            @elseif($booking->car->status === 'maintenance') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($booking->car->status) }}
                        </span>
                    </div>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">STNK Number</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->car->stnk_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Daily Rate</dt>
                            <dd class="text-sm text-gray-900">Rp {{ number_format($booking->car->daily_rate, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Weekly Rate</dt>
                            <dd class="text-sm text-gray-900">Rp {{ number_format($booking->car->weekly_rate, 0, ',', '.') }}</dd>
                        </div>
                        @if($booking->with_driver)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Driver Fee per Day</dt>
                                <dd class="text-sm text-gray-900">Rp {{ number_format($booking->car->driver_fee_per_day, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                    </dl>

                    <div class="mt-4">
                        <a href="{{ route('admin.vehicles.show', $booking->car) }}" 
                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            View Vehicle Details →
                        </a>
                    </div>
                </div>

                <!-- Pricing Breakdown -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing Breakdown</h3>
                    
                    <div class="space-y-3">
                        @if(!empty($pricingBreakdown))
                            @foreach($pricingBreakdown as $item)
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item['description'] }}</div>
                                        @if($item['quantity'] > 1)
                                            <div class="text-xs text-gray-500">
                                                {{ $item['quantity'] }} × Rp {{ number_format($item['rate'], 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-sm font-medium {{ isset($item['is_discount']) ? 'text-green-600' : 'text-gray-900' }}">
                                        @if(isset($item['is_discount']))
                                            -Rp {{ number_format($booking->member_discount, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Base Amount -->
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <div class="text-sm font-medium text-gray-900">Base Amount</div>
                            <div class="text-sm font-medium text-gray-900">
                                Rp {{ number_format($booking->base_amount, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Driver Fee -->
                        @if($booking->driver_fee > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-gray-900">Driver Fee</div>
                                <div class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Out of Town Fee -->
                        @if($booking->out_of_town_fee > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-gray-900">Out of Town Fee</div>
                                <div class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($booking->out_of_town_fee, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Member Discount -->
                        @if($booking->member_discount > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-green-600">Member Discount</div>
                                <div class="text-sm font-medium text-green-600">
                                    -Rp {{ number_format($booking->member_discount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Late Penalty -->
                        @if($booking->late_penalty > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-red-600">Late Penalty</div>
                                <div class="text-sm font-medium text-red-600">
                                    Rp {{ number_format($booking->late_penalty, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Total Amount -->
                        <div class="flex justify-between items-center py-3 border-t-2 border-gray-300">
                            <div class="text-lg font-bold text-gray-900">Total Amount</div>
                            <div class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Deposit -->
                        <div class="bg-blue-50 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-medium text-blue-900">Deposit Amount</div>
                                <div class="text-sm font-bold text-blue-900">
                                    Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-medium text-blue-900">Remaining Amount</div>
                                <div class="text-sm font-bold text-blue-900">
                                    Rp {{ number_format($booking->total_amount - $booking->deposit_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Car Inspections -->
            @if($booking->carInspections->count() > 0)
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Vehicle Inspections</h3>
                    
                    <div class="space-y-4">
                        @foreach($booking->carInspections as $inspection)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-base font-medium text-gray-900">
                                        {{ ucfirst($inspection->inspection_type) }} Inspection
                                    </h4>
                                    <span class="text-sm text-gray-500">
                                        {{ $inspection->created_at->format('M j, Y \a\t g:i A') }}
                                    </span>
                                </div>
                                
                                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <dt class="font-medium text-gray-500">Fuel Level</dt>
                                        <dd class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $inspection->fuel_level)) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Odometer</dt>
                                        <dd class="text-gray-900">{{ number_format($inspection->odometer_reading) }} km</dd>
                                    </div>
                                    @if($inspection->notes)
                                        <div>
                                            <dt class="font-medium text-gray-500">Notes</dt>
                                            <dd class="text-gray-900">{{ $inspection->notes }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>