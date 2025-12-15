<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use App\Models\Maintenance;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class MaintenanceList extends Component
{
    use WithPagination;

    public $search = '';
    public $carFilter = '';
    public $typeFilter = '';
    public $providerFilter = '';
    public $dateFrom = '';
    public $dateTo = '';
    public $sortBy = 'service_date';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'carFilter' => ['except' => ''],
        'typeFilter' => ['except' => ''],
        'providerFilter' => ['except' => ''],
        'dateFrom' => ['except' => ''],
        'dateTo' => ['except' => ''],
        'sortBy' => ['except' => 'service_date'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function mount()
    {
        // Set default date range to current month
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCarFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function updatingProviderFilter()
    {
        $this->resetPage();
    }

    public function updatingDateFrom()
    {
        $this->resetPage();
    }

    public function updatingDateTo()
    {
        $this->resetPage();
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
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->carFilter = '';
        $this->typeFilter = '';
        $this->providerFilter = '';
        $this->dateFrom = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->dateTo = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->resetPage();
    }

    public function deleteMaintenance($maintenanceId)
    {
        $maintenance = Maintenance::find($maintenanceId);
        
        if ($maintenance) {
            // Delete receipt photo if exists
            if ($maintenance->receipt_photo) {
                \Storage::disk('public')->delete($maintenance->receipt_photo);
            }
            
            $maintenance->delete();
            
            session()->flash('success', 'Maintenance record deleted successfully.');
        }
    }

    public function getMaintenancesProperty()
    {
        $query = Maintenance::with(['car'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('description', 'like', '%' . $this->search . '%')
                      ->orWhere('service_provider', 'like', '%' . $this->search . '%')
                      ->orWhereHas('car', function ($carQuery) {
                          $carQuery->where('license_plate', 'like', '%' . $this->search . '%')
                                   ->orWhere('brand', 'like', '%' . $this->search . '%')
                                   ->orWhere('model', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->when($this->carFilter, function ($query) {
                $query->where('car_id', $this->carFilter);
            })
            ->when($this->typeFilter, function ($query) {
                $query->where('maintenance_type', $this->typeFilter);
            })
            ->when($this->providerFilter, function ($query) {
                $query->where('service_provider', 'like', '%' . $this->providerFilter . '%');
            })
            ->when($this->dateFrom, function ($query) {
                $query->where('service_date', '>=', $this->dateFrom);
            })
            ->when($this->dateTo, function ($query) {
                $query->where('service_date', '<=', $this->dateTo);
            })
            ->orderBy($this->sortBy, $this->sortDirection);

        return $query->paginate(15);
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

    public function getStatisticsProperty()
    {
        $dateFrom = $this->dateFrom ?: Carbon::now()->startOfMonth();
        $dateTo = $this->dateTo ?: Carbon::now()->endOfMonth();

        $totalCost = Maintenance::whereBetween('service_date', [$dateFrom, $dateTo])->sum('cost');
        $totalCount = Maintenance::whereBetween('service_date', [$dateFrom, $dateTo])->count();
        $averageCost = $totalCount > 0 ? $totalCost / $totalCount : 0;

        $costByType = Maintenance::selectRaw('maintenance_type, SUM(cost) as total_cost, COUNT(*) as count')
            ->whereBetween('service_date', [$dateFrom, $dateTo])
            ->groupBy('maintenance_type')
            ->get()
            ->keyBy('maintenance_type');

        return [
            'total_cost' => $totalCost,
            'total_count' => $totalCount,
            'average_cost' => $averageCost,
            'routine_cost' => $costByType->get('routine')?->total_cost ?? 0,
            'repair_cost' => $costByType->get('repair')?->total_cost ?? 0,
            'inspection_cost' => $costByType->get('inspection')?->total_cost ?? 0,
            'routine_count' => $costByType->get('routine')?->count ?? 0,
            'repair_count' => $costByType->get('repair')?->count ?? 0,
            'inspection_count' => $costByType->get('inspection')?->count ?? 0,
        ];
    }

    public function render()
    {
        return view('livewire.admin.maintenance-list', [
            'maintenances' => $this->maintenances,
            'cars' => $this->cars,
            'maintenanceTypes' => $this->maintenanceTypes,
            'statistics' => $this->statistics,
        ]);
    }
}