<div class="space-y-6">
    <!-- Quick Filters and Actions -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <select wire:model="quick_filter" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach($this->getQuickFilterOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center space-x-3">
                @if($show_actions)
                    <div class="flex items-center space-x-2">
                        <select wire:model="bulk_action" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($this->getBulkActionOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                        <button wire:click="processBulkAction" type="button" 
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Apply
                        </button>
                    </div>
                @endif

                <a href="{{ route('admin.bookings.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    New Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Bookings Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left">
                                <input type="checkbox" wire:model="select_all" 
                                       class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Booking Details
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Vehicle
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Dates
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Amount
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
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 {{ $this->isOverdue($booking) ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" wire:model="selected_bookings" value="{{ $booking->id }}" 
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $booking->booking_number }}</div>
                                            <div class="text-sm text-gray-500">Created {{ $booking->created_at->format('M j, Y') }}</div>
                                            @if($booking->with_driver && $booking->driver)
                                                <div class="text-xs text-blue-600">Driver: {{ $booking->driver->name }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->customer->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->car->license_plate }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        <div>Start: {{ $booking->start_date->format('M j, Y H:i') }}</div>
                                        <div>End: {{ $booking->end_date->format('M j, Y H:i') }}</div>
                                    </div>
                                    @if($booking->actual_return_date)
                                        <div class="text-xs text-gray-500">
                                            Returned: {{ $booking->actual_return_date->format('M j, Y H:i') }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $this->formatCurrency($booking->total_amount) }}</div>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getPaymentStatusBadgeClass($booking->payment_status) }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($booking->booking_status) }}">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                    @if($this->isOverdue($booking))
                                        <div class="text-xs text-red-600 mt-1 font-medium">OVERDUE</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end space-x-2">
                                        <!-- View Button -->
                                        <a href="{{ route('admin.bookings.show', $booking) }}" 
                                           class="text-indigo-600 hover:text-indigo-900">
                                            View
                                        </a>

                                        <!-- Status-specific Actions -->
                                        @if($booking->booking_status === 'pending')
                                            <button wire:click="confirmBooking({{ $booking->id }})" 
                                                    class="text-green-600 hover:text-green-900">
                                                Confirm
                                            </button>
                                        @endif

                                        @if($booking->booking_status === 'confirmed')
                                            <button wire:click="activateBooking({{ $booking->id }})" 
                                                    class="text-blue-600 hover:text-blue-900">
                                                Check Out
                                            </button>
                                        @endif

                                        @if($booking->booking_status === 'active')
                                            <button wire:click="completeBooking({{ $booking->id }})" 
                                                    class="text-purple-600 hover:text-purple-900">
                                                Check In
                                            </button>
                                        @endif

                                        @if($booking->canBeCancelled())
                                            <button wire:click="cancelBooking({{ $booking->id }})" 
                                                    class="text-red-600 hover:text-red-900">
                                                Cancel
                                            </button>
                                        @endif

                                        @if($booking->canBeModified())
                                            <a href="{{ route('admin.bookings.edit', $booking) }}" 
                                               class="text-yellow-600 hover:text-yellow-900">
                                                Edit
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No bookings found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new booking.</p>
                <div class="mt-6">
                    <a href="{{ route('admin.bookings.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        New Booking
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Confirmation Modal -->
    @if($show_confirm_modal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100">
                        <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4">Confirm Booking</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Are you sure you want to confirm this booking? This will mark the vehicle as rented and the booking as confirmed.
                        </p>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button wire:click="processConfirmation" 
                                class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Confirm
                        </button>
                        <button wire:click="closeConfirmModal" 
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Cancellation Modal -->
    @if($show_cancel_modal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mt-4 text-center">Cancel Booking</h3>
                    <div class="mt-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700">Cancellation Reason (Optional)</label>
                        <textarea wire:model="cancellation_reason" id="cancellation_reason" rows="3" 
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                  placeholder="Enter reason for cancellation..."></textarea>
                    </div>
                    <div class="items-center px-4 py-3 text-center">
                        <button wire:click="processCancellation" 
                                class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                            Cancel Booking
                        </button>
                        <button wire:click="closeCancelModal" 
                                class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Keep Booking
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>