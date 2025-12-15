@extends('layouts.admin')

@section('title', 'Vehicle Check-Out')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Vehicle Check-Out</h1>
                <p class="text-gray-600 mt-1">Process vehicle delivery for booking {{ $booking->booking_number }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.bookings.show', $booking) }}" 
                   class="bg-gray-500 text-white px-4 py-2 rounded-md hover:bg-gray-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Booking
                </a>
            </div>
        </div>
    </div>

    <!-- Checkout Form Component -->
    <livewire:admin.vehicle-checkout-form :booking="$booking" />
</div>
@endsection

@push('styles')
<style>
    .signature-canvas {
        border: 2px dashed #d1d5db;
        border-radius: 0.5rem;
        background-color: #ffffff;
    }
    
    .signature-canvas:hover {
        border-color: #9ca3af;
    }
    
    .damage-report {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-left: 4px solid #f59e0b;
    }
    
    .inspection-item {
        transition: all 0.2s ease-in-out;
    }
    
    .inspection-item:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script>
    // Additional JavaScript for checkout form enhancements
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-save form data to localStorage
        const form = document.querySelector('form');
        if (form) {
            const formData = new FormData(form);
            const savedData = localStorage.getItem('checkout_form_{{ $booking->id }}');
            
            if (savedData) {
                try {
                    const data = JSON.parse(savedData);
                    // Restore form data if needed
                } catch (e) {
                    console.log('Could not restore form data');
                }
            }
            
            // Save form data on change
            form.addEventListener('change', function() {
                const formData = new FormData(form);
                const data = Object.fromEntries(formData);
                localStorage.setItem('checkout_form_{{ $booking->id }}', JSON.stringify(data));
            });
        }
        
        // Clear saved data when form is submitted successfully
        window.addEventListener('beforeunload', function() {
            if (document.querySelector('.alert-success')) {
                localStorage.removeItem('checkout_form_{{ $booking->id }}');
            }
        });
    });
</script>
@endpush