<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\User;
use App\Services\BookingCalculatorService;
use App\Services\AvailabilityService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WalkinBookingForm extends Component
{
    use WithFileUploads;

    // Customer Mode: 'existing' or 'new'
    public $customer_mode = 'existing';
    
    // Existing Customer
    public $customer_id = '';
    public $customer_search = '';
    
    // New Customer Data
    public $new_customer_name = '';
    public $new_customer_phone = '';
    public $new_customer_email = '';
    public $new_customer_id_number = '';
    public $new_customer_address = '';

    // Booking Details
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
    
    // Member Discount Toggle
    public $apply_member_discount = true;

    // Payment Info
    public $payment_type = 'full';
    public $payment_status = 'paid';
    public $paid_amount = 0;
    public $deposit_amount = 0;
    public $payment_notes = '';

    // Booking Status
    public $booking_status = 'confirmed';

    // Calculated values
    public $pricing = [];
    public $availability = [];
    public $validation_errors = [];

    // Component state
    public $cars = [];
    public $customers = [];
    public $drivers = [];
    public $available_drivers = [];
    public $is_calculating = false;
    public $show_pricing = false;
    public $show_modal = false;

    protected BookingCalculatorService $calculatorService;
    protected AvailabilityService $availabilityService;

    protected $listeners = ['openWalkinModal' => 'openModal'];

    public function boot(
        BookingCalculatorService $calculatorService,
        AvailabilityService $availabilityService
    ) {
        $this->calculatorService = $calculatorService;
        $this->availabilityService = $availabilityService;
    }

    public function mount()
    {
        $this->loadData();
        $this->start_date = Carbon::now()->format('Y-m-d\TH:i');
        $this->end_date = Carbon::now()->addDay()->format('Y-m-d\TH:i');
    }

    public function loadData()
    {
        $this->cars = Car::where('status', Car::STATUS_AVAILABLE)
            ->select('id', 'license_plate', 'brand', 'model', 'daily_rate', 'weekly_rate', 'driver_fee_per_day', 'status')
            ->orderBy('license_plate')
            ->get()
            ->toArray();

        $this->customers = Customer::where('is_blacklisted', false)
            ->select('id', 'name', 'phone', 'email', 'is_member')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->drivers = User::drivers()
            ->active()
            ->select('id', 'name', 'phone')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->available_drivers = $this->drivers;
    }

    public function openModal()
    {
        $this->resetForm();
        $this->loadData();
        $this->show_modal = true;
    }

    public function closeModal()
    {
        $this->show_modal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'customer_mode', 'customer_id', 'customer_search',
            'new_customer_name', 'new_customer_phone', 'new_customer_email', 
            'new_customer_id_number', 'new_customer_address',
            'car_id', 'driver_id', 'pickup_location', 'return_location',
            'with_driver', 'is_out_of_town', 'out_of_town_fee', 'notes',
            'payment_notes', 'pricing', 'availability', 'validation_errors'
        ]);
        
        $this->customer_mode = 'existing';
        $this->apply_member_discount = true;
        $this->payment_type = 'full';
        $this->payment_status = 'paid';
        $this->booking_status = 'confirmed';
        $this->paid_amount = 0;
        $this->deposit_amount = 0;
        $this->show_pricing = false;
        $this->start_date = Carbon::now()->format('Y-m-d\TH:i');
        $this->end_date = Carbon::now()->addDay()->format('Y-m-d\TH:i');
    }

    public function updatedCustomerMode()
    {
        // Reset customer fields when switching mode
        $this->customer_id = '';
        $this->customer_search = '';
        $this->new_customer_name = '';
        $this->new_customer_phone = '';
        $this->new_customer_email = '';
        $this->new_customer_id_number = '';
        $this->new_customer_address = '';
        
        // Recalculate pricing for member discount
        $this->calculatePricing();
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

    public function updatedApplyMemberDiscount()
    {
        $this->calculatePricing();
    }

    public function updatedPaymentType()
    {
        if ($this->payment_type === 'full' && !empty($this->pricing)) {
            $this->paid_amount = $this->pricing['total_amount'] ?? 0;
        } elseif ($this->payment_type === 'deposit' && !empty($this->pricing)) {
            $this->paid_amount = $this->pricing['deposit_amount'] ?? 0;
        }
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
                $this->availability = ['is_available' => false, 'error' => 'Tanggal selesai harus setelah tanggal mulai'];
                return;
            }

            $this->availability = $this->availabilityService->checkAvailability(
                $this->car_id,
                $startDate,
                $endDate
            );

        } catch (\Exception $e) {
            $this->availability = ['is_available' => false, 'error' => 'Format tanggal tidak valid'];
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
            // Use customer_id for member discount if selecting existing customer AND discount is enabled
            $customerId = null;
            if ($this->customer_mode === 'existing' && $this->customer_id && $this->apply_member_discount) {
                $customerId = $this->customer_id;
            }
            
            $params = [
                'car_id' => $this->car_id,
                'customer_id' => $customerId,
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

                if ($this->payment_type === 'full') {
                    $this->paid_amount = $this->pricing['total_amount'];
                } else {
                    $this->paid_amount = $this->pricing['deposit_amount'];
                }
                $this->deposit_amount = $this->pricing['deposit_amount'];
            }

        } catch (\Exception $e) {
            $this->validation_errors = ['Error kalkulasi harga: ' . $e->getMessage()];
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
        return collect($this->customers)->firstWhere('id', (int)$this->customer_id);
    }

    public function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    protected function rules()
    {
        $rules = [
            'car_id' => 'required|exists:cars,id',
            'driver_id' => 'nullable|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'pickup_location' => 'required|string|max:255',
            'return_location' => 'required|string|max:255',
            'with_driver' => 'boolean',
            'is_out_of_town' => 'boolean',
            'out_of_town_fee' => 'nullable|numeric|min:0',
            'payment_type' => 'required|in:deposit,full',
            'payment_status' => 'required|in:pending,paid,partial',
            'paid_amount' => 'required|numeric|min:0',
            'booking_status' => 'required|in:pending,confirmed,active',
            'notes' => 'nullable|string|max:1000',
        ];

        if ($this->customer_mode === 'existing') {
            $rules['customer_id'] = 'required|exists:customers,id';
        } else {
            $rules['new_customer_name'] = 'required|string|max:255';
            $rules['new_customer_phone'] = 'required|string|max:20';
            $rules['new_customer_email'] = 'nullable|email|max:255';
            $rules['new_customer_id_number'] = 'nullable|string|max:50';
            $rules['new_customer_address'] = 'nullable|string|max:500';
        }

        return $rules;
    }

    protected function messages()
    {
        return [
            'customer_id.required' => 'Pilih pelanggan dari daftar.',
            'new_customer_name.required' => 'Nama pelanggan wajib diisi.',
            'new_customer_phone.required' => 'No. telepon wajib diisi.',
            'car_id.required' => 'Pilih kendaraan.',
            'pickup_location.required' => 'Lokasi ambil wajib diisi.',
            'return_location.required' => 'Lokasi kembali wajib diisi.',
        ];
    }

    public function createBooking()
    {
        $this->validate();

        if (empty($this->availability['is_available'])) {
            session()->flash('error', 'Kendaraan tidak tersedia untuk tanggal yang dipilih.');
            return;
        }

        try {
            DB::beginTransaction();

            $customerId = null;
            $walkinName = null;
            $walkinPhone = null;
            $walkinIdNumber = null;
            $walkinAddress = null;

            // Handle customer
            if ($this->customer_mode === 'existing') {
                $customerId = $this->customer_id;
                
                // Check if customer can make booking
                $customer = Customer::find($customerId);
                if ($customer && !$customer->canMakeBooking()) {
                    session()->flash('error', 'Pelanggan ini tidak dapat melakukan pemesanan.');
                    return;
                }
            } else {
                // Create new customer
                $newCustomer = Customer::create([
                    'name' => $this->new_customer_name,
                    'phone' => $this->new_customer_phone,
                    'email' => $this->new_customer_email ?: null,
                    'nik' => $this->new_customer_id_number ?: null,
                    'address' => $this->new_customer_address ?: null,
                    'is_member' => false,
                    'is_blacklisted' => false,
                ]);
                $customerId = $newCustomer->id;
            }

            $startDate = Carbon::parse($this->start_date);
            $endDate = Carbon::parse($this->end_date);

            // Recalculate pricing - consider member discount toggle
            $pricingCustomerId = null;
            if ($this->apply_member_discount && $customerId) {
                $pricingCustomerId = $customerId;
            }
            
            $pricingParams = [
                'car_id' => $this->car_id,
                'customer_id' => $pricingCustomerId,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'with_driver' => $this->with_driver,
                'is_out_of_town' => $this->is_out_of_town,
                'out_of_town_fee' => $this->out_of_town_fee ?: 0,
            ];

            $pricing = $this->calculatorService->calculateBookingPrice($pricingParams);

            // Create booking
            $booking = Booking::create([
                'booking_type' => Booking::TYPE_WALKIN,
                'admin_id' => Auth::id(),
                'customer_id' => $customerId,
                'walkin_customer_name' => $walkinName,
                'walkin_customer_phone' => $walkinPhone,
                'walkin_customer_id_number' => $walkinIdNumber,
                'walkin_customer_address' => $walkinAddress,
                'car_id' => $this->car_id,
                'driver_id' => $this->with_driver ? $this->driver_id : null,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'pickup_location' => $this->pickup_location,
                'return_location' => $this->return_location,
                'with_driver' => $this->with_driver,
                'is_out_of_town' => $this->is_out_of_town,
                'out_of_town_fee' => $this->out_of_town_fee ?: 0,
                'base_amount' => $pricing['base_amount'],
                'driver_fee' => $pricing['driver_fee'],
                'member_discount' => $pricing['member_discount'] ?? 0,
                'total_amount' => $pricing['total_amount'],
                'deposit_amount' => $this->deposit_amount,
                'payment_type' => $this->payment_type,
                'paid_amount' => $this->paid_amount,
                'payment_status' => $this->payment_status,
                'payment_notes' => $this->payment_notes,
                'booking_status' => $this->booking_status,
                'notes' => $this->notes,
            ]);

            // If confirmed or active, mark car as rented
            if (in_array($this->booking_status, ['confirmed', 'active'])) {
                $car = Car::find($this->car_id);
                $car->markAsRented();
            }

            // If active, set the start key handover
            if ($this->booking_status === 'active') {
                $booking->update([
                    'kunci_diserahkan' => true,
                    'tanggal_serah_kunci' => now(),
                    'petugas_serah_kunci_id' => Auth::id(),
                ]);
            }

            DB::commit();

            // Close modal first
            $this->closeModal();
            
            // Build success message
            $message = $this->customer_mode === 'new' 
                ? 'Pelanggan baru & pemesanan walk-in berhasil dibuat! No: ' . $booking->booking_number
                : 'Pemesanan walk-in berhasil dibuat! No: ' . $booking->booking_number;
            
            // Dispatch events for notification and list refresh
            $this->dispatch('bookingCreated');
            $this->dispatch('notify', type: 'success', message: $message);
            
            // Also set session flash for page refresh scenarios
            session()->flash('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('notify', type: 'error', message: 'Gagal membuat pemesanan: ' . $e->getMessage());
            session()->flash('error', 'Gagal membuat pemesanan: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.walkin-booking-form');
    }
}
