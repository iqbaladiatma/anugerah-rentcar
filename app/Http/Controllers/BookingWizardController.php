<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Booking;
use App\Services\BookingCalculatorService;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingWizardController extends Controller
{
    public function __construct(
        private BookingCalculatorService $bookingCalculator,
        private AvailabilityService $availabilityService
    ) {}

    /**
     * Start the booking wizard process.
     */
    public function start(Request $request): View
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Verify availability
        $availability = $this->availabilityService->checkAvailability($car->id, $startDate, $endDate);
        if (!$availability['is_available']) {
            return redirect()->route('vehicles.show', $car)
                ->with('error', 'Vehicle is not available for the selected dates.');
        }

        // Calculate pricing
        $duration = $startDate->diffInDays($endDate) + 1;
        $pricing = $this->bookingCalculator->calculateBookingPrice([
            'car_id' => $car->id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'with_driver' => false,
            'is_out_of_town' => false,
            'out_of_town_fee' => 0,
        ]);

        // Store booking data in session
        session([
            'booking_wizard' => [
                'car_id' => $car->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'duration' => $duration,
                'pricing' => $pricing,
                'step' => 1,
            ]
        ]);

        return view('public.booking.wizard', compact('car', 'startDate', 'endDate', 'duration', 'pricing'));
    }

    /**
     * Complete the booking process.
     */
    public function complete(Request $request)
    {
        $wizardData = session('booking_wizard');
        if (!$wizardData) {
            return redirect()->route('vehicles.catalog')
                ->with('error', 'Booking session expired. Please start again.');
        }

        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'with_driver' => 'boolean',
            'is_out_of_town' => 'boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $car = Car::findOrFail($wizardData['car_id']);
        $customer = Customer::findOrFail($request->customer_id);

        // Check if customer is blacklisted
        if ($customer->is_blacklisted) {
            return back()->with('error', 'Unable to process booking. Please contact customer service.');
        }

        // Final availability check
        $startDate = Carbon::parse($wizardData['start_date']);
        $endDate = Carbon::parse($wizardData['end_date']);
        $availability = $this->availabilityService->checkAvailability($car->id, $startDate, $endDate);
        
        if (!$availability['is_available']) {
            return back()->with('error', 'Vehicle is no longer available for the selected dates.');
        }

        // Recalculate pricing with customer discount
        $pricing = $this->bookingCalculator->calculateBookingPrice([
            'car_id' => $car->id,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'with_driver' => $request->boolean('with_driver'),
            'is_out_of_town' => $request->boolean('is_out_of_town'),
            'out_of_town_fee' => $request->is_out_of_town ? ($request->out_of_town_fee ?? 0) : 0,
            'customer_id' => $customer->id,
        ]);

        // Create booking
        $booking = Booking::create([
            'booking_number' => Booking::generateBookingNumber(),
            'customer_id' => $customer->id,
            'car_id' => $car->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'pickup_location' => $request->pickup_location,
            'return_location' => $request->return_location,
            'with_driver' => $request->boolean('with_driver'),
            'is_out_of_town' => $request->boolean('is_out_of_town'),
            'out_of_town_fee' => $pricing['out_of_town_fee'] ?? 0,
            'base_amount' => $pricing['base_amount'] ?? 0,
            'driver_fee' => $pricing['driver_fee'] ?? 0,
            'member_discount' => $pricing['member_discount'] ?? 0,
            'total_amount' => $pricing['total_amount'] ?? 0,
            'deposit_amount' => $pricing['deposit_amount'] ?? 0,
            'payment_status' => Booking::PAYMENT_PENDING,
            'booking_status' => Booking::STATUS_PENDING,
            'notes' => $request->notes,
        ]);

        // Clear wizard session
        session()->forget('booking_wizard');

        return redirect()->route('booking.confirmation', $booking)
            ->with('success', 'Booking created successfully! Please complete payment to confirm your reservation.');
    }

    /**
     * Show booking confirmation page.
     */
    public function confirmation(Booking $booking): View
    {
        return view('public.booking.confirmation', compact('booking'));
    }
}