<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use App\Models\Customer;
use App\Models\User;
use App\Services\BookingCalculatorService;
use App\Services\AvailabilityService;
use Livewire\Component;
use Carbon\Carbon;

class BookingCalculator extends Component
{
    // Form fields
    public $customer_id = '';
    public $car_id = '';
    public $driver_id = '';
    public $start_date = '';
    public $end_date = '';
    public $pickup_location = '';
    public $return_location = '';
    public $with_driver = false;
    public $is_out_of_town = false;
    public $out_of_town_fee = 0;
    public $notes = '';

    // Calculated values
    public $pricing = [];
    public $availability = [];
    public $validation_errors = [];

    // Component state
    public $customers = [];
    public $cars = [];
    public $drivers = [];
    public $available_drivers = [];
    public $is_calculating = false;
    public $show_pricing = false;

    // Props
    public $booking_id = null; // For editing existing booking
    public $preselected = [];

    protected BookingCalculatorService $calculatorService;
    protected AvailabilityService $availabilityService;

    public function boot(
        BookingCalculatorService $calculatorService,
        AvailabilityService $availabilityService
    ) {
        $this->calculatorService = $calculatorService;
        $this->availabilityService = $availabilityService;
    }

    public function mount($bookingId = null, $preselected = [])
    {
        $this->booking_id = $bookingId;
        $this->preselected = $preselected;

        $this->loadData();
        $this->applyPreselected();
    }

