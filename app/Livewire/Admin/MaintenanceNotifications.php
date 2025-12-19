<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Car;
use App\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MaintenanceNotifications extends Component
{
    public $showAll = false;

    public function getNotificationsProperty(): Collection
    {
        $notifications = collect();

        // Get cars needing oil change
        $carsNeedingOilChange = Car::where(function ($query) {
            $query->where('last_oil_change', '<=', Carbon::now()->subDays(90))
                  ->orWhereNull('last_oil_change');
        })->get();

        foreach ($carsNeedingOilChange as $car) {
            $daysSinceOilChange = $car->last_oil_change 
                ? Carbon::parse($car->last_oil_change)->diffInDays(Carbon::now())
                : 999;

            $notifications->push([
                'id' => 'oil_' . $car->id,
                'type' => 'oil_change',
                'car_id' => $car->id,
                'car' => $car,
                'title' => 'Oil Change Due',
                'message' => "Oil change due for {$car->license_plate}",
                'details' => $daysSinceOilChange > 90 ? "{$daysSinceOilChange} days overdue" : "Due now",
                'priority' => $daysSinceOilChange > 90 ? 'high' : 'medium',
                'icon' => 'wrench',
                'action_url' => route('admin.vehicles.show', $car->id),
                'created_at' => Carbon::now(),
                'days_overdue' => max(0, $daysSinceOilChange - 90),
            ]);
        }

        // Get cars with expiring STNK
        $carsWithExpiringStnk = Car::where('stnk_expiry', '<=', Carbon::now()->addDays(7))
            ->where('stnk_expiry', '>=', Carbon::now())
            ->get();

        foreach ($carsWithExpiringStnk as $car) {
            $daysLeft = Carbon::parse($car->stnk_expiry)->diffInDays(Carbon::now());
            
            $notifications->push([
                'id' => 'stnk_' . $car->id,
                'type' => 'stnk_expiry',
                'car_id' => $car->id,
                'car' => $car,
                'title' => 'STNK Renewal Required',
                'message' => "STNK expires soon for {$car->license_plate}",
                'details' => $daysLeft <= 7 ? "{$daysLeft} days left" : "Expires in {$daysLeft} days",
                'priority' => $daysLeft <= 7 ? 'high' : 'medium',
                'icon' => 'calendar',
                'action_url' => route('admin.vehicles.show', $car->id),
                'created_at' => Carbon::now(),
                'days_left' => $daysLeft,
            ]);
        }

        // Get scheduled maintenance due
        $scheduledMaintenance = Maintenance::with('car')
            ->whereNotNull('next_service_date')
            ->where('next_service_date', '<=', Carbon::now()->addDays(7))
            ->get();

        foreach ($scheduledMaintenance as $maintenance) {
            $daysUntil = Carbon::parse($maintenance->next_service_date)->diffInDays(Carbon::now(), false);
            
            $notifications->push([
                'id' => 'maintenance_' . $maintenance->id,
                'type' => 'scheduled_maintenance',
                'car_id' => $maintenance->car_id,
                'car' => $maintenance->car,
                'maintenance' => $maintenance,
                'title' => 'Scheduled Maintenance',
                'message' => "Maintenance scheduled for {$maintenance->car->license_plate}",
                'details' => $daysUntil <= 0 ? "Due today" : "Due in {$daysUntil} days",
                'priority' => $daysUntil <= 0 ? 'high' : 'medium',
                'icon' => 'adjustments',
                'action_url' => route('admin.vehicles.show', $maintenance->car_id),
                'created_at' => $maintenance->next_service_date,
                'days_until' => $daysUntil,
            ]);
        }

        // Sort by priority and date
        $sorted = $notifications->sortBy([
            ['priority', 'asc'], // high first
            ['created_at', 'desc']
        ]);

        // Map priority to numeric for proper sorting
        $priorityMap = ['high' => 0, 'medium' => 1, 'low' => 2];
        $sorted = $notifications->sort(function ($a, $b) use ($priorityMap) {
            $priorityA = $priorityMap[$a['priority']] ?? 3;
            $priorityB = $priorityMap[$b['priority']] ?? 3;
            
            if ($priorityA === $priorityB) {
                return $b['created_at']->timestamp - $a['created_at']->timestamp;
            }
            
            return $priorityA - $priorityB;
        });

        return $this->showAll ? $sorted : $sorted->take(5);
    }

    public function getUrgentCountProperty(): int
    {
        return $this->notifications->where('priority', 'high')->count();
    }

    public function toggleShowAll()
    {
        $this->showAll = !$this->showAll;
    }

    public function markAsHandled($notificationId)
    {
        // This could be extended to mark notifications as handled
        // For now, we'll just refresh the component
        $this->dispatch('notification-handled', $notificationId);
    }

    public function refreshNotifications()
    {
        // Force refresh of computed properties
        $this->dispatch('notifications-refreshed');
    }

    public function render()
    {
        return view('livewire.admin.maintenance-notifications');
    }
}