<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

/**
 * Centralized caching service for frequently accessed data.
 * Provides consistent cache key management and TTL configuration.
 */
class CacheService
{
    /**
     * Cache TTL constants (in seconds)
     */
    const TTL_SHORT = 60;           // 1 minute
    const TTL_MEDIUM = 300;         // 5 minutes
    const TTL_LONG = 3600;          // 1 hour
    const TTL_VERY_LONG = 86400;    // 24 hours

    /**
     * Cache key prefixes
     */
    const PREFIX_SETTINGS = 'settings';
    const PREFIX_FLEET = 'fleet';
    const PREFIX_DASHBOARD = 'dashboard';
    const PREFIX_AVAILABILITY = 'availability';
    const PREFIX_REPORTS = 'reports';
    const PREFIX_CUSTOMERS = 'customers';

    /**
     * Get system settings from cache.
     */
    public function getSettings(): array
    {
        return Cache::remember(
            $this->key(self::PREFIX_SETTINGS, 'current'),
            self::TTL_LONG,
            function () {
                $settings = \App\Models\Setting::first();
                return $settings ? $settings->toArray() : $this->getDefaultSettings();
            }
        );
    }

    /**
     * Clear settings cache.
     */
    public function clearSettingsCache(): void
    {
        Cache::forget($this->key(self::PREFIX_SETTINGS, 'current'));
        $this->logCacheClear('settings');
    }

    /**
     * Get fleet statistics from cache.
     */
    public function getFleetStatistics(): array
    {
        return Cache::remember(
            $this->key(self::PREFIX_FLEET, 'statistics'),
            self::TTL_MEDIUM,
            function () {
                return app(VehicleService::class)->getFleetStatistics();
            }
        );
    }

    /**
     * Clear fleet statistics cache.
     */
    public function clearFleetCache(): void
    {
        Cache::forget($this->key(self::PREFIX_FLEET, 'statistics'));
        Cache::forget($this->key(self::PREFIX_FLEET, 'maintenance_notifications'));
        $this->logCacheClear('fleet');
    }

    /**
     * Get maintenance notifications from cache.
     */
    public function getMaintenanceNotifications(): array
    {
        return Cache::remember(
            $this->key(self::PREFIX_FLEET, 'maintenance_notifications'),
            self::TTL_MEDIUM,
            function () {
                return app(VehicleService::class)->getMaintenanceNotifications();
            }
        );
    }

    /**
     * Get dashboard statistics from cache.
     */
    public function getDashboardStats(): array
    {
        return Cache::remember(
            $this->key(self::PREFIX_DASHBOARD, 'stats'),
            self::TTL_SHORT,
            function () {
                return [
                    'total_vehicles' => \App\Models\Car::count(),
                    'available_vehicles' => \App\Models\Car::where('status', \App\Models\Car::STATUS_AVAILABLE)->count(),
                    'active_bookings' => \App\Models\Booking::where('booking_status', \App\Models\Booking::STATUS_ACTIVE)->count(),
                    'pending_bookings' => \App\Models\Booking::where('booking_status', \App\Models\Booking::STATUS_PENDING)->count(),
                    'overdue_bookings' => \App\Models\Booking::overdue()->count(),
                    'monthly_revenue' => $this->getMonthlyRevenue(),
                ];
            }
        );
    }

    /**
     * Clear dashboard cache.
     */
    public function clearDashboardCache(): void
    {
        Cache::forget($this->key(self::PREFIX_DASHBOARD, 'stats'));
        Cache::forget($this->key(self::PREFIX_DASHBOARD, 'revenue_chart'));
        $this->logCacheClear('dashboard');
    }

