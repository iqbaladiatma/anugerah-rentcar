<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Maintenance;
use App\Models\Expense;
use App\Services\CacheService;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class DashboardStats extends Component
{
    public $refreshInterval = 30000; // 30 seconds

    /**
     * Cache TTL for dashboard stats (in seconds)
     */
    const CACHE_TTL = 60;

    public function mount()
    {
        // Component initialization
    }

    public function getStatsProperty(): array
    {
        return Cache::remember('anugerah_rentcar:dashboard:stats', self::CACHE_TTL, function () {
            return [
                'total_vehicles' => Car::count(),
                'available_vehicles' => Car::where('status', Car::STATUS_AVAILABLE)->count(),
                'active_bookings' => Booking::where('booking_status', Booking::STATUS_ACTIVE)->count(),
                'monthly_revenue' => $this->getMonthlyRevenue(),
                'pending_bookings' => Booking::where('booking_status', Booking::STATUS_PENDING)->count(),
                'overdue_bookings' => Booking::overdue()->count(),
            ];
        });
    }

    public function getRecentBookingsProperty(): Collection
    {
        return Booking::with(['customer', 'car'])
            ->whereIn('booking_status', [Booking::STATUS_ACTIVE, Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    public function getNotificationsProperty(): array
    {
        $notifications = [];
        
        // Get maintenance notifications
        $notifications = array_merge($notifications, $this->getMaintenanceNotifications());
        
        // Get STNK expiry notifications
        $notifications = array_merge($notifications, $this->getStnkExpiryNotifications());
        
        // Get overdue payment notifications
        $notifications = array_merge($notifications, $this->getOverduePaymentNotifications());
        
        // Get pending confirmation notifications
        $notifications = array_merge($notifications, $this->getPendingConfirmationNotifications());
        
        // Sort by priority and date
        usort($notifications, function ($a, $b) {
            $priorityOrder = ['high' => 1, 'medium' => 2, 'low' => 3];
            $aPriority = $priorityOrder[$a['priority']] ?? 4;
            $bPriority = $priorityOrder[$b['priority']] ?? 4;
            
            if ($aPriority === $bPriority) {
                return $b['created_at']->timestamp - $a['created_at']->timestamp;
            }
            
            return $aPriority - $bPriority;
        });
        
        return array_slice($notifications, 0, 10);
    }

    public function getRevenueChartDataProperty(): array
    {
        return Cache::remember('anugerah_rentcar:dashboard:revenue_chart', 3600, function () {
            $months = [];
            $revenues = [];

            // Get last 12 months data
            for ($i = 11; $i >= 0; $i--) {
                $date = Carbon::now()->subMonths($i);
                $months[] = $date->format('M Y');
                
                $monthlyRevenue = Booking::whereYear('created_at', $date->year)
                    ->whereMonth('created_at', $date->month)
                    ->whereIn('booking_status', [Booking::STATUS_COMPLETED, Booking::STATUS_ACTIVE])
                    ->sum('total_amount');
                
                $revenues[] = (float) $monthlyRevenue;
            }

            return [
                'categories' => $months,
                'series' => [
                    [
                        'name' => 'Revenue',
                        'data' => $revenues
                    ]
                ]
            ];
        });
    }

    private function getMonthlyRevenue(): float
    {
        return (float) Booking::whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereIn('booking_status', [Booking::STATUS_COMPLETED, Booking::STATUS_ACTIVE])
            ->sum('total_amount');
    }

    private function getMaintenanceNotifications(): array
    {
        $notifications = [];
        
        $carsNeedingMaintenance = Car::where(function ($query) {
            $query->where('last_oil_change', '<=', Carbon::now()->subDays(90))
                  ->orWhereNull('last_oil_change');
        })->get();

        foreach ($carsNeedingMaintenance as $car) {
            $daysSinceOilChange = $car->last_oil_change 
                ? Carbon::parse($car->last_oil_change)->diffInDays(Carbon::now())
                : 999;

            $notifications[] = [
                'type' => 'maintenance',
                'icon' => 'wrench',
                'title' => 'Maintenance Due',
                'message' => "Oil change due for {$car->license_plate}",
                'details' => $daysSinceOilChange > 90 ? "{$daysSinceOilChange} days overdue" : "Due now",
                'priority' => $daysSinceOilChange > 90 ? 'high' : 'medium',
                'action_url' => route('admin.vehicles.show', $car->id),
                'created_at' => Carbon::now(),
            ];
        }

        return $notifications;
    }

    private function getStnkExpiryNotifications(): array
    {
        $notifications = [];
        
        $carsWithExpiringStnk = Car::where('stnk_expiry', '<=', Carbon::now()->addDays(30))
            ->where('stnk_expiry', '>=', Carbon::now())
            ->get();

        foreach ($carsWithExpiringStnk as $car) {
            $daysLeft = Carbon::parse($car->stnk_expiry)->diffInDays(Carbon::now());
            
            $notifications[] = [
                'type' => 'stnk_expiry',
                'icon' => 'calendar',
                'title' => 'STNK Renewal',
                'message' => "STNK expires soon for {$car->license_plate}",
                'details' => $daysLeft <= 7 ? "{$daysLeft} days left" : "Expires in {$daysLeft} days",
                'priority' => $daysLeft <= 7 ? 'high' : 'medium',
                'action_url' => route('admin.vehicles.show', $car->id),
                'created_at' => Carbon::now(),
            ];
        }

        return $notifications;
    }

    private function getOverduePaymentNotifications(): array
    {
        $notifications = [];
        
        $overdueBookings = Booking::with('customer')
            ->where('payment_status', Booking::PAYMENT_PENDING)
            ->where('created_at', '<=', Carbon::now()->subDays(1))
            ->get();

        foreach ($overdueBookings as $booking) {
            $daysOverdue = Carbon::parse($booking->created_at)->diffInDays(Carbon::now());
            
            $notifications[] = [
                'type' => 'payment_overdue',
                'icon' => 'currency-dollar',
                'title' => 'Payment Overdue',
                'message' => "Payment pending from {$booking->customer->name}",
                'details' => "Booking #{$booking->booking_number} - {$daysOverdue} days overdue",
                'priority' => $daysOverdue > 3 ? 'high' : 'medium',
                'action_url' => route('admin.bookings.show', $booking->id),
                'created_at' => $booking->created_at,
            ];
        }

        return $notifications;
    }

    private function getPendingConfirmationNotifications(): array
    {
        $notifications = [];
        
        $pendingBookings = Booking::with('customer')
            ->where('booking_status', Booking::STATUS_PENDING)
            ->get();

        foreach ($pendingBookings as $booking) {
            $notifications[] = [
                'type' => 'pending_confirmation',
                'icon' => 'clipboard-list',
                'title' => 'Booking Confirmation',
                'message' => "Booking confirmation required",
                'details' => "Booking #{$booking->booking_number} from {$booking->customer->name}",
                'priority' => 'medium',
                'action_url' => route('admin.bookings.show', $booking->id),
                'created_at' => $booking->created_at,
            ];
        }

        return $notifications;
    }

    public function refreshStats()
    {
        // Clear dashboard cache to force refresh
        Cache::forget('anugerah_rentcar:dashboard:stats');
        Cache::forget('anugerah_rentcar:dashboard:revenue_chart');
        
        // This method will be called to refresh the component
        $this->dispatch('stats-refreshed');
    }

    public function render()
    {
        return view('livewire.admin.dashboard-stats');
    }
}