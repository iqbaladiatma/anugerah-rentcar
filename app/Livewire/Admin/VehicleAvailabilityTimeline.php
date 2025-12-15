<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use App\Models\Booking;
use App\Services\AvailabilityService;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Collection;

class VehicleAvailabilityTimeline extends Component
{
    public $startDate;
    public $endDate;
    public $selectedCarIds = [];
    public $showAllCars = true;
    public $timelineData = [];
    public $hoveredBooking = null;

    protected $availabilityService;

    public function boot(AvailabilityService $availabilityService)
    {
        $this->availabilityService = $availabilityService;
    }

    public function mount()
    {
        // Default to current week
        $this->startDate = Carbon::now()->startOfWeek()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfWeek()->format('Y-m-d');
        
        $this->loadTimelineData();
    }

    public function updatedStartDate()
    {
        $this->validateDates();
        $this->loadTimelineData();
    }

    public function updatedEndDate()
    {
        $this->validateDates();
        $this->loadTimelineData();
    }

    public function updatedSelectedCarIds()
    {
        $this->showAllCars = empty($this->selectedCarIds);
        $this->loadTimelineData();
    }

    public function toggleShowAllCars()
    {
        $this->showAllCars = !$this->showAllCars;
        if ($this->showAllCars) {
            $this->selectedCarIds = [];
        }
        $this->loadTimelineData();
    }

    public function selectDateRange($range)
    {
        $now = Carbon::now();
        
        switch ($range) {
            case 'today':
                $this->startDate = $now->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                break;
            case 'week':
                $this->startDate = $now->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->endOfWeek()->format('Y-m-d');
                break;
            case 'month':
                $this->startDate = $now->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'next_week':
                $this->startDate = $now->addWeek()->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->endOfWeek()->format('Y-m-d');
                break;
            case 'next_month':
                $this->startDate = $now->addMonth()->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
        }
        
        $this->loadTimelineData();
    }

    public function showBookingDetails($bookingId)
    {
        $this->hoveredBooking = Booking::with(['customer', 'car'])->find($bookingId);
    }

    public function hideBookingDetails()
    {
        $this->hoveredBooking = null;
    }

    private function validateDates()
    {
        if ($this->startDate && $this->endDate) {
            $start = Carbon::parse($this->startDate);
            $end = Carbon::parse($this->endDate);
            
            if ($start > $end) {
                $this->endDate = $this->startDate;
            }
            
            // Limit to maximum 3 months range
            if ($start->diffInDays($end) > 90) {
                $this->endDate = $start->copy()->addDays(90)->format('Y-m-d');
            }
        }
    }

    private function loadTimelineData()
    {
        if (!$this->startDate || !$this->endDate) {
            return;
        }

        $startDate = Carbon::parse($this->startDate);
        $endDate = Carbon::parse($this->endDate);

        // Get cars to display
        $carsQuery = Car::query();
        
        if (!$this->showAllCars && !empty($this->selectedCarIds)) {
            $carsQuery->whereIn('id', $this->selectedCarIds);
        }
        
        $cars = $carsQuery->orderBy('license_plate')->get();

        $this->timelineData = [
            'cars' => $cars->map(function ($car) use ($startDate, $endDate) {
                return [
                    'id' => $car->id,
                    'license_plate' => $car->license_plate,
                    'brand' => $car->brand,
                    'model' => $car->model,
                    'status' => $car->status,
                    'calendar' => $this->availabilityService->getAvailabilityCalendar($car, $startDate, $endDate),
                    'maintenance_due' => $car->isMaintenanceDue(),
                ];
            })->toArray(),
            'date_range' => $this->generateDateRange($startDate, $endDate),
            'summary' => $this->availabilityService->getFleetAvailabilitySummary($startDate, $endDate),
        ];
    }

    private function generateDateRange(Carbon $startDate, Carbon $endDate): array
    {
        $dates = [];
        $current = $startDate->copy();
        
        while ($current <= $endDate) {
            $dates[] = [
                'date' => $current->format('Y-m-d'),
                'day_name' => $current->format('D'),
                'day_number' => $current->format('j'),
                'month_name' => $current->format('M'),
                'is_weekend' => $current->isWeekend(),
                'is_today' => $current->isToday(),
            ];
            $current->addDay();
        }
        
        return $dates;
    }

    public function getStatusColor($status): string
    {
        return match ($status) {
            'available' => 'bg-green-200 border-green-300',
            'booked' => 'bg-blue-200 border-blue-300',
            'rented' => 'bg-yellow-200 border-yellow-300',
            'maintenance' => 'bg-red-200 border-red-300',
            'inactive' => 'bg-gray-200 border-gray-300',
            default => 'bg-gray-100 border-gray-200',
        };
    }

    public function getStatusTextColor($status): string
    {
        return match ($status) {
            'available' => 'text-green-800',
            'booked' => 'text-blue-800',
            'rented' => 'text-yellow-800',
            'maintenance' => 'text-red-800',
            'inactive' => 'text-gray-800',
            default => 'text-gray-600',
        };
    }

    public function getAllCars()
    {
        return Car::orderBy('license_plate')->get();
    }

    public function render()
    {
        return view('livewire.admin.vehicle-availability-timeline', [
            'allCars' => $this->getAllCars(),
        ]);
    }
}