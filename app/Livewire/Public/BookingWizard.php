<?php

namespace App\Livewire\Public;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Booking;
use App\Services\BookingCalculatorService;
use App\Services\AvailabilityService;
use App\Traits\HandlesSecureFileUploads;
use App\Rules\EnhancedFileUpload;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookingWizard extends Component
{
    use WithFileUploads, HandlesSecureFileUploads;

    // Wizard state
    public $currentStep = 1;
    public $totalSteps = 5;

    // Step 1: Vehicle Selection
    public $selectedCarId;
    public $startDate;
    public $endDate;
    public $withDriver = false;
    public $isOutOfTown = false;
    public $outOfTownFee = 0;
    public $pickupLocation = '';
    public $returnLocation = '';

    // Step 2: Pricing Calculation
    public $pricingData = [];

    // Step 3: Customer Registration/Login
    public $isExistingCustomer = false;
    public $customerEmail = '';
    public $customerPassword = '';
    public $customerName = '';
    public $customerPhone = '';
    public $customerNik = '';
    public $customerAddress = '';
    public $customerPasswordConfirmation = '';

    // Step 4: Document Upload
    public $ktpPhoto;
    public $simPhoto;
    public $ktpPhotoPreview;
    public $simPhotoPreview;

    // Step 5: Payment Method
    public $paymentMethod = 'bank_transfer';
    public $notes = '';

    // Component state
    public $car;
    public $customer;
    public $booking;
    public $availableCars = [];
    public $errors = [];

    protected $bookingCalculatorService;
    protected $availabilityService;

    public function boot(
        BookingCalculatorService $bookingCalculatorService,
        AvailabilityService $availabilityService
    ) {
        $this->bookingCalculatorService = $bookingCalculatorService;
        $this->availabilityService = $availabilityService;
    }

    public function mount($carId = null, $startDate = null, $endDate = null)
    {
        // Initialize from URL parameters or session
        $this->selectedCarId = $carId ?? session('booking.car_id');
        $this->startDate = $startDate ?? session('booking.start_date', now()->addDay()->format('Y-m-d'));
        $this->endDate = $endDate ?? session('booking.end_date', now()->addDays(2)->format('Y-m-d'));
        
        // Set default locations
        $this->pickupLocation = 'Office - Jl. Raya Utama No. 123';
        $this->returnLocation = 'Office - Jl. Raya Utama No. 123';

        // Load initial data
        $this->loadAvailableCars();
        
        if ($this->selectedCarId) {
            $this->loadSelectedCar();
        }

        // Check if customer is already logged in
        if (Auth::guard('customer')->check()) {
            $this->customer = Auth::guard('customer')->user();
            $this->isExistingCustomer = true;
            $this->customerEmail = $this->customer->email;
            $this->customerName = $this->customer->name;
            $this->customerPhone = $this->customer->phone;
            $this->customerNik = $this->customer->nik;
            $this->customerAddress = $this->customer->address;
        }
    }

    public function loadAvailableCars()
    {
        if (!$this->startDate || !$this->endDate) {
            return;
        }

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        $this->availableCars = Car::where('status', 'available')
            ->whereDoesntHave('bookings', function ($query) use ($startDate, $endDate) {
                $query->whereIn('booking_status', ['confirmed', 'active'])
                    ->where(function ($q) use ($startDate, $endDate) {
                        $q->whereBetween('start_date', [$startDate, $endDate])
                          ->orWhereBetween('end_date', [$startDate, $endDate])
                          ->orWhere(function ($subQ) use ($startDate, $endDate) {
                              $subQ->where('start_date', '<=', $startDate)
                                   ->where('end_date', '>=', $endDate);
                          });
                    });
            })
            ->orderBy('daily_rate')
            ->get();
    }

    public function loadSelectedCar()
    {
        $this->car = Car::find($this->selectedCarId);
        if ($this->car) {
            $this->calculatePricing();
        }
    }

    public function calculatePricing()
    {
        if (!$this->selectedCarId || !$this->startDate || !$this->endDate) {
            return;
        }

        $params = [
            'car_id' => $this->selectedCarId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'with_driver' => $this->withDriver,
            'is_out_of_town' => $this->isOutOfTown,
            'out_of_town_fee' => $this->outOfTownFee,
            'customer_id' => $this->customer?->id,
        ];

        $this->pricingData = $this->bookingCalculatorService->calculateBookingPrice($params);
    }

    public function updatedStartDate()
    {
        $this->loadAvailableCars();
        $this->calculatePricing();
        $this->validateDates();
    }

    public function updatedEndDate()
    {
        $this->loadAvailableCars();
        $this->calculatePricing();
        $this->validateDates();
    }

    public function updatedSelectedCarId()
    {
        $this->loadSelectedCar();
        session(['booking.car_id' => $this->selectedCarId]);
    }

    public function updatedWithDriver()
    {
        $this->calculatePricing();
    }

    public function updatedIsOutOfTown()
    {
        if (!$this->isOutOfTown) {
            $this->outOfTownFee = 0;
        }
        $this->calculatePricing();
    }

    public function updatedOutOfTownFee()
    {
        $this->calculatePricing();
    }

    public function validateDates()
    {
        $errors = [];

        if ($this->startDate && Carbon::parse($this->startDate) < Carbon::now()) {
            $errors['startDate'] = 'Start date cannot be in the past';
        }

        if ($this->startDate && $this->endDate && Carbon::parse($this->startDate) >= Carbon::parse($this->endDate)) {
            $errors['endDate'] = 'End date must be after start date';
        }

        $this->errors = array_merge($this->errors, $errors);
    }

    public function nextStep()
    {
        $this->validateCurrentStep();

        if (empty($this->errors)) {
            $this->currentStep++;
            $this->saveProgressToSession();
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

    public function validateCurrentStep()
    {
        $this->errors = [];

        switch ($this->currentStep) {
            case 1:
                $this->validateStep1();
                break;
            case 2:
                $this->validateStep2();
                break;
            case 3:
                $this->validateStep3();
                break;
            case 4:
                $this->validateStep4();
                break;
            case 5:
                $this->validateStep5();
                break;
        }
    }

    public function validateStep1()
    {
        if (!$this->selectedCarId) {
            $this->errors['selectedCarId'] = 'Please select a vehicle';
        }

        if (!$this->startDate) {
            $this->errors['startDate'] = 'Start date is required';
        }

        if (!$this->endDate) {
            $this->errors['endDate'] = 'End date is required';
        }

        if (!$this->pickupLocation) {
            $this->errors['pickupLocation'] = 'Pickup location is required';
        }

        if (!$this->returnLocation) {
            $this->errors['returnLocation'] = 'Return location is required';
        }

        $this->validateDates();

        // Check availability
        if ($this->selectedCarId && $this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate);
            $endDate = Carbon::parse($this->endDate);
            
            $availability = $this->availabilityService->checkAvailability($this->selectedCarId, $startDate, $endDate);
            if (!$availability['is_available']) {
                $this->errors['availability'] = 'Selected vehicle is not available for the chosen dates';
            }
        }
    }

    public function validateStep2()
    {
        // Pricing validation is automatic
        if (empty($this->pricingData) || isset($this->pricingData['error'])) {
            $this->errors['pricing'] = 'Unable to calculate pricing. Please check your selections.';
        }
    }

    public function validateStep3()
    {
        if ($this->isExistingCustomer) {
            if (!$this->customerEmail) {
                $this->errors['customerEmail'] = 'Email is required';
            }
            if (!$this->customerPassword) {
                $this->errors['customerPassword'] = 'Password is required';
            }
        } else {
            if (!$this->customerName) {
                $this->errors['customerName'] = 'Name is required';
            }
            if (!$this->customerEmail) {
                $this->errors['customerEmail'] = 'Email is required';
            } elseif (!filter_var($this->customerEmail, FILTER_VALIDATE_EMAIL)) {
                $this->errors['customerEmail'] = 'Please enter a valid email address';
            } elseif (Customer::where('email', $this->customerEmail)->exists()) {
                $this->errors['customerEmail'] = 'Email already exists. Please login instead.';
            }
            if (!$this->customerPhone) {
                $this->errors['customerPhone'] = 'Phone number is required';
            }
            if (!$this->customerNik) {
                $this->errors['customerNik'] = 'NIK is required';
            } elseif (strlen($this->customerNik) !== 16) {
                $this->errors['customerNik'] = 'NIK must be 16 digits';
            } elseif (Customer::where('nik', $this->customerNik)->exists()) {
                $this->errors['customerNik'] = 'NIK already registered';
            }
            if (!$this->customerAddress) {
                $this->errors['customerAddress'] = 'Address is required';
            }
            if (!$this->customerPassword) {
                $this->errors['customerPassword'] = 'Password is required';
            } elseif (strlen($this->customerPassword) < 8) {
                $this->errors['customerPassword'] = 'Password must be at least 8 characters';
            }
            if ($this->customerPassword !== $this->customerPasswordConfirmation) {
                $this->errors['customerPasswordConfirmation'] = 'Password confirmation does not match';
            }
        }
    }

    public function validateStep4()
    {
        if (!$this->customer) {
            $this->errors['customer'] = 'Customer information is required';
            return;
        }

        // Check if customer already has documents uploaded
        if (!$this->customer->ktp_photo && !$this->ktpPhoto) {
            $this->errors['ktpPhoto'] = 'KTP photo is required';
        }

        if (!$this->customer->sim_photo && !$this->simPhoto) {
            $this->errors['simPhoto'] = 'SIM photo is required';
        }

        // Enhanced security validation for document uploads
        if ($this->ktpPhoto) {
            $validator = validator(['ktpPhoto' => $this->ktpPhoto], [
                'ktpPhoto' => EnhancedFileUpload::customerDocument()
            ]);
            
            if ($validator->fails()) {
                foreach ($validator->errors()->get('ktpPhoto') as $error) {
                    $this->addError('ktpPhoto', $error);
                }
            }
        }

        if ($this->simPhoto) {
            $validator = validator(['simPhoto' => $this->simPhoto], [
                'simPhoto' => EnhancedFileUpload::customerDocument()
            ]);
            
            if ($validator->fails()) {
                foreach ($validator->errors()->get('simPhoto') as $error) {
                    $this->addError('simPhoto', $error);
                }
            }
        }
    }

    public function validateStep5()
    {
        if (!$this->paymentMethod) {
            $this->errors['paymentMethod'] = 'Please select a payment method';
        }
    }

    public function authenticateCustomer()
    {
        if (!$this->customerEmail || !$this->customerPassword) {
            $this->errors['authentication'] = 'Email and password are required';
            return;
        }

        $customer = Customer::where('email', $this->customerEmail)->first();

        if (!$customer || !Hash::check($this->customerPassword, $customer->password)) {
            $this->errors['authentication'] = 'Invalid email or password';
            return;
        }

        if ($customer->is_blacklisted) {
            $this->errors['authentication'] = 'Your account is restricted. Please contact support.';
            return;
        }

        $this->customer = $customer;
        Auth::guard('customer')->login($customer);
        
        // Update customer info in form
        $this->customerName = $customer->name;
        $this->customerPhone = $customer->phone;
        $this->customerNik = $customer->nik;
        $this->customerAddress = $customer->address;

        // Recalculate pricing with member discount
        $this->calculatePricing();

        $this->nextStep();
    }

    public function registerCustomer()
    {
        $this->validateStep3();

        if (!empty($this->errors)) {
            return;
        }

        $customer = Customer::create([
            'name' => $this->customerName,
            'email' => $this->customerEmail,
            'phone' => $this->customerPhone,
            'nik' => $this->customerNik,
            'address' => $this->customerAddress,
            'password' => Hash::make($this->customerPassword),
        ]);

        $this->customer = $customer;
        Auth::guard('customer')->login($customer);

        $this->nextStep();
    }

    public function uploadDocuments()
    {
        $this->validateStep4();

        if (!empty($this->errors)) {
            return;
        }

        $updates = [];

        // Upload KTP photo if provided
        if ($this->ktpPhoto) {
            $result = $this->uploadCustomerDocument($this->ktpPhoto, $this->customer->nik, 'ktp');
            if ($result['success']) {
                $updates['ktp_photo'] = $result['path'];
            } else {
                foreach ($result['errors'] as $error) {
                    $this->addError('ktpPhoto', $error);
                }
                return;
            }
        }

        // Upload SIM photo if provided
        if ($this->simPhoto) {
            $result = $this->uploadCustomerDocument($this->simPhoto, $this->customer->nik, 'sim');
            if ($result['success']) {
                $updates['sim_photo'] = $result['path'];
            } else {
                foreach ($result['errors'] as $error) {
                    $this->addError('simPhoto', $error);
                }
                return;
            }
        }

        if (!empty($updates)) {
            $this->customer->update($updates);
        }

        $this->nextStep();
    }

    public function createBooking()
    {
        $this->validateCurrentStep();

        if (!empty($this->errors)) {
            return;
        }

        // Generate booking number
        $bookingNumber = 'BK' . date('Ymd') . str_pad(Booking::whereDate('created_at', today())->count() + 1, 3, '0', STR_PAD_LEFT);

        // Create the booking
        $this->booking = Booking::create([
            'booking_number' => $bookingNumber,
            'customer_id' => $this->customer->id,
            'car_id' => $this->selectedCarId,
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'pickup_location' => $this->pickupLocation,
            'return_location' => $this->returnLocation,
            'with_driver' => $this->withDriver,
            'is_out_of_town' => $this->isOutOfTown,
            'out_of_town_fee' => $this->outOfTownFee,
            'base_amount' => $this->pricingData['base_amount'] ?? 0,
            'driver_fee' => $this->pricingData['driver_fee'] ?? 0,
            'member_discount' => $this->pricingData['member_discount'] ?? 0,
            'total_amount' => $this->pricingData['total_amount'] ?? 0,
            'deposit_amount' => $this->pricingData['deposit_amount'] ?? 0,
            'payment_status' => Booking::PAYMENT_PENDING,
            'booking_status' => Booking::STATUS_PENDING,
            'notes' => $this->notes,
        ]);

        // Clear session data
        session()->forget(['booking.car_id', 'booking.start_date', 'booking.end_date']);

        // Redirect to booking confirmation
        return redirect()->route('customer.bookings')->with('success', 'Booking created successfully! Booking number: ' . $this->booking->booking_number);
    }

    public function saveProgressToSession()
    {
        session([
            'booking.car_id' => $this->selectedCarId,
            'booking.start_date' => $this->startDate,
            'booking.end_date' => $this->endDate,
            'booking.step' => $this->currentStep,
        ]);
    }

    public function updatedKtpPhoto()
    {
        if ($this->ktpPhoto) {
            $this->ktpPhotoPreview = $this->ktpPhoto->temporaryUrl();
        }
    }

    public function updatedSimPhoto()
    {
        if ($this->simPhoto) {
            $this->simPhotoPreview = $this->simPhoto->temporaryUrl();
        }
    }

    public function removeKtpPhoto()
    {
        $this->ktpPhoto = null;
        $this->ktpPhotoPreview = null;
    }

    public function removeSimPhoto()
    {
        $this->simPhoto = null;
        $this->simPhotoPreview = null;
    }

    public function render()
    {
        return view('livewire.public.booking-wizard')->layout('components.public-layout');
    }
}