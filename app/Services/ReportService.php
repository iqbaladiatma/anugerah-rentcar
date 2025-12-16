<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReportService
{
    /**
     * Generate comprehensive dashboard analytics.
     */
    public function getDashboardAnalytics(Carbon $startDate, Carbon $endDate): array
    {
        return [
            'revenue_analytics' => $this->getRevenueAnalytics($startDate, $endDate),
            'customer_analytics' => $this->getCustomerAnalytics($startDate, $endDate),
            'vehicle_analytics' => $this->getVehicleAnalytics($startDate, $endDate),
            'operational_analytics' => $this->getOperationalAnalytics($startDate, $endDate),
        ];
    }

    /**
     * Get revenue analytics and trends.
     */
    public function getRevenueAnalytics(Carbon $startDate, Carbon $endDate): array
    {
        $bookings = Booking::where('booking_status', 'completed')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $dailyRevenue = $bookings->groupBy(function($booking) {
            return $booking->start_date->format('Y-m-d');
        })->map(function($dayBookings) {
            return $dayBookings->sum('total_amount');
        });

        $weeklyRevenue = $bookings->groupBy(function($booking) {
            return $booking->start_date->format('Y-W');
        })->map(function($weekBookings) {
            return $weekBookings->sum('total_amount');
        });

        return [
            'total_revenue' => $bookings->sum('total_amount'),
            'average_daily_revenue' => $dailyRevenue->avg(),
            'highest_daily_revenue' => $dailyRevenue->max(),
            'lowest_daily_revenue' => $dailyRevenue->min(),
            'daily_trend' => $dailyRevenue->toArray(),
            'weekly_trend' => $weeklyRevenue->toArray(),
            'revenue_growth' => $this->calculateRevenueGrowth($startDate, $endDate),
        ];
    }

    /**
     * Get customer analytics and behavior patterns.
     */
    public function getCustomerAnalytics(Carbon $startDate, Carbon $endDate): array
    {
        $customers = Customer::with(['bookings' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate]);
        }])->get();

        $activeCustomers = $customers->filter(function($customer) {
            return $customer->bookings->count() > 0;
        });

        $repeatCustomers = $activeCustomers->filter(function($customer) {
            return $customer->bookings->count() > 1;
        });

        return [
            'total_customers' => $customers->count(),
            'active_customers' => $activeCustomers->count(),
            'new_customers' => $customers->filter(function($customer) use ($startDate, $endDate) {
                return $customer->created_at >= $startDate && $customer->created_at <= $endDate;
            })->count(),
            'repeat_customers' => $repeatCustomers->count(),
            'repeat_rate' => $activeCustomers->count() > 0 ? ($repeatCustomers->count() / $activeCustomers->count()) * 100 : 0,
            'member_conversion_rate' => $customers->count() > 0 ? ($customers->where('is_member', true)->count() / $customers->count()) * 100 : 0,
            'average_bookings_per_customer' => $activeCustomers->count() > 0 ? $activeCustomers->avg(function($customer) {
                return $customer->bookings->count();
            }) : 0,
        ];
    }

    /**
     * Get vehicle analytics and performance metrics.
     */
    public function getVehicleAnalytics(Carbon $startDate, Carbon $endDate): array
    {
        $vehicles = Car::with(['bookings' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('start_date', [$startDate, $endDate]);
        }])->get();

        $totalDays = $startDate->diffInDays($endDate) + 1;

        $utilizationRates = $vehicles->map(function($vehicle) use ($totalDays) {
            $bookedDays = $vehicle->bookings->sum(function($booking) {
                return $booking->start_date->diffInDays($booking->end_date) + 1;
            });
            return $totalDays > 0 ? ($bookedDays / $totalDays) * 100 : 0;
        });

        return [
            'total_vehicles' => $vehicles->count(),
            'active_vehicles' => $vehicles->filter(function($vehicle) {
                return $vehicle->bookings->count() > 0;
            })->count(),
            'average_utilization' => $utilizationRates->avg(),
            'highest_utilization' => $utilizationRates->max(),
            'lowest_utilization' => $utilizationRates->min(),
            'underperforming_vehicles' => $vehicles->filter(function($vehicle) use ($totalDays) {
                $bookedDays = $vehicle->bookings->sum(function($booking) {
                    return $booking->start_date->diffInDays($booking->end_date) + 1;
                });
                $utilization = $totalDays > 0 ? ($bookedDays / $totalDays) * 100 : 0;
                return $utilization < 30;
            })->count(),
        ];
    }

    /**
     * Get operational analytics including expenses and maintenance.
     */
    public function getOperationalAnalytics(Carbon $startDate, Carbon $endDate): array
    {
        $expenses = Expense::whereBetween('expense_date', [$startDate, $endDate])->get();
        $maintenances = Maintenance::whereBetween('service_date', [$startDate, $endDate])->get();

        $expensesByCategory = $expenses->groupBy('category')->map(function($categoryExpenses) {
            return $categoryExpenses->sum('amount');
        });

        return [
            'total_operational_expenses' => $expenses->sum('amount'),
            'total_maintenance_costs' => $maintenances->sum('cost'),
            'expenses_by_category' => $expensesByCategory->toArray(),
            'average_maintenance_cost' => $maintenances->count() > 0 ? $maintenances->avg('cost') : 0,
            'maintenance_frequency' => $maintenances->count(),
            'cost_per_vehicle' => Car::count() > 0 ? ($expenses->sum('amount') + $maintenances->sum('cost')) / Car::count() : 0,
        ];
    }

    /**
     * Calculate revenue growth compared to previous period.
     */
    private function calculateRevenueGrowth(Carbon $startDate, Carbon $endDate): array
    {
        $periodDays = $startDate->diffInDays($endDate) + 1;
        $previousStartDate = $startDate->copy()->subDays($periodDays);
        $previousEndDate = $startDate->copy()->subDay();

        $currentRevenue = Booking::where('booking_status', 'completed')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->sum('total_amount');

        $previousRevenue = Booking::where('booking_status', 'completed')
            ->whereBetween('start_date', [$previousStartDate, $previousEndDate])
            ->sum('total_amount');

        $growthAmount = $currentRevenue - $previousRevenue;
        $growthPercentage = $previousRevenue > 0 ? ($growthAmount / $previousRevenue) * 100 : 0;

        return [
            'current_revenue' => $currentRevenue,
            'previous_revenue' => $previousRevenue,
            'growth_amount' => $growthAmount,
            'growth_percentage' => $growthPercentage,
        ];
    }

    /**
     * Generate profitability analysis by vehicle.
     */
    public function getVehicleProfitabilityAnalysis(Carbon $startDate, Carbon $endDate): Collection
    {
        return Car::with(['bookings' => function($q) use ($startDate, $endDate) {
            $q->where('booking_status', 'completed')
              ->whereBetween('start_date', [$startDate, $endDate]);
        }, 'maintenances' => function($q) use ($startDate, $endDate) {
            $q->whereBetween('service_date', [$startDate, $endDate]);
        }])->get()->map(function($vehicle) {
            $revenue = $vehicle->bookings->sum('total_amount');
            $maintenanceCosts = $vehicle->maintenances->sum('cost');
            $netProfit = $revenue - $maintenanceCosts;
            $profitMargin = $revenue > 0 ? ($netProfit / $revenue) * 100 : 0;

            return [
                'vehicle' => $vehicle,
                'revenue' => $revenue,
                'maintenance_costs' => $maintenanceCosts,
                'net_profit' => $netProfit,
                'profit_margin' => $profitMargin,
                'roi' => $vehicle->daily_rate > 0 ? ($netProfit / ($vehicle->daily_rate * 365)) * 100 : 0,
            ];
        })->sortByDesc('net_profit');
    }

    /**
     * Generate customer lifetime value analysis.
     */
    public function getCustomerLifetimeValueAnalysis(): Collection
    {
        return Customer::with('bookings')->get()->map(function($customer) {
            $completedBookings = $customer->bookings->where('booking_status', 'completed');
            $totalRevenue = $completedBookings->sum('total_amount');
            $totalBookings = $completedBookings->count();
            $averageBookingValue = $totalBookings > 0 ? $totalRevenue / $totalBookings : 0;
            
            $firstBooking = $customer->bookings->min('start_date');
            $lastBooking = $customer->bookings->max('start_date');
            $customerLifespan = $firstBooking && $lastBooking ? 
                Carbon::parse($firstBooking)->diffInDays(Carbon::parse($lastBooking)) + 1 : 0;
            
            $bookingFrequency = $customerLifespan > 0 && $totalBookings > 1 ? 
                $customerLifespan / $totalBookings : 0;

            return [
                'customer' => $customer,
                'lifetime_value' => $totalRevenue,
                'total_bookings' => $totalBookings,
                'average_booking_value' => $averageBookingValue,
                'customer_lifespan_days' => $customerLifespan,
                'booking_frequency_days' => $bookingFrequency,
                'predicted_annual_value' => $bookingFrequency > 0 ? (365 / $bookingFrequency) * $averageBookingValue : 0,
            ];
        })->sortByDesc('lifetime_value');
    }

    /**
     * Generate seasonal trend analysis.
     */
    public function getSeasonalTrendAnalysis(int $years = 2): array
    {
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subYears($years);

        $bookings = Booking::where('booking_status', 'completed')
            ->whereBetween('start_date', [$startDate, $endDate])
            ->get();

        $monthlyTrends = $bookings->groupBy(function($booking) {
            return $booking->start_date->format('m');
        })->map(function($monthBookings, $month) {
            return [
                'month' => (int)$month,
                'month_name' => Carbon::createFromFormat('m', $month)->format('F'),
                'total_bookings' => $monthBookings->count(),
                'total_revenue' => $monthBookings->sum('total_amount'),
                'average_booking_value' => $monthBookings->count() > 0 ? $monthBookings->avg('total_amount') : 0,
            ];
        })->sortBy('month');

        $quarterlyTrends = $bookings->groupBy(function($booking) {
            return 'Q' . $booking->start_date->quarter;
        })->map(function($quarterBookings, $quarter) {
            return [
                'quarter' => $quarter,
                'total_bookings' => $quarterBookings->count(),
                'total_revenue' => $quarterBookings->sum('total_amount'),
                'average_booking_value' => $quarterBookings->count() > 0 ? $quarterBookings->avg('total_amount') : 0,
            ];
        });

        return [
            'monthly_trends' => $monthlyTrends->values()->toArray(),
            'quarterly_trends' => $quarterlyTrends->values()->toArray(),
            'peak_month' => $monthlyTrends->sortByDesc('total_revenue')->first(),
            'peak_quarter' => $quarterlyTrends->sortByDesc('total_revenue')->first(),
        ];
    }
}