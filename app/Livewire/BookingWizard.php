<?php

namespace App\Livewire;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Booking;
use App\Services\BookingCalculatorService;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookingWizard extends Component
{
    use WithFileUploads;

    // Wizard state
    public $currentStep = 1;
    public $totalSteps = 4;

    // Vehicle and booking data
    public $car;
    public $startDate;
    public $endDate;
    public $duration;
    public $pricing = [];

    // Step 1: Booking details
    public $pickupLocation = '';
    public $returnLocation = '';
    public $withDriver = false;
    public $isOutOfTown = false;
    public $notes = '';

    // Step 2: Customer information
    public $customerType = 'existing'; // 'existing' or 'new'
    public $existingCustomerId = null;
    public $existingCustomers = [];
    public $customerSearch = '';

    // New customer data
    public $customerName = '';
    public $customerPhone = '';
    public $customerEmail = '';
    public $customerNik = '';
    public $customerAddress = '';

    // Step 3: Document upload
    public $ktpPhoto;
    public $simPhoto;
    public $ktpPhotoPath = '';
    public $simPhotoPath = '';

    // Step 4: Payment method
    public $paymentMethod = 'bank_transfer';

    protected $rules = [
        'pickupLocation' => 'required|string|max:255',
        'returnLocation' => 'required|string|max:255',
        'customerName' => 'required_if:customerType,new|string|max:255',
        'customerPhone' => 'required_if:customerType,new|string|max:20',
        'customerEmail' => 'nullable|email|max:255',
        'customerNik' => 'required_if:customerType,new|string|size:16|unique:customers,nik',
        'customerAddress' => 'required_if:customerType,new|string|max:500',
        'existingCustomerId' => 'required_if:customerType,existing|exists:customers,id',
        'ktpPhoto' => 'required|image|max:2048',
        'simPhoto' => 'required|image|max:2048',
    ];

    protected $messages = [
        'ktpPhoto.required' => 'KTP photo is required for identity verification.',
        'simPhoto.required' => 'Driving license photo is required.',
        'customerNik.size' => 'NIK must be exactly 16 digits.',
        'customerNik.unique' => 'This NIK is already registered in our system.',
    ];

    public function mount($carId, $startDate, $endDate)
    {
        $this->car = Car::findOrFail($carId);
        $this->startDate = Carbon::parse($startDate);
        $this->endDate = Carbon::parse($endDate);
        $this->duration = $this->startDate->diffInDays($this->endDate) + 1;
        
        $this->calculatePricing();
        $this->loadExistingCustomers();
    }

    public function calculatePricing()
    {
        $calculator = app(BookingCalculatorService::class);
        $this->pricing = $calculator->calculatePrice(
            $this->car,
            $this->startDate,
            $this->endDate,
            $this->withDriver,
            $this->isOutOfTown
        );
    }

    public function loadExistingCustomers()
    {
        $this->existingCustomers = Customer::where('is_blacklisted', false)
            ->when($this->customerSearch, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->customerSearch . '%')
                      ->orWhere('phone', 'like', '%' . $this->customerSearch . '%')
                      ->orWhere('nik', 'like', '%' . $this->customerSearch . '%');
                });
            })
            ->orderBy('name')
            ->limit(10)
            ->get();
    }

    public function updatedCustomerSearch()
    {
        $this->loadExistingCustomers();
    }

    public function updatedWithDriver()
    {
        $this->calculatePricing();
    }

    public function updatedIsOutOfTown()
    {
        $this->calculatePricing();
    }

    public function nextStep()
    {
        $this->validateCurrentStep();
        
        if ($this->currentStep < $this->totalSteps) {
            $this->currentStep++;
        }
    }

    public function previousStep()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }

    public function goToStep($step)
    {
        if ($step <= $this->currentStep || $step == 1) {
            $this->currentStep = $step;
        }
    }

    private function validateCurrentStep()
    {
        switch ($this->currentStep) {
            case 1:
                $this->validate([
                    'pickupLocation' => 'required|string|max:255',
                    'returnLocation' => 'required|string|max:255',
                ]);
                break;
            
            case 2:
                if ($this->customerType === 'new') {
                    $this->validate([
                        'customerName' => 'required|string|max:255',
                        'customerPhone' => 'required|string|max:20',
                        'customerNik' => 'required|string|size:16|unique:customers,nik',
                        'customerAddress' => 'required|string|max:500',
                    ]);
                } else {
                    $this->validate([
                        'existingCustomerId' => 'required|exists:customers,id',
                    ]);
                }
                break;
            
            case 3:
                $this->validate([
                    'ktpPhoto' => 'required|image|max:2048',
                    'simPhoto' => 'required|image|max:2048',
                ]);
                $this->uploadDocuments();
                break;
        }
    }

    private function uploadDocuments()
    {
        if ($this->ktpPhoto && !$this->ktpPhotoPath) {
            $filename = 'ktp_' . Str::random(10) . '.' . $this->ktpPhoto->getClientOriginalExtension();
            $this->ktpPhotoPath = $this->ktpPhoto->storeAs('documents/ktp', $filename, 'public');
        }

        if ($this->simPhoto && !$this->simPhotoPath) {
            $filename = 'sim_' . Str::random(10) . '.' . $this->simPhoto->getClientOriginalExtension();
            $this->simPhotoPath = $this->simPhoto->storeAs('documents/sim', $filename, 'public');
        }
    }

    public function completeBooking()
    {
        $this->validateCurrentStep();

        // Create or get customer
        if ($this->customerType === 'new') {
            $customer = Customer::create([
                'name' => $this->customerName,
                'phone' => $this->customerPhone,
                'email' => $this->customerEmail,
                'nik' => $this->customerNik,
                'address' => $this->customerAddress,
                'ktp_photo' => $this->ktpPhotoPath,
                'sim_photo' => $this->simPhotoPath,
            ]);
        } else {
            $customer = Customer::findOrFail($this->existingCustomerId);
            // Update documents for existing customer
            $customer->update([
                'ktp_photo' => $this->ktpPhotoPath,
                'sim_photo' => $this->simPhotoPath,
            ]);
        }

        // Final availability check
        $availabilityService = app(AvailabilityService::class);
        $availability = $availabilityService->checkAvailability($this->car->id, $this->startDate, $this->endDate);
        
        if (!$availability['available']) {
            session()->flash('error', 'Vehicle is no longer available for the selected dates.');
            return;
        }

        // Recalculate pricing with customer discount
        $calculator = app(BookingCalculatorService::class);
        $finalPricing = $calculator->calculatePrice(
            $this->car,
            $this->startDate,
            $this->endDate,
            $this->withDriver,
            $this->isOutOfTown,
            $customer
        );

        // Create booking
        $booking = Booking::create([
            'booking_number' => 'BK' . date('Ymd') . str_pad(Booking::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT),
            'customer_id' => $customer->id,
            'car_id' => $this->car->id,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'pickup_location' => $this->pickupLocation,
            'return_location' => $this->returnLocation,
            'with_driver' => $this->withDriver,
            'is_out_of_town' => $this->isOutOfTown,
            'out_of_town_fee' => $finalPricing['out_of_town_fee'],
            'base_amount' => $finalPricing['base_amount'],
            'driver_fee' => $finalPricing['driver_fee'],
            'member_discount' => $finalPricing['member_discount'],
            'total_amount' => $finalPricing['total_amount'],
            'deposit_amount' => $finalPricing['deposit_amount'],
            'payment_status' => Booking::PAYMENT_STATUS_PENDING,
            'booking_status' => Booking::BOOKING_STATUS_PENDING,
            'notes' => $this->notes,
        ]);

        return redirect()->route('booking.confirmation', $booking)
            ->with('success', 'Booking created successfully! Please complete payment to confirm your reservation.');
    }

    public function render()
    {
        return view('livewire.booking-wizard');
    }
}