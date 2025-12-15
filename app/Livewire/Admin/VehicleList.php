<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class VehicleList extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $sortBy = 'license_plate';

    #[Url]
    public string $sortDirection = 'asc';

    public bool $showMaintenanceDue = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'sortBy' => ['except' => 'license_plate'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function toggleMaintenanceDue()
    {
        $this->showMaintenanceDue = !$this->showMaintenanceDue;
        $this->resetPage();
    }

    public function updateVehicleStatus($vehicleId, $status)
    {
        $vehicle = Car::findOrFail($vehicleId);
        
        // Validate status change
        if ($status === Car::STATUS_RENTED && $vehicle->activeBooking()) {
            session()->flash('error', 'Cannot manually set status to rented when vehicle has active booking.');
            return;
        }

        $vehicle->updateStatus($status);
        
        session()->flash('success', "Vehicle {$vehicle->license_plate} status updated to " . ucfirst($status));
    }

    public function render()
    {
        $query = Car::query()
            ->with(['bookings' => function ($q) {
                $q->whereIn('booking_status', ['confirmed', 'active'])->latest();
            }]);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('license_plate', 'like', '%' . $this->search . '%')
                  ->orWhere('brand', 'like', '%' . $this->search . '%')
                  ->orWhere('model', 'like', '%' . $this->search . '%')
                  ->orWhere('color', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        // Apply maintenance due filter
        if ($this->showMaintenanceDue) {
            $query->where(function ($q) {
                $q->where('last_oil_change', '<=', now()->subDays(90))
                  ->orWhere('stnk_expiry', '<=', now()->addDays(30));
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $vehicles = $query->paginate(10);

        // Get maintenance notifications for all vehicles
        $maintenanceNotifications = [];
        foreach ($vehicles as $vehicle) {
            $notifications = $vehicle->getMaintenanceNotifications();
            if (!empty($notifications)) {
                $maintenanceNotifications[$vehicle->id] = $notifications;
            }
        }

        return view('livewire.admin.vehicle-list', [
            'vehicles' => $vehicles,
            'maintenanceNotifications' => $maintenanceNotifications,
            'statusOptions' => [
                Car::STATUS_AVAILABLE => 'Available',
                Car::STATUS_RENTED => 'Rented',
                Car::STATUS_MAINTENANCE => 'Maintenance',
                Car::STATUS_INACTIVE => 'Inactive',
            ],
        ]);
    }
}