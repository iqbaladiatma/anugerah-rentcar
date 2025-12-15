<?php

namespace App\Livewire\Admin;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class BookingSearch extends Component
{
    use WithPagination;

    // Search filters
    public $search = '';
    public $status = '';
    public $customer_id = '';
    public $car_id = '';
    public $start_date = '';
    public $end_date = '';
    public $overdue_only = false;
    public $with_driver_only = false;
    public $payment_status = '';

    // Sort options
    public $sort_by = 'created_at';
    public $sort_direction = 'desc';

    // Component state
    public $customers = [];
    public $cars = [];
    public $per_page = 15;
    public $show_filters = false;

    // Statistics
    public $statistics = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'customer_id' => ['except' => ''],
        'car_id' => ['except' => ''],
        'start_date' => ['except' => ''],
        'end_date' => ['except' => ''],
        'overdue_only' => ['except' => false],
        'with_driver_only' => ['except' => false],
        'payment_status' => ['except' => ''],
        'sort_by' => ['except' => 'created_at'],
        'sort_direction' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        $this->loadFilterOptions();
        $this->calculateStatistics();
    }

    public function loadFilterOptions()
    {
        $this->customers = Customer::select('id', 'name', 'phone')
            ->orderBy('name')
            ->get()
            ->toArray();

        $this->cars = Car::select('id', 'license_plate', 'brand', 'model')
            ->orderBy('license_plate')
            ->get()
            ->toArray();
    }

    public function calculateStatistics()
    {
        $this->statistics = [
            'total' => Booking::count(),
            'pending' => Booking::where('booking_status', Booking::STATUS_PENDING)->count(),
            'confirmed' => Booking::where('booking_status', Booking::STATUS_CONFIRMED)->count(),
            'active' => Booking::where('booking_status', Booking::STATUS_ACTIVE)->count(),
            'completed' => Booking::where('booking_status', Booking::STATUS_COMPLETED)->count(),
            'cancelled' => Booking::where('booking_status', Booking::STATUS_CANCELLED)->count(),
            'overdue' => Booking::overdue()->count(),
        ];
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }

    public function updatedCustomerId()
    {
        $this->resetPage();
    }

    public function updatedCarId()
    {
        $this->resetPage();
    }

    public function updatedStartDate()
    {
        $this->resetPage();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
    }

    public function updatedOverdueOnly()
    {
        $this->resetPage();
    }

    public function updatedWithDriverOnly()
    {
        $this->resetPage();
    }

    public function updatedPaymentStatus()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sort_by === $field) {
            $this->sort_direction = $this->sort_direction === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sort_by = $field;
            $this->sort_direction = 'asc';
        }

        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset([
            'search', 'status', 'customer_id', 'car_id', 'start_date', 'end_date',
            'overdue_only', 'with_driver_only', 'payment_status'
        ]);
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->show_filters = !$this->show_filters;
    }

    public function getBookingsProperty()
    {
        $query = Booking::with(['customer:id,name,phone', 'car:id,license_plate,brand,model', 'driver:id,name']);

        // Apply search filter
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('car', function ($carQuery) use ($search) {
                      $carQuery->where('license_plate', 'like', "%{$search}%")
                              ->orWhere('brand', 'like', "%{$search}%")
                              ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        // Apply status filter
        if (!empty($this->status)) {
            $query->where('booking_status', $this->status);
        }

        // Apply customer filter
        if (!empty($this->customer_id)) {
            $query->where('customer_id', $this->customer_id);
        }

        // Apply car filter
        if (!empty($this->car_id)) {
            $query->where('car_id', $this->car_id);
        }

        // Apply date range filters
        if (!empty($this->start_date)) {
            $query->whereDate('start_date', '>=', $this->start_date);
        }

        if (!empty($this->end_date)) {
            $query->whereDate('end_date', '<=', $this->end_date);
        }

        // Apply overdue filter
        if ($this->overdue_only) {
            $query->overdue();
        }

        // Apply driver filter
        if ($this->with_driver_only) {
            $query->where('with_driver', true);
        }

        // Apply payment status filter
        if (!empty($this->payment_status)) {
            $query->where('payment_status', $this->payment_status);
        }

        // Apply sorting
        $query->orderBy($this->sort_by, $this->sort_direction);

        return $query->paginate($this->per_page);
    }

    public function getFilteredCountProperty()
    {
        $query = Booking::query();

        // Apply same filters as getBookingsProperty but without pagination
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('booking_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function ($customerQuery) use ($search) {
                      $customerQuery->where('name', 'like', "%{$search}%")
                                  ->orWhere('phone', 'like', "%{$search}%");
                  })
                  ->orWhereHas('car', function ($carQuery) use ($search) {
                      $carQuery->where('license_plate', 'like', "%{$search}%")
                              ->orWhere('brand', 'like', "%{$search}%")
                              ->orWhere('model', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($this->status)) {
            $query->where('booking_status', $this->status);
        }

        if (!empty($this->customer_id)) {
            $query->where('customer_id', $this->customer_id);
        }

        if (!empty($this->car_id)) {
            $query->where('car_id', $this->car_id);
        }

        if (!empty($this->start_date)) {
            $query->whereDate('start_date', '>=', $this->start_date);
        }

        if (!empty($this->end_date)) {
            $query->whereDate('end_date', '<=', $this->end_date);
        }

        if ($this->overdue_only) {
            $query->overdue();
        }

        if ($this->with_driver_only) {
            $query->where('with_driver', true);
        }

        if (!empty($this->payment_status)) {
            $query->where('payment_status', $this->payment_status);
        }

        return $query->count();
    }

    public function getStatusOptions()
    {
        return [
            '' => 'All Statuses',
            Booking::STATUS_PENDING => 'Pending',
            Booking::STATUS_CONFIRMED => 'Confirmed',
            Booking::STATUS_ACTIVE => 'Active',
            Booking::STATUS_COMPLETED => 'Completed',
            Booking::STATUS_CANCELLED => 'Cancelled',
        ];
    }

    public function getPaymentStatusOptions()
    {
        return [
            '' => 'All Payment Status',
            Booking::PAYMENT_PENDING => 'Pending',
            Booking::PAYMENT_PARTIAL => 'Partial',
            Booking::PAYMENT_PAID => 'Paid',
            Booking::PAYMENT_REFUNDED => 'Refunded',
        ];
    }

    public function getSortOptions()
    {
        return [
            'created_at' => 'Created Date',
            'booking_number' => 'Booking Number',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'total_amount' => 'Total Amount',
            'booking_status' => 'Status',
        ];
    }

    public function getStatusBadgeClass($status)
    {
        return match($status) {
            Booking::STATUS_PENDING => 'bg-yellow-100 text-yellow-800',
            Booking::STATUS_CONFIRMED => 'bg-blue-100 text-blue-800',
            Booking::STATUS_ACTIVE => 'bg-green-100 text-green-800',
            Booking::STATUS_COMPLETED => 'bg-gray-100 text-gray-800',
            Booking::STATUS_CANCELLED => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function getPaymentStatusBadgeClass($status)
    {
        return match($status) {
            Booking::PAYMENT_PENDING => 'bg-yellow-100 text-yellow-800',
            Booking::PAYMENT_PARTIAL => 'bg-orange-100 text-orange-800',
            Booking::PAYMENT_PAID => 'bg-green-100 text-green-800',
            Booking::PAYMENT_REFUNDED => 'bg-purple-100 text-purple-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    public function isOverdue($booking)
    {
        return $booking->booking_status === Booking::STATUS_ACTIVE && 
               Carbon::now() > Carbon::parse($booking->end_date);
    }

    public function formatCurrency($amount)
    {
        return 'Rp ' . number_format($amount, 0, ',', '.');
    }

    public function render()
    {
        return view('livewire.admin.booking-search', [
            'bookings' => $this->bookings,
            'filtered_count' => $this->filtered_count,
        ]);
    }
}