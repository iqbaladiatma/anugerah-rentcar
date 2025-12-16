<?php

namespace App\Livewire\Public;

use App\Models\Car;
use App\Services\AvailabilityService;
use App\Services\BookingCalculatorService;
use Carbon\Carbon;
use Livewire\Component;

class QuickBookingForm extends Component
{
    public Car $car;
    public $startDate;
    public $endDate;
    public $withDriver = false;
    public $outOfTown = false;
    public $pickupLocation = '';
    public $returnLocation = '';
    public $notes = '';
    
    public $availability = null;
    public $pricing = null;
    public $isChecking = false;
    public $showBookingForm = false;

    protected $rules = [
        'startDate' => 'required|date|after_or_equal:today',
        'endDate' => 'required|date|after:startDate',
        'pickupLocation' => 'required|string|max:255',
        'returnLocation' => 'required|string|max:255',
        'notes' => 'nullable|string|max:1000',
    ];

    public function mount(Car $car)
    {
        $this->car = $car;
        $this->startDate = now()->format('Y-m-d');
        $this->endDate = now()->addDay()->format('Y-m-d');
        $this->pickupLocation = 'Office Location';
        $this->returnLocation = 'Office Location';
    }

    public function updatedStartDate()
    {
        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate);
            $endDate = Carbon::parse($this->endDate);
            
            if ($endDate <= $startDate) {
                $this->endDate = $startDate->copy()->addDay()->format('Y-m-d');
            }
            
            $this->checkAvailabilityAndPricing();
        }
    }

    public function updatedEndDate()
    {
        if ($this->startDate && $this->endDate) {
            $this->checkAvailabilityAndPricing();
        }
    }

    public function updatedWithDriver()
    {
        if ($this->startDate && $this->endDate) {
            $this->checkAvailabilityAndPricing();
        }
    }

    public function updatedOutOfTown()
    {
        if ($this->startDate && $this->endDate) {
            $this->checkAvailabilityAndPricing();
        }
    }

    public function checkAvailabilityAndPricing()
    {
        if (!$this->startDate || !$this->endDate) {
            return;
        }

        $this->isChecking = true;
        
        try {
            $startDate = Carbon::parse($this->startDate);
            $endDate = Carbon::parse($this->endDate);
            
            // Check availability
            $availabilityService = app(AvailabilityService::class);
            $this->availability = $availabilityService->checkAvailability(
                $this->car->id,
                $startDate,
                $endDate
            );
            
            // Calculate pricing if available
            if ($this->availability['is_available']) {
                $calculatorService = app(BookingCalculatorService::class);
                $this->pricing = $calculatorService->calculateBookingPrice([
                    'car_id' => $this->car->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'with_driver' => $this->withDriver,
                    'is_out_of_town' => $this->outOfTown,
                    'customer_id' => auth('customer')->id(),
                ]);
            } else {
                $this->pricing = null;
            }
            
        } catch (\Exception $e) {
            $this->availability = ['is_available' => false, 'error' => 'Failed to check availability'];
            $this->pricing = null;
        }
        
        $this->isChecking = false;
    }

    public function toggleBookingForm()
    {
        $this->showBookingForm = !$this->showBookingForm;
        
        if ($this->showBookingForm && (!$this->availability || !$this->availability['is_available'])) {
            $this->checkAvailabilityAndPricing();
        }
    }

    public function submitBooking()
    {
        $this->validate();
        
        if (!$this->availability || !$this->availability['is_available']) {
            session()->flash('error', 'Vehicle is no longer available for the selected dates.');
            return;
        }

        try {
            // Create booking (this would typically redirect to a full booking wizard)
            session()->flash('booking_data', [
                'car_id' => $this->car->id,
                'start_date' => $this->startDate,
                'end_date' => $this->endDate,
                'with_driver' => $this->withDriver,
                'is_out_of_town' => $this->outOfTown,
                'pickup_location' => $this->pickupLocation,
                'return_location' => $this->returnLocation,
                'notes' => $this->notes,
                'pricing' => $this->pricing,
            ]);
            
            // Redirect to booking wizard (to be implemented in task 21)
            return redirect()->route('customer.booking.create', ['car' => $this->car->id]);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to create booking. Please try again.');
        }
    }

    public function render()
    {
        return view('livewire.public.quick-booking-form');
    }
}