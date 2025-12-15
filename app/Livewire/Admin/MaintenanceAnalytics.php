<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use App\Models\Maintenance;
use Livewire\Component;
use Carbon\Carbon;

class MaintenanceAnalytics extends Component
{
    public $dateRange = '30'; // days
    public $selectedCar = '';
    public $selectedType = '';
    public $startDate = '';
    public $endDate = '';

    public function mount()
    {
        $this->startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        $this->endDate = Carbon::now()->format('Y-m-d');
    }

    public function updatedDateRange()
    {
        switch ($this->dateRange) {
            case '7':
                $this->startDate = Carbon::now()->subDays(7)->format('Y-m-d');
                break;
            case '30':
                $this->startDate = Carbon::now()->subDays(30)->format('Y-m-d');
                break;
            case '90':
                $this->startDate = Carbon::now()->subDays(90)->format('Y-m-d');
                break;
            case '365':
                $this->startDate = Carbon::now()->subYear()->format('Y-m-d');
                break;
            case 'custom':
                // Keep current dates
                break;
            default:
                $this->startDate = Carbon::now()->subDays(30)->format('Y-m-d');
        }
        
        if ($this->dateRange !== 'custom') {
            $this->endDate = Carbon::now()->format('Y-m-d');
        }
    }

    public function exportData()
    {
        return redirect()->route('admin.maintenance.export', [
            'start_date' => $this->startDate,
            'end_date' => $this->endDate,
            'car_id' => $this->selectedCar,
            'maintenance_type' => $this->selectedType,
        ]);
    }

    public function getAnalyticsDataProperty()
    {
        $query = Maintenance::with(['car'])
            ->whereBetween('service_date', [$this->startDate, $this->endDate]);

        if ($this->selectedCar) {
            $query->where('car_id', $this->selectedCar);
        }

        if ($this->selectedType) {
            $query->where('maintenance_type', $this->selectedType);
        }

        $maintenances = $query->get();

        // Calculate basic statistics
        $totalCost = $maintenances->sum('cost');
        $totalCount = $maintenances->count();
        $averageCost = $totalCount > 0 ? $totalCost / $totalCount : 0;

        // Cost by type
        $costByType = $maintenances->groupBy('maintenance_type')->map(function ($items, $type) {
            return [
                'type' => ucfirst($type),
                'total_cost' => $items->sum('cost'),
                'count' => $items->count(),
                'average_cost' => $items->count() > 0 ? $items->sum('cost') / $items->count() : 0,
            ];
        })->values();

        // Monthly trends
        $monthlyTrends = $maintenances->groupBy(function ($item) {
            return Carbon::parse($item->service_date)->format('Y-m');
        })->map(function ($items, $month) {
            return [
                'month' => $month,
                'month_name' => Carbon::createFromFormat('Y-m', $month)->format('M Y'),
                'total_cost' => $items->sum('cost'),
                'count' => $items->count(),
            ];
        })->sortBy('month')->values();

        // Top service providers
        $topProviders = $maintenances->groupBy('service_provider')->map(function ($items, $provider) {
            return [
                'provider' => $provider,
                'total_cost' => $items->sum('cost'),
                'count' => $items->count(),
                'average_cost' => $items->count() > 0 ? $items->sum('cost') / $items->count() : 0,
            ];
        })->sortByDesc('total_cost')->take(10)->values();

        // Vehicle costs (if not filtering by specific car)
        $vehicleCosts = collect();
        if (!$this->selectedCar) {
            $vehicleCosts = $maintenances->groupBy('car_id')->map(function ($items, $carId) {
                $car = $items->first()->car;
                return [
                    'car_id' => $carId,
                    'license_plate' => $car->license_plate,
                    'vehicle_name' => $car->brand . ' ' . $car->model,
                    'total_cost' => $items->sum('cost'),
                    'count' => $items->count(),
                    'average_cost' => $items->count() > 0 ? $items->sum('cost') / $items->count() : 0,
                    'cost_per_km' => $this->calculateCostPerKm($items),
                ];
            })->sortByDesc('total_cost')->take(10)->values();
        }

        return [
            'total_cost' => $totalCost,
            'total_count' => $totalCount,
            'average_cost' => $averageCost,
            'cost_by_type' => $costByType,
            'monthly_trends' => $monthlyTrends,
            'top_providers' => $topProviders,
            'vehicle_costs' => $vehicleCosts,
        ];
    }

    public function getCarsProperty()
    {
        return Car::orderBy('license_plate')->get();
    }

    public function getMaintenanceTypesProperty()
    {
        return [
            'routine' => 'Routine',
            'repair' => 'Repair',
            'inspection' => 'Inspection',
        ];
    }

    public function getUpcomingMaintenanceCountProperty()
    {
        return Maintenance::where('service_date', '>', Carbon::now())
            ->when($this->selectedCar, function ($query) {
                $query->where('car_id', $this->selectedCar);
            })
            ->count();
    }

    public function getOverdueMaintenanceCountProperty()
    {
        return Maintenance::overdue()
            ->when($this->selectedCar, function ($query) {
                $query->where('car_id', $this->selectedCar);
            })
            ->count();
    }

    public function getDueSoonMaintenanceCountProperty()
    {
        return Maintenance::dueSoon(7)
            ->when($this->selectedCar, function ($query) {
                $query->where('car_id', $this->selectedCar);
            })
            ->count();
    }

    private function calculateCostPerKm($maintenances)
    {
        $totalCost = $maintenances->sum('cost');
        $totalKm = 0;

        foreach ($maintenances as $maintenance) {
            $costPerKm = $maintenance->getCostPerKilometer();
            if ($costPerKm !== null) {
                $totalKm += $maintenance->odometer_at_service;
            }
        }

        return $totalKm > 0 ? $totalCost / $totalKm : null;
    }

    public function render()
    {
        return view('livewire.admin.maintenance-analytics', [
            'analyticsData' => $this->analyticsData,
            'cars' => $this->cars,
            'maintenanceTypes' => $this->maintenanceTypes,
            'upcomingCount' => $this->upcomingMaintenanceCount,
            'overdueCount' => $this->overdueMaintenanceCount,
            'dueSoonCount' => $this->dueSoonMaintenanceCount,
        ]);
    }
}