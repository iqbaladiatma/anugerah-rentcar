<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-base sm:text-lg lg:text-xl text-gray-800 leading-tight">
                {{ __('Buat Pemesanan Baru') }}
            </h2>
            <a href="{{ route('admin.bookings.index') }}" 
               class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                <svg class="h-3 w-3 sm:h-4 sm:w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="hidden sm:inline">Kembali ke Pemesanan</span>
                <span class="sm:hidden">Kembali</span>
            </a>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <form action="{{ route('admin.bookings.store') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf
                
                <!-- Booking Calculator Component -->
                <livewire:admin.booking-calculator :preselected="$preselected" />

                <!-- Form Submission -->
                <div class="bg-white shadow rounded-lg p-4 sm:p-6">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-xs sm:text-sm text-gray-600">
                            Mohon tinjau semua detail pemesanan dan harga sebelum membuat pemesanan.
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <a href="{{ route('admin.bookings.index') }}" 
                               class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 border border-gray-300 rounded-lg shadow-sm text-xs sm:text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center justify-center px-3 py-2 sm:px-4 sm:py-2 border border-transparent rounded-lg shadow-sm text-xs sm:text-sm font-medium text-white bg-accent-600 hover:bg-accent-700 transition-colors">
                                Buat Pemesanan
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
                alert('Harap isi semua detail pemesanan yang diperlukan dan pastikan harga telah dihitung.');
                return false;
            }
        });
    </script>
    @endpush
</x-admin-layout>