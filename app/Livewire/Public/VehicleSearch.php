<?php

namespace App\Livewire\Public;

use App\Models\Car;
use App\Services\VehicleService;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class VehicleSearch extends Component
{
    use WithPagination;

    public $startDate;
    public $endDate;
    public $brand = '';
    public $maxPrice = '';
    public $withDriver = false;
    public $sortBy = 'daily_rate';
    public $sortDirection = 'asc';
    
    public $isSearching = false;
    public $searchResults = null;
    public $totalResults = 0;

    protected $queryString = [
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'brand' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'withDriver' => ['except' => false],
        'sortBy' => ['except' => 'daily_rate'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function mount()
    {
        $this->startDate = request('start_date', '');
        $this->endDate = request('end_date', '');
        $this->brand = request('brand', '');
        $this->maxPrice = request('max_price', '');
        $this->withDriver = request('with_driver', false);
        
        if ($this->startDate && $this->endDate) {
            $this->performSearch();
        }
    }

    public function updatedStartDate()
    {
        if ($this->startDate && $this->endDate) {
            $startDate = Carbon::parse($this->startDate);
            $endDate = Carbon::parse($this->endDate);
            
            if ($endDate <= $startDate) {
                $this->endDate = $startDate->copy()->addDay()->format('Y-m-d');
            }
        }
        
        $this->resetPage();
        $this->performSearch();
    }

    public function updatedEndDate()
    {
        $this->resetPage();
        $this->performSearch();
    }

    public function updatedBrand()
    {
        $this->resetPage();
        $this->performSearch();
    }

    public function updatedMaxPrice()
    {
        $this->resetPage();
        $this->performSearch();
    }

    public function updatedWithDriver()
    {
        $this->resetPage();
        $this->performSearch();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
        $this->performSearch();
    }

    public function updatedSortDirection()
    {
        $this->resetPage();
        $this->performSearch();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        
        $this->resetPage();
        $this->performSearch();
    }

    public function clearFilters()
    {
        $this->startDate = '';
        $this->endDate = '';
        $this->brand = '';
        $this->maxPrice = '';
        $this->withDriver = false;
        $this->sortBy = 'daily_rate';
        $this->sortDirection = 'asc';
        
        $this->resetPage();
        $this->searchResults = null;
        $this->totalResults = 0;
    }

    public function performSearch()
    {
        if (!$this->startDate || !$this->endDate) {
            $this->searchResults = null;
            $this->totalResults = 0;
            return;
        }

        $this->isSearching = true;
        
        try {
            $vehicleService = app(VehicleService::class);
            $startDate = Carbon::parse($this->startDate);
            $endDate = Carbon::parse($this->endDate);
            
            // Get available vehicles
            $availableVehicles = $vehicleService->getAvailableVehicles($startDate, $endDate);
            
            // Apply filters
            if ($this->brand) {
                $availableVehicles = $availableVehicles->where('brand', $this->brand);
            }
            
            if ($this->maxPrice) {
                $availableVehicles = $availableVehicles->where('daily_rate', '<=', $this->maxPrice);
            }
            
            if ($this->withDriver) {
                $availableVehicles = $availableVehicles->where('driver_fee_per_day', '>', 0);
            }
            
            // Apply sorting
            $availableVehicles = $availableVehicles->sortBy($this->sortBy, SORT_REGULAR, $this->sortDirection === 'desc');
            
            $this->totalResults = $availableVehicles->count();
            
            // Calculate pricing for each vehicle
            $duration = $startDate->diffInDays($endDate) + 1;
            $this->searchResults = $availableVehicles->map(function ($car) use ($duration) {
                $totalPrice = $car->daily_rate * $duration;
                $weeklyDiscount = 0;
                
                // Apply weekly rate if duration is 7+ days and weekly rate exists
                if ($duration >= 7 && $car->weekly_rate > 0) {
                    $weeks = floor($duration / 7);
                    $remainingDays = $duration % 7;
                    $totalPrice = ($car->weekly_rate * $weeks) + ($car->daily_rate * $remainingDays);
                    $weeklyDiscount = ($car->daily_rate * $duration) - $totalPrice;
                }
                
                $car->calculated_total_price = $totalPrice;
                $car->calculated_weekly_discount = $weeklyDiscount;
                $car->calculated_duration = $duration;
                
                return $car;
            })->values();
            
        } catch (\Exception $e) {
            $this->searchResults = collect();
            $this->totalResults = 0;
        }
        
        $this->isSearching = false;
    }

    public function getAvailableBrands()
    {
        return Car::where('status', Car::STATUS_AVAILABLE)
            ->distinct()
            ->pluck('brand')
            ->sort()
            ->values();
    }

    public function getPriceRanges()
    {
        return [
            ['value' => 300000, 'label' => 'Under Rp 300,000'],
            ['value' => 500000, 'label' => 'Under Rp 500,000'],
            ['value' => 750000, 'label' => 'Under Rp 750,000'],
            ['value' => 1000000, 'label' => 'Under Rp 1,000,000'],
        ];
    }

    public function render()
    {
        return view('livewire.public.vehicle-search', [
            'brands' => $this->getAvailableBrands(),
            'priceRanges' => $this->getPriceRanges(),
        