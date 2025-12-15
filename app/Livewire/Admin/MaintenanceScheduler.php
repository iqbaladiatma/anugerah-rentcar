<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use App\Models\Maintenance;
use Livewire\Component;
use Carbon\Carbon;

class MaintenanceScheduler extends Component
{
    public $carId = '';
    public $maintenanceType = 'routine';
    public $description = '';
    public $scheduledDate = '';
    public $estimatedCost = '';
    public $serviceProvider = '';
    public $showScheduleForm = false;

    protected $rules = [
        'carId' => 'required|exists:cars,id',
        'maintenanceType' => 'required|in:routine,repair,inspection',
        'description' => 'required|string|max:1000',
        'scheduledDate' => 'required|date|after:today',
        'estimatedCost' => 'nullable|numeric|min:0|max:999999.99',
        'serviceProvider' => 'required|string|max:255',
    ];

    protected $messages = [
        'carId.required' => 'Please select a vehicle.',
        'carId.exists' => 'Selected vehicle is invalid.',
        'maintenanceType.required' => 'Please select maintenance type.',
        'description.required' => 'Description is required.',
        'scheduledDate.required' => 'Scheduled date is required.',
        'scheduledDate.after' => 'Scheduled date must be in the future.',
        'serviceProvider.required' => 'Service provider is required.',
    ];

    public function mount()
    {
        $this->scheduledDate = Carbon::now()->addDays(7)->format('Y-m-d');
    }

    public function toggleScheduleForm()
    {
        $this->showScheduleForm = !$this->showScheduleForm;
        
        if (!$this->showScheduleForm) {
            $this->resetForm();
        }
    }

    public function resetForm()
    {
        $this->carId = '';
        $this->maintenanceType = 'routine';
        $this->description = '';
        $this->scheduledDate = Carbon::now()->addDays(7)->format('Y-m-d');
        $this->estimatedCost = '';
        $this->serviceProvider = '';
        $this->resetErrorBag();
    }

    public function scheduleMaintenance()
    {
        $this->validate();

        try {
            // Create maintenance record with future date
            $maintenance = Maintenance::create([
                'car_id' => $this->carId,
                'maintenance_type' => $this->maintenanceType,
                'description' => $this->description,
                'cost' => $this->estimatedCost ?? 0,
                'service_date' => $this->scheduledDate,
                'next_service_date' => null,
                'odometer_at_service' => 0, // Will be updated when actual service is done
                'service_provider' => $this->serviceProvider,
            ]);

            // Mark car as scheduled for maintenance if date is soon
            $car = Car::find($this->carId);
            if (Carbon::parse($this->scheduledDate)->diffInDays(Carbon::now()) <= 3) {
                $car->markAsInMaintenance();
            }

            session()->flash('success', 'Maintenance scheduled successfully for ' . $car->license_plate);
            
            $this->resetForm();
            $this->showScheduleForm = false;
            
            // Emit event to refresh other components
            $this->dispatch('maintenanceScheduled');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to schedule maintenance: ' . $e->getMessage());
        }
    }

    public function quickScheduleOilChange($carId)
    {
        $car = Car::find($carId);
        
        if (!$car) {
            session()->flash('error', 'Vehicle not found.');
            return;
        }

        try {
            $maintenance = Maintenance::create([
                'car_id' => $carId,
                'maintenance_type' => 'routine',
                'description' => 'Scheduled oil change and routine maintenance',
                'cost' => 0, // Will be updated when completed
                'service_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'next_service_date' => null,
                'odometer_at_service' => 0,
                'service_provider' => 'TBD',
            ]);

            session()->flash('success', 'Oil change scheduled for ' . $car->license_plate);
            
            // Emit event to refresh other components
            $this->dispatch('maintenanceScheduled');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to schedule oil change: ' . $e->getMessage());
        }
    }

    public function quickScheduleStnkRenewal($carId)
    {
        $car = Car::find($carId);
        
        if (!$car) {
            session()->flash('error', 'Vehicle not found.');
            return;
        }

        try {
            $maintenance = Maintenance::create([
                'car_id' => $carId,
                'maintenance_type' => 'inspection',
                'description' => 'STNK renewal and vehicle inspection',
                'cost' => 0, // Will be updated when completed
                'service_date' => Carbon::parse($car->stnk_expiry)->subDays(7)->format('Y-m-d'),
                'next_service_date' => null,
                'odometer_at_service' => 0,
                'service_provider' => 'Samsat',
            ]);

            session()->flash('success', 'STNK renewal scheduled for ' . $car->license_plate);
            
            // Emit event to refresh other components
            $this->dispatch('maintenanceScheduled');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to schedule STNK renewal: ' . $e->getMessage());
        }
    }

    public function getCarsProperty()
    {
        return Car::orderBy('license_plate')->get();
    }

    public function getMaintenanceTypesProperty()
    {
        return [
            'routine' => 'Routine Maintenance',
            'repair' => 'Repair',
            'inspection' => 'Inspection',
        ];
    }

    public function getUpcomingMaintenanceProperty()
    {
        return Maintenance::with(['car'])
            ->where('service_date', '>', Carbon::now())
            ->orderBy('service_date', 'asc')
            ->limit(10)
            ->get();
    }

    public function getOverdueMaintenanceProperty()
    {
        return Maintenance::overdue()
            ->with(['car'])
            ->orderBy('next_service_date', 'asc')
            ->get();
    }

    public function getDueSoonMaintenanceProperty()
    {
        return Maintenance::dueSoon(7)
            ->with(['car'])
            ->orderBy('next_service_date', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.maintenance-scheduler', [
            'cars' => $this->cars,
            'maintenanceTypes' => $this->maintenanceTypes,
            'upcomingMaintenance' => $this->upcomingMaintenance,
            'overdueMaintenance' => $this->overdueMaintenance,
            'dueSoonMaintenance' => $this->dueSoonMaintenance,
        ]);
    }
}