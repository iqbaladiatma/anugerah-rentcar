<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Booking') }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Bookings
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <!-- Booking Calculator Component -->
                <livewire:admin.booking-calculator :preselected="$preselected" />

                <!-- Form Submission -->
                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Please review all booking details and pricing before creating the booking.
                        </div>
                        <div class="flex space-x-3">
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Booking
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        // Sync Livewire component data with form fields
        document.addEventListener('livewire:load', function () {
            Livewire.on('pricingCalculated', function (data) {
                // Update hidden form fields with calculated values
                updateHiddenField('customer_id', data.customer_id);
                updateHiddenField('car_id', data.car_id);
                updateHiddenField('driver_id', data.driver_id);
                updateHiddenField('start_date', data.start_date);
                updateHiddenField('end_date', data.end_date);
                updateHiddenField('pickup_location', data.pickup_location);
                updateHiddenField('return_location', data.return_location);
                updateHiddenField('with_driver', data.with_driver);
                updateHiddenField('is_out_of_town', data.is_out_of_town);
                updateHiddenField('out_of_town_fee', data.out_of_town_fee);
                updateHiddenField('notes', data.notes);
            });
        });

        function updateHiddenField(name, value) {
            let field = document.querySelector(`input[name="${name}"]`);
            if (!field) {
                field = document.createElement('input');
                field.type = 'hidden';
                field.name = name;
                document.querySelector('form').appendChild(field);
            }
            field.value = value || '';
        }

        // Form validation before submission
        document.querySelector('form').addEventListener('submit', function(e) {
            const requiredFields = ['customer_id', 'car_id', 'start_date', 'end_date', 'pickup_location', 'return_location'];
            let hasErrors = false;

            requiredFields.forEach(function(fieldName) {
                const field = document.querySelector(`input[name="${fieldName}"]`);
                if (!field || !field.value.trim()) {
                    hasErrors = true;
                }
            });

            if (hasErrors) {
                e.preventDefault();
                alert('Please fill in all required booking details and ensure pricing is calculated.');
                return false;
            }
        });
    </script>
    @endpush
</x-admin-layout>