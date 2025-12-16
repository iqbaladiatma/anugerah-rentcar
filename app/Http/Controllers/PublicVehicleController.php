<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Services\AvailabilityService;
use App\Services\VehicleService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicVehicleController extends Controller
{
    public function __construct(
        private AvailabilityService $availabilityService,
        private VehicleService $vehicleService
    ) {}

    /**
     * Display the vehicle catalog.
     */
    public function catalog(Request $request): View
    {
        $query = Car::where('status', Car::STATUS_AVAILABLE);

        // Apply date range filter for availability
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            
            $availableCarIds = $this->vehicleService->getAvailableVehicles($startDate, $endDate)->pluck('id');
            $query->whereIn('id', $availableCarIds);
        }

        // Apply brand filter
        if ($request->filled('brand')) {
            $query->where('brand', $request->brand);
        }

        // Apply price filter
        if ($request->filled('max_price')) {
            $query->where('daily_rate', '<=', $request->max_price);
        }

        // Apply driver requirement filter
        if ($request->filled('with_driver') && $request->with_driver === '1') {
            $query->where('driver_fee_per_day', '>', 0);
        }

        // Apply location filter (for future enhancement)
        if ($request->filled('location')) {
            // This could be enhanced to filter by pickup location
            // For now, we'll just pass it through to the view
        }

        // Order by daily rate for consistent display
        $query->orderBy('daily_rate', 'asc');

        $vehicles = $query->paginate(12)->withQueryString();
        
        // Get available brands for filter dropdown
        $brands = Car::where('status', Car::STATUS_AVAILABLE)
            ->distinct()
            ->pluck('brand')
            ->sort()
            ->values();

        // Get price ranges for filter
        $priceRanges = [
            ['value' => 300000, 'label' => 'Under Rp 300,000'],
            ['value' => 500000, 'label' => 'Under Rp 500,000'],
            ['value' => 750000, 'label' => 'Under Rp 750,000'],
            ['value' => 1000000, 'label' => 'Under Rp 1,000,000'],
        ];

        return view('public.vehicles.catalog', compact('vehicles', 'brands', 'priceRanges'));
    }

    /**
     * Display vehicle details.
     */
    public function show(Car $car): View
    {
        if ($car->status !== Car::STATUS_AVAILABLE) {
            abort(404, 'Vehicle not available for booking');
        }

        // Get next available date for this vehicle
        $nextAvailableDate = $this->vehicleService->getNextAvailableDate($car);

        return view('public.vehicles.show', compact('car', 'nextAvailableDate'));
    }

    /**
     * Search vehicles via AJAX for real-time availability checking.
     */
    public function search(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
            'brand' => 'nullable|string',
            'max_price' => 'nullable|numeric|min:0',
            'with_driver' => 'nullable|boolean',
        ]);

        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        // Get available vehicles for the date range
        $availableVehicles = $this->vehicleService->getAvailableVehicles($startDate, $endDate);

        // Apply additional filters
        if ($request->filled('brand')) {
            $availableVehicles = $availableVehicles->where('brand', $request->brand);
        }

        if ($request->filled('max_price')) {
            $availableVehicles = $availableVehicles->where('daily_rate', '<=', $request->max_price);
        }

        if ($request->filled('with_driver') && $request->with_driver) {
            $availableVehicles = $availableVehicles->where('driver_fee_per_day', '>', 0);
        }

        // Calculate rental duration for pricing
        $duration = $startDate->diffInDays($endDate) + 1;

        return response()->json([
            'success' => true,
            'vehicles' => $availableVehicles->map(function ($car) use ($duration) {
                $totalPrice = $car->daily_rate * $duration;
                $weeklyDiscount = 0;
                
                // Apply weekly rate if duration is 7+ days and weekly rate exists
                if ($duration >= 7 && $car->weekly_rate > 0) {
                    $weeks = floor($duration / 7);
                    $remainingDays = $duration % 7;
                    $totalPrice = ($car->weekly_rate * $weeks) + ($car->daily_rate * $remainingDays);
                    $weeklyDiscount = ($car->daily_rate * $duration) - $totalPrice;
                }

                return [
                    'id' => $car->id,
                    'brand' => $car->brand,
                    'model' => $car->model,
                    'year' => $car->year,
                    'color' => $car->color,
                    'license_plate' => $car->license_plate,
                    'daily_rate' => $car->daily_rate,
                    'weekly_rate' => $car->weekly_rate,
                    'driver_fee_per_day' => $car->driver_fee_per_day,
                    'total_price' => $totalPrice,
                    'weekly_discount' => $weeklyDiscount,
                    'duration' => $duration,
                    'photo_front' => $car->photo_front ? asset('storage/' . $car->photo_front) : null,
                    'photo_side' => $car->photo_side ? asset('storage/' . $car->photo_side) : null,
                    'photo_back' => $car->photo_back ? asset('storage/' . $car->photo_back) : null,
                    'url' => route('vehicles.show', $car),
                ];
            })->values(),
            'total_count' => $availableVehicles->count(),
            'search_params' => [
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'duration' => $duration,
            ]
        ]);
    }

    /**
     * Check real-time availability for a specific vehicle.
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $car = Car::findOrFail($request->car_id);
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);

        $availability = $this->availabilityService->checkAvailability($car->id, $startDate, $endDate);

        return response()->json([
            'success' => true,
            'availability' => $availability,
            'car' => [
                'id' => $car->id,
                'brand' => $car->brand,
                'model' => $car->model,
                'license_plate' => $car->license_plate,
                'status' => $car->status,
            ]
        ]);
    }
}