<x-public-layout>
    <div class="bg-white">
        <!-- Header -->
        <div class="bg-gray-50 border-b">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Modify Booking</h1>
                        <p class="mt-2 text-gray-600">Booking #{{ $booking->booking_number }}</p>
                    </div>
                    <a href="{{ route('customer.bookings.show', $booking) }}" 
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Back to Details
                    </a>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if(session('error'))
                <div class="mb-6 rounded-md bg-red-50 p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg">
                <!-- Current Booking Info -->
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-900">Current Booking Information</h2>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                        <div>
                            <p class="text-gray-500">Vehicle</p>
                            <p class="font-medium">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Current Dates</p>
                            <p class="font-medium">{{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Current Total</p>
                            <p class="font-medium">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Modification Form -->
                <form method="POST" action="{{ route('customer.bookings.update', $booking) }}" class="p-6">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Date Selection -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date & Time</label>
                                <input type="datetime-local" 
                                       name="start_date" 
                                       id="start_date" 
                                       value="{{ old('start_date', $booking->start_date->format('Y-m-d\TH:i')) }}" 
                                       required
                                       min="{{ now()->addDay()->format('Y-m-d\TH:i') }}"
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date & Time</label>
                                <input type="datetime-local" 
                                       name="end_date" 
                                       id="end_date" 
                                       value="{{ old('end_date', $booking->end_date->format('Y-m-d\TH:i')) }}" 
                                       required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Location Details -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="pickup_location" class="block text-sm font-medium text-gray-700">Pickup Location</label>
                                <input type="text" 
                                       name="pickup_location" 
                                       id="pickup_location" 
                                       value="{{ old('pickup_location', $booking->pickup_location) }}" 
                                       required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('pickup_location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="return_location" class="block text-sm font-medium text-gray-700">Return Location</label>
                                <input type="text" 
                                       name="return_location" 
                                       id="return_location" 
                                       value="{{ old('return_location', $booking->return_location) }}" 
                                       required
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                @error('return_location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Service Options -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="with_driver" 
                                           value="1" 
                                           {{ old('with_driver', $booking->with_driver) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Include Driver</span>
                                </label>
                                <p class="mt-1 text-xs text-gray-500">Additional fee: Rp {{ number_format($booking->car->driver_fee_per_day, 0, ',', '.') }}/day</p>
                            </div>

                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" 
                                           name="is_out_of_town" 
                                           value="1" 
                                           {{ old('is_out_of_town', $booking->is_out_of_town) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           onchange="toggleOutOfTownFee()">
                                    <span class="ml-2 text-sm text-gray-700">Out of Town Trip</span>
                                </label>
                            </div>
                        </div>

                        <!-- Out of Town Fee -->
                        <div id="out_of_town_fee_section" style="display: {{ old('is_out_of_town', $booking->is_out_of_town) ? 'block' : 'none' }}">
                            <label for="out_of_town_fee" class="block text-sm font-medium text-gray-700">Out of Town Fee</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">Rp</span>
                                </div>
                                <input type="number" 
                                       name="out_of_town_fee" 
                                       id="out_of_town_fee" 
                                       value="{{ old('out_of_town_fee', $booking->out_of_town_fee) }}" 
                                       min="0"
                                       step="1000"
                                       class="pl-12 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            @error('out_of_town_fee')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                            <textarea name="notes" 
                                      id="notes" 
                                      rows="3" 
                                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                      placeholder="Any special requests or notes...">{{ old('notes', $booking->notes) }}</textarea>
                            @error('notes')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Important Notice -->
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">Important Notice</h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Modifications can only be made at least 24 hours before the original start time.</li>
                                        <li>Price changes may apply based on new dates and services selected.</li>
                                        <li>Vehicle availability will be checked for the new dates.</li>
                                        <li>Any price difference will need to be settled before the rental period.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="mt-6 flex items-center justify-end space-x-3">
                        <a href="{{ route('customer.bookings.show', $booking) }}" 
                           class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Update Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleOutOfTownFee() {
            const checkbox = document.querySelector('input[name="is_out_of_town"]');
            const feeSection = document.getElementById('out_of_town_fee_section');
            
            if (checkbox.checked) {
                feeSection.style.display = 'block';
            } else {
                feeSection.style.display = 'none';
                document.getElementById('out_of_town_fee').value = '';
            }
        }

        // Ensure end date is after start date
        document.getElementById('start_date').addEventListener('change', function() {
            const startDate = new Date(this.value);
            const endDateInput = document.getElementById('end_date');
            const minEndDate = new Date(startDate.getTime() + 24 * 60 * 60 * 1000); // Add 1 day
            
            endDateInput.min = minEndDate.toISOString().slice(0, 16);
            
            if (new Date(endDateInput.value) <= startDate) {
                endDateInput.value = minEndDate.toISOString().slice(0, 16);
            }
        });
    </script>
</x-public-layout>