    public function loadData()
    {
        $this->customers = Customer::active()
            ->select('id', 'name', 'phone', 'is_member', 'member_discount')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->cars = Car::available()
            ->select('id', 'license_plate', 'brand', 'model', 'daily_rate', 'weekly_rate', 'driver_fee_per_day', 'status')
            ->orderBy('license_plate')
            ->get()
            ->toArray();

        $this->drivers = User::drivers()
            ->active()
            ->select('id', 'name', 'phone')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    public function applyPreselected()
    {
        if (!empty($this->preselected)) {
            $this->customer_id = $this->preselected['customer_id'] ?? '';
            $this->car_id = $this->preselected['car_id'] ?? '';
            $this->start_date = $this->preselected['start_date'] ?? '';
            $this->end_date = $this->preselected['end_date'] ?? '';
        }
    }

    public function updatedCustomerId()
    {
        $this->calculatePricing();
    }

    public function updatedCarId()
    {
        $this->checkAvailability();
        $this->calculatePricing();
        $this->loadAvailableDrivers();
    }

    public function updatedStartDate()
    {
        $this->checkAvailability();
        $this->calculatePricing();
        $this->loadAvailableDrivers();
    }

    public function updatedEndDate()
    {
        $this->checkAvailability();
        $this->calculatePricing();
        $this->loadAvailableDrivers();
    }

    public function updatedWithDriver()
    {
        if (!$this->with_driver) {
            $this->driver_id = '';
        }
        $this->calculatePricing();
    }

    public function updatedIsOutOfTown()
    {
        if (!$this->is_out_of_town) {
            $this->out_of_town_fee = 0;
        }
        $this->calculatePricing();
    }

    public function updatedOutOfTownFee()
    {
        $this->calculatePricing();
    }

    public function checkAvailability()
    {
        if (empty($this->car_id) || empty($this->start_date) || empty($this->end_date)) {
            $this->availability = [];
            return;
        }

        try {
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            if ($startDate >= $endDate) {
                $this->availability = ['is_available' => false, 'error' => 'End date must be after start date'];
                return;
            }

            $this->availability = $this->availabilityService->checkAvailability(
                $this->car_id,
                $startDate,
                $endDate
            );

            // Exclude current booking from conflicts if editing
            if ($this->booking_id) {
                $this->availability['conflicts'] = $this->availability['conflicts']->where('id', '!=', $this->booking_id);
                $car = Car::find($this->car_id);
                $this->availability['is_available'] = $this->availability['conflicts']->isEmpty() && 
                                                    $car && $car->status === Car::STATUS_AVAILABLE;
            }

        } catch (\Exception $e) {
            $this->availability = ['is_available' => false, 'error' => 'Invalid date format'];
        }
    }

    public function calculatePricing()
    {
        if (empty($this->car_id) || empty($this->start_date) || empty($this->end_date)) {
            $this->pricing = [];
            $this->show_pricing = false;
            return;
        }

        $this->is_calculating = true;

        try {
            $params = [
                'car_id' => $this->car_id,
                'customer_id' => $this->customer_id ?: null,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'with_driver' => $this->with_driver,
                'is_out_of_town' => $this->is_out_of_town,
                'out_of_town_fee' => $this->out_of_town_fee ?: 0,
            ];

            $validation = $this->calculatorService->validateBookingParameters($params);
            
            if (!$validation['is_valid']) {
                $this->validation_errors = $validation['errors'];
                $this->pricing = [];
                $this->show_pricing = false;
            } else {
                $this->validation_errors = [];
                $this->pricing = $this->calculatorService->calculateBookingPrice($params);
                $this->show_pricing = true;

                $this->dispatch('pricingCalculated', array_merge($params, ['notes' => $this->notes]));
            }

        } catch (\Exception $e) {
            $this->validation_errors = ['Pricing calculation error: ' . $e->getMessage()];
            $this->pricing = [];
            $this->show_pricing = false;
        }

        $this->is_calculating = false;
    }

    public function loadAvailableDrivers()
    {
        if (empty($this->start_date) || empty($this->end_date)) {
            $this->available_drivers = $this->drivers;
            return;
        }

        try {
            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            // Get drivers without conflicting bookings
            $driversQuery = User::drivers()->active();

            $driversQuery->whereDoesntHave('driverBookings', function ($query) use ($startDate, $endDate) {
                $query->whereIn('booking_status', ['confirmed', 'active'])
                      ->where(function ($q) use ($startDate, $endDate) {
                          $q->whereBetween('start_date', [$startDate, $endDate])
                            ->orWhereBetween('end_date', [$startDate, $endDate])
                            ->orWhere(function ($subQ) use ($startDate, $endDate) {
                                $subQ->where('start_date', '<=', $startDate)
                                     ->where('end_date', '>=', $endDate);
                            });
                      });

                // Exclude current booking if editing
                if ($this->booking_id) {
                    $query->where('id', '!=', $this->booking_id);
                }
            });

            $this->available_drivers = $driversQuery
                ->select('id', 'name', 'phone')
                ->orderBy('name')
                ->get()
                ->toArray();

        } catch (\Exception $e) {
            $this->available_drivers = $this->drivers;
        }
    }

    public function getSelectedCustomer()
    {
        if (empty($this->customer_id)) {
            return null;
        }

        return collect($this->customers)->firstWhere('id', $this->customer_id);
    }

    public function getSelectedCar()
    {
        if (empty($this->car_id)) {
            return null;
        }

        return collect($this->cars)->firstWhere('id', $this->car_id);
    }

    public function getSelectedDriver()
    {
        if (empty($this->driver_id)) {
            return null;
        }

        return collect($this->available_drivers)->firstWhere('id', $this->driver_id);
    }

    public function getDurationText()
    {
        if (empty($this->pricing['duration_days'])) {
            return '';
        }

        $days = $this->pricing['duration_days'];
        $hours = $this->pricing['duration_hours'] ?? 0;

        if ($days == 1) {
            return "1 day ({$hours} hours)";
        }

        return "{$days} days ({$hours} hours)";
    }

    public function getAvailabilityStatusClass()
    {
        if (empty($this->availability)) {
            return 'text-gray-500';
        }

        return $this->availability['is_available'] ? 'text-green-600' : 'text-red-600';
    }

    public function getAvailabilityStatusText()
    {
        if (empty($this->availability)) {
            return 'Check availability';
        }

        if (isset($this->availability['error'])) {
            return $this->availability['error'];
        }

        if ($this->availability['is_available']) {
            return 'Available';
        }

        $conflicts = $this->availability['conflicts'] ?? collect();
        if ($conflicts->isNotEmpty()) {
            $conflict = $conflicts->first();
            return "Booked by {$conflict->customer->name} ({$conflict->booking_number})";
        }

        return 'Not available';
    }

    public function resetForm()
    {
        $this->reset([
            'customer_id', 'car_id', 'driver_id', 'start_date', 'end_date',
            'pickup_location', 'return_location', 'with_driver', 'is_out_of_town',
            'out_of_town_fee', 'notes', 'pricing', 'availability', 'validation_errors'
        ]);
        
        $this->show_pricing = false;
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.admin.booking-calculator');
    }
}