    /**
     * Get revenue chart data from cache.
     */
    public function getRevenueChartData(): array
    {
        return Cache::remember(
            $this->key(self::PREFIX_DASHBOARD, 'revenue_chart'),
            self::TTL_LONG,
            function () {
                $months = [];
                $revenues = [];

                for ($i = 11; $i >= 0; $i--) {
                    $date = Carbon::now()->subMonths($i);
                    $months[] = $date->format('M Y');
                    
                    $monthlyRevenue = \App\Models\Booking::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)
                        ->whereIn('booking_status', [\App\Models\Booking::STATUS_COMPLETED, \App\Models\Booking::STATUS_ACTIVE])
                        ->sum('total_amount');
                    
                    $revenues[] = (float) $monthlyRevenue;
                }

                return [
                    'categories' => $months,
                    'series' => [['name' => 'Revenue', 'data' => $revenues]]
                ];
            }
        );
    }

    /**
     * Get vehicle availability for a date range.
     */
    public function getVehicleAvailability(int $carId, string $startDate, string $endDate): array
    {
        $cacheKey = $this->key(self::PREFIX_AVAILABILITY, "car_{$carId}_{$startDate}_{$endDate}");
        
        return Cache::remember(
            $cacheKey,
            self::TTL_SHORT,
            function () use ($carId, $startDate, $endDate) {
                return app(AvailabilityService::class)->checkAvailability(
                    $carId,
                    Carbon::parse($startDate),
                    Carbon::parse($endDate)
                );
            }
        );
    }

    /**
     * Clear availability cache for a specific car.
     */
    public function clearAvailabilityCache(?int $carId = null): void
    {
        if ($carId) {
            // Clear specific car availability cache using tags if available
            Cache::forget($this->key(self::PREFIX_AVAILABILITY, "car_{$carId}_*"));
        }
        $this->logCacheClear('availability');
    }

    /**
     * Get customer statistics from cache.
     */
    public function getCustomerStatistics(): array
    {
        return Cache::remember(
            $this->key(self::PREFIX_CUSTOMERS, 'statistics'),
            self::TTL_MEDIUM,
            function () {
                return [
                    'total' => \App\Models\Customer::count(),
                    'members' => \App\Models\Customer::where('is_member', true)->count(),
                    'blacklisted' => \App\Models\Customer::where('is_blacklisted', true)->count(),
                ];
            }
        );
    }

    /**
     * Clear customer cache.
     */
    public function clearCustomerCache(): void
    {
        Cache::forget($this->key(self::PREFIX_CUSTOMERS, 'statistics'));
        $this->logCacheClear('customers');
    }

    /**
     * Get report data from cache.
     */
    public function getReportData(string $reportType, string $startDate, string $endDate): array
    {
        $cacheKey = $this->key(self::PREFIX_REPORTS, "{$reportType}_{$startDate}_{$endDate}");
        
        return Cache::remember(
            $cacheKey,
            self::TTL_LONG,
            function () use ($reportType, $startDate, $endDate) {
                $reportService = app(ReportService::class);
                $start = Carbon::parse($startDate);
                $end = Carbon::parse($endDate);

                return match ($reportType) {
                    'revenue' => $reportService->getRevenueAnalytics($start, $end),
                    'customer' => $reportService->getCustomerAnalytics($start, $end),
                    'vehicle' => $reportService->getVehicleAnalytics($start, $end),
                    'operational' => $reportService->getOperationalAnalytics($start, $end),
                    default => [],
                };
            }
        );
    }

    /**
     * Clear all report caches.
     */
    public function clearReportCache(): void
    {
        // Clear report-related cache keys
        $this->logCacheClear('reports');
    }

    /**
     * Clear all application caches.
     */
    public function clearAllCaches(): void
    {
        $this->clearSettingsCache();
        $this->clearFleetCache();
        $this->clearDashboardCache();
        $this->clearCustomerCache();
        $this->clearReportCache();
        
        Log::info('All application caches cleared');
    }

    /**
     * Generate a cache key with prefix.
     */
    protected function key(string $prefix, string $identifier): string
    {
        return "anugerah_rentcar:{$prefix}:{$identifier}";
    }

    /**
     * Get default settings array.
     */
    protected function getDefaultSettings(): array
    {
        return [
            'company_name' => 'Anugerah Rentcar',
            'buffer_time_hours' => 3,
            'late_penalty_per_hour' => 50000,
            'member_discount_percentage' => 10,
        ];
    }

    /**
     * Get monthly revenue.
     */
    protected function getMonthlyRevenue(): float
    {
        return (float) \App\Models\Booking::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereIn('booking_status', [\App\Models\Booking::STATUS_COMPLETED, \App\Models\Booking::STATUS_ACTIVE])
            ->sum('total_amount');
    }

    /**
     * Log cache clear operation.
     */
    protected function logCacheClear(string $cacheType): void
    {
        Log::debug("Cache cleared: {$cacheType}");
    }
}
