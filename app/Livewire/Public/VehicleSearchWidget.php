<?php

namespace App\Livewire\Public;

use App\Models\Car;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Livewire\Component;

class VehicleSearchWidget extends Component
{
    public $startDate = '';
    public $endDate = '';
    public $location = '';
    public $withDriver = false;

    protected $rules = [
        'startDate' => 'required|date|after_or_equal:today',
        'endDate' => 'required|date|after:startDate',
        'location' => 'nullable|string|max:255',
    ];

    protected $messages = [
        'startDate.required' => 'Please select a pickup date',
        'startDate.after_or_equal' => 'Pickup date must be today or later',
        'endDate.required' => 'Please select a return date',
        'endDate.after' => 'Return date must be after pickup date',
    ];

    public function mount()
    {
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDays(1)->format('Y-m-d');
    }

    public function searchVehicles()
    {
        $this->validate();

        $queryParams = [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
        ];

        if ($this->withDriver) {
            $queryParams['with_driver'] = '1';
        }

        if ($this->location) {
            $queryParams['location'] = $this->location;
        }

        return redirect()->route('vehicles.catalog', $queryParams);
    }

    public function updatedStartDate()
    {
        // Auto-update end date if it's before or same as start date
        if ($this->endDate && $this->startDate >= $this->endDate) {
            $this->endDate = \Carbon\Carbon::parse($this->startDate)->addDay()->format('Y-m-d');
        }
    }

    public function render()
    {
        return view('livewire.public.vehicle-search-widget');
    }
}