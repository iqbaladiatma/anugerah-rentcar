<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class AvailabilityService
{
    /**
     * Check vehicle availability for a specific date range.
     */
    public function checkAvailability(int $carId, Carbon $startDate, Carbon $endDate): array
    {
        $car = Car::findOrFail($carId);
        
        return [
            'car_id' => $carId,
            'is_available' => $this->isAvailable($car, $startDate, $endDate),
            'conflicts' => $this->getConflicts($car, $startDate, $endDate),
            'next_available_date' => $this->getNextAvailableDate($car, $startDate),
            'buffer_time_hours' => Setting::current()->getBufferTimeHours()
        ];
    }

    /**
     * Check if a car is available for the given date range.
     */
    public function isAvailable(Car $car, Carbon $startDate, Carbon $endDate): bool
    {
        // Check car status
        if ($car->status !== Car::STATUS_AVAILABLE) {
            return false;
        }

        // Check for booking conflicts with buffer time
        return !$this->hasConflicts($car, $startDate, $endDate);
    }

    /**
     * Check if there are any booking conflicts.
     */
    public function hasConflicts(Car $car, Carbon $startDate, Carbon $endDate): bool
    {
        $bufferHours = Setting::current()->getBufferTimeHours();
        
        return $car->bookings()
            ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
            ->where(function ($query) use ($startDate, $endDate, $bufferHours) {
                // Check for overlapping periods including buffer time
                $query->where(function ($q) use ($startDate, $endDate, $bufferHours) {
                    // Existing booking starts before our end date (+ buffer) and ends after our start date (- buffer)
                    $q->where('start_date', '<=', $endDate->copy()->addHours($bufferHours))
                      ->where('end_date', '>=', $startDate->copy()->subHours($bufferHours));
                });
            })
            ->exists();
    }

    /**
     * Get conflicting bookings for a date range.
     */
    public function getConflicts(Car $car, Carbon $startDate, Carbon $endDate): Collection
    {
        $bufferHours = Setting::current()->getBufferTimeHours();
        
        return $car->bookings()
            ->with('customer')
            ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
            ->where(function ($query) use ($startDate, $endDate, $bufferHours) {
                $query->where(function ($q) use ($startDate, $endDate, $bufferHours) {
                    $q->where('start_date', '<=', $endDate->copy()->addHours($bufferHours))
                      ->where('end_date', '>=', $startDate->copy()->subHours($bufferHours));
                });
            })
            ->orderBy('start_date')
            ->get();
    }

    /**
     * Get the next available date for a car after a given date.
     */
    public function getNextAvailableDate(Car $car, Carbon $fromDate): Carbon
    {
        if ($car->status !== Car::STATUS_AVAILABLE) {
            return $fromDate->copy()->addDays(30); // Assume 30 days for maintenance/inactive
        }

        $bufferHours = Setting::current()->getBufferTimeHours();
        
        // Get the latest booking that conflicts with or comes after the from date
        $latestBooking = $car->bookings()
            ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
            ->where('end_date', '>=', $fromDate)
            ->orderBy('end_date', 'desc')
            ->first();

        if (!$latestBooking) {
            return $fromDate;
        }

        // Return the end date of the latest booking plus buffer time
        return Carbon::parse($latestBooking->end_date)->addHours($bufferHours);
    }

    /**
     * Find available cars for a date range.
     */
    public function findAvailableCars(Carbon $startDate, Carbon $endDate, array $filters = []): Collection
    {
        $query = Car::where('status', Car::STATUS_AVAILABLE);

        // Apply filters
        if (!empty($filters['brand'])) {
            $query->where('brand', $filters['brand']);
        }

        if (!empty($filters['model'])) {
            $query->where('model', 'like', '%' . $filters['model'] . '%');
        }

        if (!empty($filters['max_daily_rate'])) {
            $query->where('daily_rate', '<=', $filters['max_daily_rate']);
        }

        if (!empty($filters['min_daily_rate'])) {
            $query->where('daily_rate', '>=', $filters['min_daily_rate']);
        }

        $cars = $query->get();

        // Filter by availability
        return $cars->filter(function ($car) use ($startDate, $endDate) {
            return $this->isAvailable($car, $startDate, $endDate);
        });
    }

    /**
     * Get availability calendar for a car.
     */
    public function getAvailabilityCalendar(Car $car, Carbon $startDate, Carbon $endDate): array
    {
        $calendar = [];
        $current = $startDate->copy();
        $bufferHours = Setting::current()->getBufferTimeHours();

        while ($current <= $endDate) {
            $dayStart = $current->copy()->startOfDay();
            $dayEnd = $current->copy()->endOfDay();
            
            $dayBookings = $car->bookings()
                ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
                ->where(function ($query) use ($dayStart, $dayEnd) {
                    $query->where('start_date', '<=', $dayEnd)
                          ->where('end_date', '>=', $dayStart);
                })
                ->with('customer')
                ->get();

            $status = 'available';
            $booking = null;

            if ($car->status !== Car::STATUS_AVAILABLE) {
                $status = $car->status;
            } elseif ($dayBookings->isNotEmpty()) {
                $status = 'booked';
                $booking = $dayBookings->first();
            }

            $calendar[] = [
                'date' => $current->format('Y-m-d'),
                'status' => $status,
                'booking' => $booking ? [
                    'id' => $booking->id,
                    'booking_number' => $booking->booking_number,
                    'customer_name' => $booking->customer->name,
                    'start_date' => $booking->start_date,
                    'end_date' => $booking->end_date,
                    'buffer_end' => $booking->end_date->copy()->addHours($bufferHours)
                ] : null
            ];

            $current->addDay();
        }

        return $calendar;
    }

    /**
     * Check availability for multiple cars at once.
     */
    public function checkMultipleAvailability(array $carIds, Carbon $startDate, Carbon $endDate): array
    {
        $results = [];

        foreach ($carIds as $carId) {
            $car = Car::find($carId);
            if ($car) {
                $results[] = [
                    'car' => [
                        'id' => $car->id,
                        'license_plate' => $car->license_plate,
                        'brand' => $car->brand,
                        'model' => $car->model,
                        'status' => $car->status
                    ],
                    'availability' => $this->checkAvailability($carId, $startDate, $endDate)
                ];
            }
        }

        return $results;
    }

    /**
     * Get buffer time conflicts for a booking.
     */
    public function getBufferTimeConflicts(Car $car, Carbon $startDate, Carbon $endDate): array
    {
        $bufferHours = Setting::current()->getBufferTimeHours();
        
        // Check conflicts in the buffer period before start
        $beforeBufferStart = $startDate->copy()->subHours($bufferHours);
        $beforeConflicts = $car->bookings()
            ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
            ->where('end_date', '>', $beforeBufferStart)
            ->where('end_date', '<=', $startDate)
            ->with('customer')
            ->get();

        // Check conflicts in the buffer period after end
        $afterBufferEnd = $endDate->copy()->addHours($bufferHours);
        $afterConflicts = $car->bookings()
            ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
            ->where('start_date', '>=', $endDate)
            ->where('start_date', '<', $afterBufferEnd)
            ->with('customer')
            ->get();

        return [
            'buffer_hours' => $bufferHours,
            'before_conflicts' => $beforeConflicts,
            'after_conflicts' => $afterConflicts,
            'has_buffer_conflicts' => $beforeConflicts->isNotEmpty() || $afterConflicts->isNotEmpty()
        ];
    }

    /**
     * Suggest alternative dates if requested dates are not available.
     */
    public function suggestAlternativeDates(Car $car, Carbon $requestedStart, Carbon $requestedEnd, int $maxSuggestions = 5): array
    {
        $suggestions = [];
        $duration = $requestedStart->diffInDays($requestedEnd) + 1;
        $searchStart = $requestedStart->copy();
        $maxSearchDays = 30;
        $searchedDays = 0;

        while (count($suggestions) < $maxSuggestions && $searchedDays < $maxSearchDays) {
            $testEnd = $searchStart->copy()->addDays($duration - 1);
            
            if ($this->isAvailable($car, $searchStart, $testEnd)) {
                $suggestions[] = [
                    'start_date' => $searchStart->copy(),
                    'end_date' => $testEnd->copy(),
                    'days_difference' => $requestedStart->diffInDays($searchStart, false)
                ];
            }

            $searchStart->addDay();
            $searchedDays++;
        }

        return $suggestions;
    }

    /**
     * Get fleet availability summary for a date range.
     */
    public function getFleetAvailabilitySummary(Carbon $startDate, Carbon $endDate): array
    {
        $totalCars = Car::count();
        $availableCars = $this->findAvailableCars($startDate, $endDate)->count();
        $unavailableCars = $totalCars - $availableCars;

        $statusBreakdown = Car::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return [
            'total_cars' => $totalCars,
            'available_cars' => $availableCars,
            'unavailable_cars' => $unavailableCars,
            'availability_rate' => $totalCars > 0 ? ($availableCars / $totalCars) * 100 : 0,
            'status_breakdown' => $statusBreakdown,
            'date_range' => [
                'start' => $startDate,
                'end' => $endDate
            ]
        ];
    }
}