<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Maintenance;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardStats extends Component
{
    public $refreshInterval = 30000; // 30 seconds

    public function mount()
    {
        // Component initialization
    }

    public function getStatsProperty(): array
    {
        return [
            'total_vehicles' => Car::count(),
            'available_vehicles' => Car::where('status', Car::STATUS_AVAILABLE)->count(),
            'active_bookings' => Booking::where('booking_status', Booking::STATUS_ACTIVE)->count(),
            'monthly_revenue' => $this->getMonthlyRevenue(),
            'pending_bookings' => Booking::where('booking_status', Booking::STATUS_PENDING)->count(),
            'overdue_bookings' => Booking::overdue()->count(),
        ];
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

        // Maintenance notifications
        $maintenanceNotifications = $this->getMaintenanceNotifications();
        $notifications = array_merge($notifications, $maintenanceNotifications);

        // STNK expiry notifications
        $stnkNotifications = $this->getStnkExpiryNotifications();
        $notifications = array_merge($notifications, $stnkNotifications);

        // Overdue payment notifications
        $paymentNotifications = $this->getOverduePaymentNotifications();
        $notifications = array_merge($notifications, $paymentNotifications);

        // Pending confirmation notifications
        $pendingNotifications = $this->getPendingConfirmationNotifications();
        $notifications = array_merge($notifications, $pendingNotifications);

        // Sort by priority (high, medium, low)
        usort($notifications, function ($a, $b) {
            $priorityOrder = ['high' => 0, 'medium' => 1, 'low' => 2];
            return $priorityOrder[$a['priority']] <=> $priorityOrder[$b['priority']];
        });

        return array_slice($notifications, 0, 10); // Limit to 10 notifications
    }

    public function getRevenueChartDataProperty(): array
    {
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
        // This method will be called to refresh the component
        $this->dispatch('stats-refreshed');
    }

    public function render()
    {
        return view('livewire.admin.dashboard-stats');
    }
}