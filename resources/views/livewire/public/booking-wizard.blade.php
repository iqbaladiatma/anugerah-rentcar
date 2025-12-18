<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Progress Indicator -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                @for ($i = 1; $i <= $totalSteps; $i++)
                    <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                        <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 
                            {{ $currentStep >= $i ? 'bg-accent-500 border-accent-500 text-white' : 'border-gray-300 text-gray-500' }}">
                            @if ($currentStep > $i)
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            @else
                                {{ $i }}
                            @endif
                        </div>
                        @if ($i < $totalSteps)
                            <div class="flex-1 h-0.5 mx-4 {{ $currentStep > $i ? 'bg-accent-500' : 'bg-gray-300' }}"></div>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="flex justify-between mt-2 text-sm">
                <span class="{{ $currentStep >= 1 ? 'text-accent-600 font-medium' : 'text-gray-500' }}">Vehicle Selection</span>
                <span class="{{ $currentStep >= 2 ? 'text-accent-600 font-medium' : 'text-gray-500' }}">Pricing Details</span>
                <span class="{{ $currentStep >= 3 ? 'text-accent-600 font-medium' : 'text-gray-500' }}">Customer Info</span>
                <span class="{{ $currentStep >= 4 ? 'text-accent-600 font-medium' : 'text-gray-500' }}">Documents</span>
                <span class="{{ $currentStep >= 5 ? 'text-accent-600 font-medium' : 'text-gray-500' }}">Confirmation</span>
            </div>
        </div>

        <!-- Error Messages -->
        @if (!empty($errors))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex">
                    <svg class="w-5 h-5 text-red-400 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <div>
                        <h3 class="text-sm font-medium text-red-800">Please correct the following errors:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Step Content -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            @if ($currentStep === 1)
                <!-- Step 1: Vehicle Selection -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Select Your Vehicle & Dates</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Date Selection -->
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Rental Period</label>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Pickup Date</label>
                                        <input type="date" wire:model.live="startDate" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               min="{{ date('Y-m-d') }}">
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Return Date</label>
                                        <input type="date" wire:model.live="endDate" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               min="{{ $startDate }}">
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pickup Location</label>
                                <input type="text" wire:model="pickupLocation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                       placeholder="Enter pickup location">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Return Location</label>
                                <input type="text" wire:model="returnLocation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                       placeholder="Enter return location">
                            </div>

                            <div class="space-y-3">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="withDriver" 
                                           class="w-4 h-4 text-accent-600 border-gray-300 rounded focus:ring-accent-500">
                                    <span class="ml-2 text-sm text-gray-700">With Driver</span>
                                </label>

                                <label class="flex items-center">
                                    <input type="checkbox" wire:model.live="isOutOfTown" 
                                           class="w-4 h-4 text-accent-600 border-gray-300 rounded focus:ring-accent-500">
                                    <span class="ml-2 text-sm text-gray-700">Out of Town Trip</span>
                                </label>

                                @if ($isOutOfTown)
                                    <div class="ml-6">
                                        <label class="block text-xs text-gray-500 mb-1">Additional Fee</label>
                                        <input type="number" wire:model.live="outOfTownFee" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               placeholder="Enter additional fee" min="0">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Vehicle Selection -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-4">Available Vehicles</label>
                            <div class="space-y-4 max-h-96 overflow-y-auto">
                                @forelse ($availableCars as $availableCar)
                                    <div class="border rounded-lg p-4 cursor-pointer transition-all
                                        {{ $selectedCarId == $availableCar->id ? 'border-accent-500 bg-accent-50' : 'border-gray-200 hover:border-gray-300' }}"
                                         wire:click="$set('selectedCarId', {{ $availableCar->id }})">
                                        <div class="flex items-center space-x-4">
                                            @if ($availableCar->photo_front)
                                                <img src="{{ asset('storage/' . $availableCar->photo_front) }}" 
                                                     alt="{{ $availableCar->brand }} {{ $availableCar->model }}"
                                                     class="w-16 h-12 object-cover rounded">
                                            @else
                                                <div class="w-16 h-12 bg-gray-200 rounded flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1">
                                                <h4 class="font-medium text-gray-900">{{ $availableCar->brand }} {{ $availableCar->model }}</h4>
                                                <p class="text-sm text-gray-500">{{ $availableCar->year }} • {{ $availableCar->color }}</p>
                                                <p class="text-lg font-bold text-accent-600">Rp {{ number_format($availableCar->daily_rate, 0, ',', '.') }}/day</p>
                                            </div>
                                            @if ($selectedCarId == $availableCar->id)
                                                <svg class="w-5 h-5 text-accent-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6-4h6m2 5.291A7.962 7.962 0 0112 15c-2.34 0-4.29-1.175-5.5-2.709"/>
                                        </svg>
                                        <p>No vehicles available for selected dates</p>
                                        <p class="text-sm">Try different dates or check back later</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Navigation Buttons -->
            <div class="px-6 py-4 bg-gray-50 border-t flex justify-between">
                @if ($currentStep > 1)
                    <button type="button" wire:click="previousStep" 
                            class="px-4 py-2 text-gray-600 hover:text-gray-800 font-medium">
                        ← Previous
                    </button>
                @else
                    <div></div>
                @endif

                @if ($currentStep < $totalSteps)
                    <button type="button" wire:click="nextStep" 
                            class="px-6 py-2 bg-accent-500 text-white rounded-lg hover:bg-accent-600 transition-colors font-medium">
                        Next →
                    </button>
                @else
                    <button type="button" wire:click="createBooking" 
                            class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium">
                        Complete Booking
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>       
     @elseif ($currentStep === 2)
                <!-- Step 2: Pricing Details -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Pricing Details</h2>
                    
                    @if ($car && !empty($pricingData))
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            <!-- Selected Vehicle Info -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Selected Vehicle</h3>
                                <div class="border rounded-lg p-4">
                                    <div class="flex items-center space-x-4">
                                        @if ($car->photo_front)
                                            <img src="{{ asset('storage/' . $car->photo_front) }}" 
                                                 alt="{{ $car->brand }} {{ $car->model }}"
                                                 class="w-20 h-16 object-cover rounded">
                                        @endif
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $car->brand }} {{ $car->model }}</h4>
                                            <p class="text-sm text-gray-500">{{ $car->year }} • {{ $car->color }} • {{ $car->license_plate }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <h4 class="font-medium text-gray-900 mb-3">Rental Details</h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Pickup Date:</span>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Return Date:</span>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Duration:</span>
                                            <span class="font-medium">{{ $pricingData['duration_days'] ?? 0 }} days</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">With Driver:</span>
                                            <span class="font-medium">{{ $withDriver ? 'Yes' : 'No' }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Out of Town:</span>
                                            <span class="font-medium">{{ $isOutOfTown ? 'Yes' : 'No' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Breakdown -->
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Price Breakdown</h3>
                                <div class="bg-gray-50 rounded-lg p-4 space-y-3">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Vehicle Rental ({{ $pricingData['duration_days'] ?? 0 }} days)</span>
                                        <span class="font-medium">Rp {{ number_format($pricingData['base_amount'] ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    
                                    @if ($withDriver && ($pricingData['driver_fee'] ?? 0) > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Driver Fee ({{ $pricingData['duration_days'] ?? 0 }} days)</span>
                                            <span class="font-medium">Rp {{ number_format($pricingData['driver_fee'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    
                                    @if ($isOutOfTown && ($pricingData['out_of_town_fee'] ?? 0) > 0)
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Out of Town Fee</span>
                                            <span class="font-medium">Rp {{ number_format($pricingData['out_of_town_fee'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    
                                    @if (($pricingData['member_discount'] ?? 0) > 0)
                                        <div class="flex justify-between text-green-600">
                                            <span>Member Discount</span>
                                            <span class="font-medium">-Rp {{ number_format($pricingData['member_discount'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    
                                    <div class="border-t pt-3">
                                        <div class="flex justify-between text-lg font-bold">
                                            <span>Total Amount</span>
                                            <span class="text-accent-600">Rp {{ number_format($pricingData['total_amount'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                                            <span>Deposit Required</span>
                                            <span>Rp {{ number_format($pricingData['deposit_amount'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                                </div>

                                    <svg class="w-5 h-5 text-accent-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    <div class="text-sm text-accent-800">
                                            <p class="font-medium">Payment Information</p>
                                            <p class="mt-1">A deposit is required to secure your booking. The remaining balance can be paid upon vehicle pickup.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-accent-500 mx-auto mb-4"></div>
                            <p class="text-gray-600">Calculating pricing...</p>
                        </div>
                    @endif
                </div>

            @elseif ($currentStep === 3)
                <!-- Step 3: Customer Information -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Customer Information</h2>
                    
                    @if (!$customer)
                        <!-- Login/Register Toggle -->
                        <div class="mb-6">
                            <div class="flex rounded-lg bg-gray-100 p-1">
                                <button type="button" 
                                        wire:click="$set('isExistingCustomer', false)"
                                        class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-colors
                                            {{ !$isExistingCustomer ? 'bg-white text-accent-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    New Customer
                                </button>
                                <button type="button" 
                                        wire:click="$set('isExistingCustomer', true)"
                                        class="flex-1 py-2 px-4 rounded-md text-sm font-medium transition-colors
                                            {{ $isExistingCustomer ? 'bg-white text-accent-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
                                    Existing Customer
                                </button>
                            </div>
                        </div>

                        @if ($isExistingCustomer)
                            <!-- Login Form -->
                            <div class="max-w-md mx-auto">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" wire:model="customerEmail" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               placeholder="Enter your email">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                        <input type="password" wire:model="customerPassword" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500"
                                               placeholder="Enter your password">
                                    </div>
                                    <button type="button" wire:click="authenticateCustomer" 
                                            class="w-full bg-accent-500 text-white py-2 px-4 rounded-lg hover:bg-accent-600 transition-colors font-medium">
                                        Login & Continue
                                    </button>
                                </div>
                            </div>
                        @else
                            <!-- Registration Form -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                    <input type="text" wire:model="customerName" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your full name">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <input type="tel" wire:model="customerPhone" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your phone number">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="email" wire:model="customerEmail" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your email">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">NIK (16 digits)</label>
                                    <input type="text" wire:model="customerNik" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Enter your NIK" maxlength="16">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <textarea wire:model="customerAddress" rows="3"
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                              placeholder="Enter your complete address"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                    <input type="password" wire:model="customerPassword" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Create a password (min. 8 characters)">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                                    <input type="password" wire:model="customerPasswordConfirmation" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                           placeholder="Confirm your password">
                                </div>
                            </div>
                            
                            <div class="mt-6 text-center">
                                <button type="button" wire:click="registerCustomer" 
                                        class="bg-blue-600 text-white py-2 px-6 rounded-lg hover:bg-blue-700 transition-colors font-medium">
                                    Register & Continue
                                </button>
                            </div>
                        @endif
                    @else
                        <!-- Customer Info Display -->
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                <div>
                                    <h4 class="font-medium text-green-800">Customer Information Verified</h4>
                                    <p class="text-sm text-green-700">{{ $customer->name }} ({{ $customer->email }})</p>
                                    @if ($customer->is_member)
                                        <p class="text-sm text-green-700 font-medium">✓ Member - Discount Applied</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            @elseif ($currentStep === 4)
                <!-- Step 4: Document Upload -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Upload Required Documents</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- KTP Upload -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">KTP (Identity Card)</h3>
                            
                            @if ($customer && $customer->ktp_photo && !$ktpPhoto)
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-green-800 font-medium">KTP already uploaded</span>
                                    </div>
                                </div>
                            @else
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    @if ($ktpPhotoPreview)
                                        <div class="mb-4">
                                            <img src="{{ $ktpPhotoPreview }}" alt="KTP Preview" class="max-w-full h-48 mx-auto rounded">
                                            <button type="button" wire:click="removeKtpPhoto" 
                                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                Remove Photo
                                            </button>
                                        </div>
                                    @else
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="text-sm text-gray-600 mb-4">
                                            <label for="ktpPhoto" class="cursor-pointer">
                                                <span class="text-blue-600 hover:text-blue-500 font-medium">Click to upload</span>
                                                <span> or drag and drop</span>
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 10MB</p>
                                        </div>
                                        <input id="ktpPhoto" type="file" wire:model="ktpPhoto" accept="image/*" class="hidden">
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- SIM Upload -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">SIM (Driving License)</h3>
                            
                            @if ($customer && $customer->sim_photo && !$simPhoto)
                                <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="text-sm text-green-800 font-medium">SIM already uploaded</span>
                                    </div>
                                </div>
                            @else
                                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                                    @if ($simPhotoPreview)
                                        <div class="mb-4">
                                            <img src="{{ $simPhotoPreview }}" alt="SIM Preview" class="max-w-full h-48 mx-auto rounded">
                                            <button type="button" wire:click="removeSimPhoto" 
                                                    class="mt-2 text-sm text-red-600 hover:text-red-800">
                                                Remove Photo
                                            </button>
                                        </div>
                                    @else
                                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                        <div class="text-sm text-gray-600 mb-4">
                                            <label for="simPhoto" class="cursor-pointer">
                                                <span class="text-blue-600 hover:text-blue-500 font-medium">Click to upload</span>
                                                <span> or drag and drop</span>
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG up to 10MB</p>
                                        </div>
                                        <input id="simPhoto" type="file" wire:model="simPhoto" accept="image/*" class="hidden">
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <p class="font-medium">Document Requirements</p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Photos must be clear and readable</li>
                                    <li>Documents must be valid and not expired</li>
                                    <li>File size should not exceed 10MB</li>
                                    <li>Accepted formats: JPG, JPEG, PNG</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            @elseif ($currentStep === 5)
                <!-- Step 5: Confirmation & Payment -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Booking Confirmation</h2>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                        <!-- Booking Summary -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Booking Summary</h3>
                            
                            <!-- Vehicle Info -->
                            <div class="border rounded-lg p-4 mb-4">
                                <h4 class="font-medium text-gray-900 mb-2">Vehicle</h4>
                                <div class="flex items-center space-x-3">
                                    @if ($car && $car->photo_front)
                                        <img src="{{ asset('storage/' . $car->photo_front) }}" 
                                             alt="{{ $car->brand }} {{ $car->model }}"
                                             class="w-16 h-12 object-cover rounded">
                                    @endif
                                    <div>
                                        <p class="font-medium">{{ $car->brand ?? '' }} {{ $car->model ?? '' }}</p>
                                        <p class="text-sm text-gray-500">{{ $car->year ?? '' }} • {{ $car->color ?? '' }} • {{ $car->license_plate ?? '' }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Rental Details -->
                            <div class="border rounded-lg p-4 mb-4">
                                <h4 class="font-medium text-gray-900 mb-2">Rental Details</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pickup:</span>
                                        <span>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Return:</span>
                                        <span>{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Duration:</span>
                                        <span>{{ $pricingData['duration_days'] ?? 0 }} days</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pickup Location:</span>
                                        <span class="text-right">{{ $pickupLocation }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Return Location:</span>
                                        <span class="text-right">{{ $returnLocation }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Customer Info -->
                            @if ($customer)
                                <div class="border rounded-lg p-4">
                                    <h4 class="font-medium text-gray-900 mb-2">Customer Information</h4>
                                    <div class="space-y-1 text-sm">
                                        <p><span class="text-gray-600">Name:</span> {{ $customer->name }}</p>
                                        <p><span class="text-gray-600">Email:</span> {{ $customer->email }}</p>
                                        <p><span class="text-gray-600">Phone:</span> {{ $customer->phone }}</p>
                                        @if ($customer->is_member)
                                            <p class="text-green-600 font-medium">✓ Member Discount Applied</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Payment & Final Steps -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Information</h3>
                            
                            <!-- Price Summary -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span>Vehicle Rental</span>
                                        <span>Rp {{ number_format($pricingData['base_amount'] ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    @if ($withDriver && ($pricingData['driver_fee'] ?? 0) > 0)
                                        <div class="flex justify-between">
                                            <span>Driver Fee</span>
                                            <span>Rp {{ number_format($pricingData['driver_fee'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if ($isOutOfTown && ($pricingData['out_of_town_fee'] ?? 0) > 0)
                                        <div class="flex justify-between">
                                            <span>Out of Town Fee</span>
                                            <span>Rp {{ number_format($pricingData['out_of_town_fee'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    @if (($pricingData['member_discount'] ?? 0) > 0)
                                        <div class="flex justify-between text-green-600">
                                            <span>Member Discount</span>
                                            <span>-Rp {{ number_format($pricingData['member_discount'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    @endif
                                    <div class="border-t pt-2">
                                        <div class="flex justify-between font-bold text-lg">
                                            <span>Total Amount</span>
                                            <span class="text-blue-600">Rp {{ number_format($pricingData['total_amount'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-sm text-gray-600 mt-1">
                                            <span>Deposit Required</span>
                                            <span>Rp {{ number_format($pricingData['deposit_amount'] ?? 0, 0, ',', '.') }}</span>
                                        </div>
                                    </div>
                            </div>

                            <!-- Payment Method -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Metode Pembayaran</label>
                                <div class="space-y-3">
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all
                                        {{ $paymentMethod === 'bank_transfer' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:bg-gray-50' }}">
                                        <input type="radio" name="paymentMethod" wire:model="paymentMethod" value="bank_transfer" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900">Bank Transfer</p>
                                            <p class="text-sm text-gray-500">Transfer ke rekening bank</p>
                                        </div>
                                    </label>
                                    <label class="flex items-center p-3 border rounded-lg cursor-pointer transition-all
                                        {{ $paymentMethod === 'cash' ? 'border-blue-500 bg-blue-50' : 'border-gray-300 hover:bg-gray-50' }}">
                                        <input type="radio" name="paymentMethod" wire:model="paymentMethod" value="cash" 
                                               class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                        <div class="ml-3">
                                            <p class="font-medium text-gray-900">Cash Payment</p>
                                            <p class="text-sm text-gray-500">Bayar di lokasi pick up</p>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Additional Notes -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Additional Notes (Optional)</label>
                                <textarea wire:model="notes" rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                          placeholder="Any special requests or notes..."></textarea>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                                <div class="flex items-start">
                                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                    <div class="text-sm text-blue-800">
                                        <p class="font-medium">Important Information</p>
                                        <ul class="mt-1 list-disc list-inside space-y-1">
                                            <li>Booking confirmation will be sent to your email</li>
                                            <li>Vehicle pickup requires valid ID and driving license</li>
                                            <li>Deposit is refundable upon vehicle return in good condition</li>
                                            <li>Late return fees apply as per our policy</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>