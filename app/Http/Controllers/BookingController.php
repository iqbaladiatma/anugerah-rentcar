<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\User;
use App\Services\BookingCalculatorService;
use App\Services\AvailabilityService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class BookingController extends Controller
{
    protected BookingCalculatorService $calculatorService;
    protected AvailabilityService $availabilityService;

    public function __construct(
        BookingCalculatorService $calculatorService,
        AvailabilityService $availabilityService
    ) {
        $this->calculatorService = $calculatorService;
        $this->availabilityService = $availabilityService;
    }

    /**
     * Display a listing of bookings.
     */
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'status' => 'nullable|string|in:pending,confirmed,active,completed,cancelled',
            'customer_id' => 'nullable|exists:customers,id',
            'car_id' => 'nullable|exists:cars,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'search' => 'nullable|string|max:255',
        ]);

        $query = Booking::with(['customer', 'car', 'driver'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (!empty($filters['status'])) {
            $query->where('booking_status', $filters['status']);
        }

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (!empty($filters['car_id'])) {
            $query->where('car_id', $filters['car_id']);
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('start_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('end_date', '<=', $filters['end_date']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('car', function ($carQuery) use ($search) {
                      $carQuery->where('license_plate', 'like', "%{$search}%")
                              ->orWhere('brand', 'like', "%{$search}%")
                              ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->paginate(15)->withQueryString();

        // Get summary statistics
        $statistics = [
            'total' => Booking::count(),
            'pending' => Booking::where('booking_status', Booking::STATUS_PENDING)->count(),
            'confirmed' => Booking::where('booking_status', Booking::STATUS_CONFIRMED)->count(),
            'active' => Booking::where('booking_status', Booking::STATUS_ACTIVE)->count(),
            'completed' => Booking::where('booking_status', Booking::STATUS_COMPLETED)->count(),
            'overdue' => Booking::overdue()->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'filters', 'statistics'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request): View
    {
        $customers = Customer::active()->orderBy('name')->get();
        $cars = Car::available()->orderBy('license_plate')->get();
        $drivers = User::drivers()->active()->orderBy('name')->get();

        // Pre-fill form if parameters are provided
        $preselected = $request->only(['customer_id', 'car_id', 'start_date', 'end_date']);

        return view('admin.bookings.create', compact('customers', 'cars', 'drivers', 'preselected'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'with_driver' => 'boolean',
            'is_out_of_town' => 'boolean',
            'out_of_town_fee' => 'nullable|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validate customer can make booking
        $customer = Customer::findOrFail($validated['customer_id']);
        if (!$customer->canMakeBooking()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Customer is blacklisted and cannot make bookings.');
        }

        // Validate car availability
        $car = Car::findOrFail($validated['car_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        if (!$this->availabilityService->isAvailable($car, $startDate, $endDate)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Selected vehicle is not available for the requested dates.');
        }

        // Validate driver if selected
        if (!empty($validated['driver_id'])) {
            $driver = User::findOrFail($validated['driver_id']);
            if (!$driver->isDriver() || !$driver->is_active) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Selected driver is not available.');
            }
            $validated['with_driver'] = true;
        }

        // Calculate pricing
        $pricingParams = [
            'car_id' => $validated['car_id'],
            'customer_id' => $validated['customer_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'with_driver' => $validated['with_driver'] ?? false,
            'is_out_of_town' => $validated['is_out_of_town'] ?? false,
            'out_of_town_fee' => $validated['out_of_town_fee'] ?? 0,
        ];

        $pricing = $this->calculatorService->calculateBookingPrice($pricingParams);

        // Set calculated values
        $validated['base_amount'] = $pricing['base_amount'];
        $validated['driver_fee'] = $pricing['driver_fee'];
        $validated['member_discount'] = $pricing['member_discount'];
        $validated['total_amount'] = $pricing['total_amount'];
        $validated['deposit_amount'] = $validated['deposit_amount'] ?? $pricing['deposit_amount'];
        $validated['payment_status'] = Booking::PAYMENT_PENDING;
        $validated['booking_status'] = Booking::STATUS_PENDING;
        $validated['out_of_town_fee'] = $validated['out_of_town_fee'] ?? 0;

        // Set defaults
        $validated['with_driver'] = $validated['with_driver'] ?? false;
        $validated['is_out_of_town'] = $validated['is_out_of_town'] ?? false;

        $booking = Booking::create($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified booking.
     */
    public function show($id): View
    {
        $booking = Booking::with(['customer', 'car', 'driver', 'carInspections'])->findOrFail($id);

        // Get pricing breakdown only if car and customer exist
        $pricingBreakdown = null;
        if ($booking->car && $booking->customer) {
            $pricingBreakdown = $this->calculatorService->getPriceBreakdown(
                $booking->car,
                $booking->getDurationInDays(),
                $booking->with_driver,
                $booking->customer
            );
        }

        return view('admin.bookings.show', compact('booking', 'pricingBreakdown'));
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking): View|RedirectResponse
    {
        if (!$booking->canBeModified()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'This booking cannot be modified.');
        }

        $customers = Customer::active()->orderBy('name')->get();
        $cars = Car::available()->orderBy('license_plate')->get();
        $drivers = User::drivers()->active()->orderBy('name')->get();

        return view('admin.bookings.edit', compact('booking', 'customers', 'cars', 'drivers'));
    }

    /**
     * Update the specified booking in storage.
     */
    public function update(Request $request, Booking $booking): RedirectResponse
    {
        if (!$booking->canBeModified()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'This booking cannot be modified.');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'with_driver' => 'boolean',
            'is_out_of_town' => 'boolean',
            'out_of_town_fee' => 'nullable|numeric|min:0',
            'deposit_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validate customer can make booking
        $customer = Customer::findOrFail($validated['customer_id']);
        if (!$customer->canMakeBooking()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Customer is blacklisted and cannot make bookings.');
        }

        // Validate car availability (excluding current booking)
        $car = Car::findOrFail($validated['car_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $conflicts = $this->availabilityService->getConflicts($car, $startDate, $endDate)
            ->where('id', '!=', $booking->id);

        if ($conflicts->isNotEmpty()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Selected vehicle is not available for the requested dates.');
        }

        // Validate driver if selected
        if (!empty($validated['driver_id'])) {
            $driver = User::findOrFail($validated['driver_id']);
            if (!$driver->isDriver() || !$driver->is_active) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Selected driver is not available.');
            }
            $validated['with_driver'] = true;
        }

        // Recalculate pricing
        $pricingParams = [
            'car_id' => $validated['car_id'],
            'customer_id' => $validated['customer_id'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'with_driver' => $validated['with_driver'] ?? false,
            'is_out_of_town' => $validated['is_out_of_town'] ?? false,
            'out_of_town_fee' => $validated['out_of_town_fee'] ?? 0,
        ];

        $pricing = $this->calculatorService->calculateBookingPrice($pricingParams);

        // Update calculated values
        $validated['base_amount'] = $pricing['base_amount'];
        $validated['driver_fee'] = $pricing['driver_fee'];
        $validated['member_discount'] = $pricing['member_discount'];
        $validated['total_amount'] = $pricing['total_amount'];
        $validated['out_of_town_fee'] = $validated['out_of_town_fee'] ?? 0;

        // Set defaults
        $validated['with_driver'] = $validated['with_driver'] ?? false;
        $validated['is_out_of_town'] = $validated['is_out_of_town'] ?? false;

        $booking->update($validated);

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified booking from storage.
     */
    public function destroy(Booking $booking): RedirectResponse
    {
        if (!$booking->canBeCancelled()) {
            return redirect()->route('admin.bookings.index')
                ->with('error', 'This booking cannot be deleted.');
        }

        $booking->cancel();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Confirm a pending booking.
     */
    public function confirm(Booking $booking): RedirectResponse
    {
        if ($booking->booking_status !== Booking::STATUS_PENDING) {
            return redirect()->back()
                ->with('error', 'Only pending bookings can be confirmed.');
        }

        // Validate availability again (excluding current booking)
        $conflicts = $this->availabilityService->getConflicts($booking->car, $booking->start_date, $booking->end_date)
            ->where('id', '!=', $booking->id);
        
        if ($conflicts->isNotEmpty()) {
            return redirect()->back()
                ->with('error', 'Vehicle is no longer available for the requested dates.');
        }

        $booking->confirm();

        return redirect()->back()
            ->with('success', 'Booking confirmed successfully.');
    }

    /**
     * Activate a confirmed booking (check-out).
     */
    public function activate(Booking $booking): RedirectResponse
    {
        if ($booking->booking_status !== Booking::STATUS_CONFIRMED) {
            return redirect()->back()
                ->with('error', 'Only confirmed bookings can be activated.');
        }

        $booking->activate();

        return redirect()->route('admin.bookings.checkout', $booking)
            ->with('success', 'Booking activated. Please complete vehicle check-out.');
    }

    /**
     * Complete a booking (check-in).
     */
    public function complete(Request $request, Booking $booking): RedirectResponse
    {
        if ($booking->booking_status !== Booking::STATUS_ACTIVE) {
            return redirect()->back()
                ->with('error', 'Only active bookings can be completed.');
        }

        $validated = $request->validate([
            'actual_return_date' => 'required|date',
        ]);

        $booking->update([
            'actual_return_date' => $validated['actual_return_date']
        ]);

        // Calculate and update late penalty if applicable
        $booking->updateLatePenalty();
        $booking->complete();

        return redirect()->route('admin.bookings.show', $booking)
            ->with('success', 'Booking completed successfully.');
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        if (!$booking->canBeCancelled()) {
            return redirect()->back()
                ->with('error', 'This booking cannot be cancelled.');
        }

        $validated = $request->validate([
            'cancellation_reason' => 'nullable|string|max:500',
        ]);

        $booking->update(['notes' => $validated['cancellation_reason']]);
        $booking->cancel();

        return redirect()->back()
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Calculate real-time pricing for booking form.
     */
    public function calculatePrice(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'customer_id' => 'nullable|exists:customers,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'with_driver' => 'boolean',
            'is_out_of_town' => 'boolean',
            'out_of_town_fee' => 'nullable|numeric|min:0',
        ]);

        $pricing = $this->calculatorService->calculateRealTimePrice($validated);

        return response()->json($pricing);
    }

    /**
     * Check vehicle availability for booking dates.
     */
    public function checkAvailability(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'booking_id' => 'nullable|exists:bookings,id', // For editing existing booking
        ]);

        $car = Car::findOrFail($validated['car_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $availability = $this->availabilityService->checkAvailability(
            $validated['car_id'],
            $startDate,
            $endDate
        );

        // Exclude current booking from conflicts if editing
        if (!empty($validated['booking_id'])) {
            $availability['conflicts'] = $availability['conflicts']->where('id', '!=', $validated['booking_id']);
            $availability['is_available'] = $availability['conflicts']->isEmpty() && 
                                          $car->status === Car::STATUS_AVAILABLE;
        }

        return response()->json($availability);
    }

    /**
     * Search bookings with advanced filters.
     */
    public function search(Request $request): JsonResponse
    {
        $filters = $request->validate([
            'query' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,confirmed,active,completed,cancelled',
            'customer_id' => 'nullable|exists:customers,id',
            'car_id' => 'nullable|exists:cars,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date|after_or_equal:date_from',
            'overdue_only' => 'boolean',
            'limit' => 'nullable|integer|min:1|max:100',
        ]);

        $query = Booking::with(['customer:id,name,phone', 'car:id,license_plate,brand,model'])
            ->orderBy('created_at', 'desc');

        // Apply filters
        if (!empty($filters['query'])) {
            $search = $filters['query'];
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('car', function ($carQuery) use ($search) {
                      $carQuery->where('license_plate', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($filters['status'])) {
            $query->where('booking_status', $filters['status']);
        }

        if (!empty($filters['customer_id'])) {
            $query->where('customer_id', $filters['customer_id']);
        }

        if (!empty($filters['car_id'])) {
            $query->where('car_id', $filters['car_id']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('start_date', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('end_date', '<=', $filters['date_to']);
        }

        if (!empty($filters['overdue_only'])) {
            $query->overdue();
        }

        $limit = $filters['limit'] ?? 20;
        $bookings = $query->limit($limit)->get();

        return response()->json([
            'bookings' => $bookings,
            'total' => $query->count(),
        ]);
    }

    /**
     * Get booking statistics for dashboard.
     */
    public function statistics(): JsonResponse
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        $statistics = [
            'today' => [
                'checkouts' => Booking::whereDate('start_date', $today)
                    ->where('booking_status', Booking::STATUS_CONFIRMED)
                    ->count(),
                'checkins' => Booking::whereDate('end_date', $today)
                    ->where('booking_status', Booking::STATUS_ACTIVE)
                    ->count(),
                'active' => Booking::where('booking_status', Booking::STATUS_ACTIVE)
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->count(),
            ],
            'this_month' => [
                'total_bookings' => Booking::whereDate('created_at', '>=', $thisMonth)->count(),
                'completed' => Booking::where('booking_status', Booking::STATUS_COMPLETED)
                    ->whereDate('created_at', '>=', $thisMonth)
                    ->count(),
                'revenue' => Booking::where('booking_status', Booking::STATUS_COMPLETED)
                    ->whereDate('created_at', '>=', $thisMonth)
                    ->sum('total_amount'),
            ],
            'overdue' => Booking::overdue()->count(),
            'pending_confirmation' => Booking::where('booking_status', Booking::STATUS_PENDING)->count(),
        ];

        return response()->json($statistics);
    }

    /**
     * Get available drivers for a date range.
     */
    public function getAvailableDrivers(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'booking_id' => 'nullable|exists:bookings,id',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        // Get all active drivers
        $driversQuery = User::drivers()->active();

        // Exclude drivers with conflicting bookings
        $driversQuery->whereDoesntHave('driverBookings', function ($query) use ($startDate, $endDate, $validated) {
            $query->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
                  ->where(function ($q) use ($startDate, $endDate) {
                      $q->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($subQ) use ($startDate, $endDate) {
                            $subQ->where('start_date', '<=', $startDate)
                                 ->where('end_date', '>=', $endDate);
                        });
                  });

            // Exclude current booking if editing
            if (!empty($validated['booking_id'])) {
                $query->where('id', '!=', $validated['booking_id']);
            }
        });

        $drivers = $driversQuery->select('id', 'name', 'phone')->get();

        return response()->json($drivers);
    }

    /**
     * Show the vehicle checkout form for a booking.
     */
    public function checkout(Booking $booking): View|RedirectResponse
    {
        if ($booking->booking_status !== Booking::STATUS_CONFIRMED) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Only confirmed bookings can be checked out.');
        }

        if ($booking->checkoutInspection()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Vehicle has already been checked out.');
        }

        return view('admin.bookings.checkout', compact('booking'));
    }

    /**
     * Show the vehicle checkin form for a booking.
     */
    public function checkin(Booking $booking): View|RedirectResponse
    {
        if ($booking->booking_status !== Booking::STATUS_ACTIVE) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Only active bookings can be checked in.');
        }

        if ($booking->checkinInspection()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Vehicle has already been checked in.');
        }

        if (!$booking->checkoutInspection()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Vehicle must be checked out before check-in.');
        }

        return view('admin.bookings.checkin', compact('booking'));
    }
    /**
     * Approve payment for a booking.
     */
    public function approvePayment(Booking $booking): RedirectResponse
    {
        if ($booking->payment_status !== Booking::PAYMENT_VERIFYING) {
            return redirect()->back()
                ->with('error', 'Only bookings with verifying payment status can be approved.');
        }

        $booking->update([
            'payment_status' => $booking->payment_type === 'full' ? Booking::PAYMENT_PAID : Booking::PAYMENT_PARTIAL,
        ]);

        return redirect()->back()
            ->with('success', 'Payment approved successfully.');
    }

    /**
     * Reject payment for a booking.
     */
    public function rejectPayment(Request $request, Booking $booking): RedirectResponse
    {
        if ($booking->payment_status !== Booking::PAYMENT_VERIFYING) {
            return redirect()->back()
                ->with('error', 'Only bookings with verifying payment status can be rejected.');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'payment_status' => Booking::PAYMENT_PENDING,
            'payment_notes' => ($booking->payment_notes ? $booking->payment_notes . "\n\n" : '') . 
                              "Payment Rejected: " . $validated['rejection_reason'],
        ]);

        return redirect()->back()
            ->with('success', 'Payment rejected.');
    }
}