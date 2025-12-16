<x-public-layout>
    <div class="bg-gray-50 min-h-screen py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Complete Your Booking</h1>
                <p class="text-lg text-gray-600">Follow the steps below to secure your vehicle reservation</p>
            </div>

            <!-- Booking Wizard Component -->
            @livewire('public.booking-wizard', [
                'carId' => $car->id,
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d')
            ])
        </div>
    </div>

    @push('scripts')
    <script>
        // Add any additional JavaScript for the booking wizard
        document.addEventListener('livewire:load', function () {
            // Handle file upload progress
            Livewire.on('fileUploadProgress', (progress) => {
                console.log('Upload progress:', progress);
            });

            // Handle booking completion
            Livewire.on('bookingCompleted', (bookingId) => {
                console.log('Booking completed:', bookingId);
            });
        });
    </script>
    @endpush
</x-public-layout>