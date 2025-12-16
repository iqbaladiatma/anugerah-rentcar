<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class VehicleService
{
    /**
     * Cache TTL constants (in seconds)
     */
    const CACHE_TTL_SHORT = 60;      // 1 minute
    const CACHE_TTL_MEDIUM = 300;    // 5 minutes
    /**
     * Get available vehicles for a date range.
     */
    public function getAvailableVehicles(Carbon $startDate, Carbon $endDate): Collection
    {
        return Car::available()
            ->get()
            ->filter(function ($car) use ($startDate, $endDate) {
                return $this->isVehicleAvailable($car, $startDate, $endDate);
            });
    }

    /**
     * Check if a specific vehicle is available for a date range.
     */
    public function isVehicleAvailable(Car $car, Carbon $startDate, Carbon $endDate): bool
    {
        if ($car->status !== Car::STATUS_AVAILABLE) {
            return false;
        }

        // Check for conflicting bookings with buffer time
        $bufferHours = Setting::current()->getBufferTimeHours();
        
        $conflictingBookings = $car->bookings()
            ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
            ->where(function ($query) use ($startDate, $endDate, $bufferHours) {
                $query->where(function ($q) use ($startDate, $endDate, $bufferHours) {
                    // Check if requested period overlaps with existing booking + buffer
                    $q->where('start_date', '<=', $endDate->copy()->addHours($bufferHours))
                      ->where('end_date', '>=', $startDate->copy()->subHours($bufferHours));
                });
            })
            ->exists();

        return !$conflictingBookings;
    }

    /**
     * Get vehicle availability timeline for a date range.
     */
    public function getVehicleTimeline(Carbon $startDate, Carbon $endDate): array
    {
        $vehicles = Car::with(['bookings' => function ($query) use ($startDate, $endDate) {
            $query->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE])
                  ->where(function ($q) use ($startDate, $endDate) {
                      $q->whereBetween('start_date', [$startDate, $endDate])
                        ->orWhereBetween('end_date', [$startDate, $endDate])
                        ->orWhere(function ($subQ) use ($startDate, $endDate) {
                            $subQ->where('start_date', '<=', $startDate)
                                 ->where('end_date', '>=', $endDate);
                        });
                  })
                  ->with('customer');
        }])->get();

        $timeline = [];
        $bufferHours = Setting::current()->getBufferTimeHours();

        foreach ($vehicles as $vehicle) {
            $vehicleData = [
                'id' => $vehicle->id,
                'license_plate' => $vehicle->license_plate,
                'brand' => $vehicle->brand,
                'model' => $vehicle->model,
                'status' => $vehicle->status,
                'bookings' => []
            ];

            foreach ($vehicle->bookings as $booking) {
                $vehicleData['bookings'][] = [
                    'id' => $booking->id,
                    'booking_number' => $booking->booking_number,
                    'customer_name' => $booking->customer->name,
                    'start_date' => $booking->start_date,
                    'end_date' => $booking->end_date,
                    'buffer_end' => $booking->end_date->copy()->addHours($bufferHours),
                    'status' => $booking->booking_status,
                    'with_driver' => $booking->with_driver,
                    'is_out_of_town' => $booking->is_out_of_town
                ];
            }

            $timeline[] = $vehicleData;
        }

        return $timeline;
    }

    /**
     * Get vehicles requiring maintenance.
     */
    public function getVehiclesRequiringMaintenance(): Collection
    {
        return Car::all()->filter(function ($car) {
            return $car->isMaintenanceDue();
        });
    }

    /**
     * Get maintenance notifications for all vehicles with caching.
     */
    public function getMaintenanceNotifications(): array
    {
        return Cache::remember('anugerah_rentcar:fleet:maintenance_notifications', self::CACHE_TTL_MEDIUM, function () {
            $notifications = [];
            $vehicles = $this->getVehiclesRequiringMaintenance();

            foreach ($vehicles as $vehicle) {
                $vehicleNotifications = $vehicle->getMaintenanceNotifications();
                foreach ($vehicleNotifications as $notification) {
                    $notification['vehicle_id'] = $vehicle->id;
                    $notification['license_plate'] = $vehicle->license_plate;
                    $notifications[] = $notification;
                }
            }

            // Sort by priority (high first)
            usort($notifications, function ($a, $b) {
                $priorityOrder = ['high' => 3, 'medium' => 2, 'low' => 1];
                return ($priorityOrder[$b['priority']] ?? 0) - ($priorityOrder[$a['priority']] ?? 0);
            });

            return $notifications;
        });
    }

    /**
     * Clear maintenance notifications cache.
     */
    public function clearMaintenanceNotificationsCache(): void
    {
        Cache::forget('anugerah_rentcar:fleet:maintenance_notifications');
    }

    /**
     * Get next available date for a vehicle.
     */
    public function getNextAvailableDate(Car $car): Carbon
    {
        return $car->getNextAvailableDate();
    }

    /**
     * Update vehicle status.
     */
    public function updateVehicleStatus(Car $car, string $status): void
    {
        $car->updateStatus($status);
    }

    /**
     * Get fleet statistics with caching.
     */
    public function getFleetStatistics(): array
    {
        return Cache::remember('anugerah_rentcar:fleet:statistics', self::CACHE_TTL_MEDIUM, function () {
            $totalVehicles = Car::count();
            $availableVehicles = Car::where('status', Car::STATUS_AVAILABLE)->count();
            $rentedVehicles = Car::where('status', Car::STATUS_RENTED)->count();
            $maintenanceVehicles = Car::where('status', Car::STATUS_MAINTENANCE)->count();
            $inactiveVehicles = Car::where('status', Car::STATUS_INACTIVE)->count();

            return [
                'total' => $totalVehicles,
                'available' => $availableVehicles,
                'rented' => $rentedVehicles,
                'maintenance' => $maintenanceVehicles,
                'inactive' => $inactiveVehicles,
                'utilization_rate' => $totalVehicles > 0 ? ($rentedVehicles / $totalVehicles) * 100 : 0
            ];
        });
    }

    /**
     * Clear fleet statistics cache.
     */
    public function clearFleetStatisticsCache(): void
    {
        Cache::forget('anugerah_rentcar:fleet:statistics');
    }

    /**
     * Calculate vehicle utilization for a period.
     */
    public function calculateVehicleUtilization(Car $car, Carbon $startDate, Carbon $endDate): float
    {
        $totalDays = $startDate->diffInDays($endDate) + 1;
        
        $rentedDays = $car->bookings()
            ->whereIn('booking_status', [Booking::STATUS_CONFIRMED, Booking::STATUS_ACTIVE, Booking::STATUS_COMPLETED])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                      ->orWhereBetween('end_date', [$startDate, $endDate])
                      ->orWhere(function ($q) use ($startDate, $endDate) {
                          $q->where('start_date', '<=', $startDate)
                            ->where('end_date', '>=', $endDate);
                      });
            })
            ->get()
            ->sum(function ($booking) use ($startDate, $endDate) {
                $bookingStart = $booking->start_date->max($startDate);
                $bookingEnd = $booking->end_date->min($endDate);
                return $bookingStart->diffInDays($bookingEnd) + 1;
            });

        return $totalDays > 0 ? ($rentedDays / $totalDays) * 100 : 0;
    }

    /**
     * Get vehicle revenue for a period.
     */
    public function calculateVehicleRevenue(Car $car, Carbon $startDate, Carbon $endDate): float
    {
        return $car->bookings()
            ->whereIn('booking_status', [Booking::STATUS_COMPLETED])
            ->whereBetween('start_date', [$startDate, $endDate])
            ->sum('total_amount');
    }
}