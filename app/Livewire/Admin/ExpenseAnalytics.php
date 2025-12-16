<?php

namespace App\Livewire\Admin;

use App\Models\Expense;
use Livewire\Component;
use Carbon\Carbon;

class ExpenseAnalytics extends Component
{
    public $selectedYear;
    public $selectedMonth = '';
    public $comparisonPeriod = 'month';
    
    public $yearlySummary = [];
    public $monthlySummary = [];
    public $trendData = [];
    public $categoryBreakdown = [];
    public $comparison = [];

    public function mount()
    {
        $this->selectedYear = Carbon::now()->year;
        $this->loadAnalyticsData();
    }

    public function updatedSelectedYear()
    {
        $this->loadAnalyticsData();
    }

    public function updatedSelectedMonth()
    {
        $this->loadAnalyticsData();
    }

    public function updatedComparisonPeriod()
    {
        $this->loadComparison();
    }

    public function loadAnalyticsData()
    {
        // Load yearly summary
        $this->yearlySummary = Expense::getYearlySummary($this->selectedYear);

        // Load monthly summary if month is selected
        if ($this->selectedMonth) {
            $this->monthlySummary = Expense::getMonthlySummary($this->selectedYear, $this->selectedMonth);
        } else {
            $this->monthlySummary = [];
        }

        // Load trend data for the last 12 months
        $this->loadTrendData();

        // Load category breakdown
        $this->loadCategoryBreakdown();

        // Load comparison data
        $this->loadComparison();
    }

    public function loadTrendData()
    {
        $this->trendData = [];
        
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthSummary = Expense::getMonthlySummary($date->year, $date->month);
            
            $this->trendData[] = [
                'month' => $date->format('M Y'),
                'short_month' => $date->format('M'),
                'total' => $monthSummary['total_amount'],
                'count' => $monthSummary['total_count'],
            ];
        }
    }

    public function loadCategoryBreakdown()
    {
        $startDate = Carbon::create($this->selectedYear, 1, 1);
        $endDate = $startDate->copy()->endOfYear();

        $this->categoryBreakdown = Expense::inDateRange($startDate, $endDate)
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->get()
            ->map(function ($item) {
                return [
                    'category' => $item->category,
                    'label' => Expense::getCategories()[$item->category] ?? ucfirst($item->category),
                    'total' => $item->total,
                    'count' => $item->count,
                    'percentage' => $this->yearlySummary['total_amount'] > 0 
                        ? ($item->total / $this->yearlySummary['total_amount']) * 100 
                        : 0,
                ];
            })
            ->sortByDesc('total')
            ->values()
            ->toArray();
    }

    public function loadComparison()
    {
        if ($this->comparisonPeriod === 'month' && $this->selectedMonth) {
            // Compare with previous month
            $currentStart = Carbon::create($this->selectedYear, $this->selectedMonth, 1);
            $currentEnd = $currentStart->copy()->endOfMonth();
            $previousStart = $currentStart->copy()->subMonth();
            $previousEnd = $previousStart->copy()->endOfMonth();
            
            $this->comparison = Expense::getComparison($currentStart, $currentEnd, $previousStart, $previousEnd);
            $this->comparison['period1_label'] = $currentStart->format('F Y');
            $this->comparison['period2_label'] = $previousStart->format('F Y');
        } else {
            // Compare with previous year
            $currentStart = Carbon::create($this->selectedYear, 1, 1);
            $currentEnd = $currentStart->copy()->endOfYear();
            $previousStart = $currentStart->copy()->subYear();
            $previousEnd = $previousStart->copy()->endOfYear();
            
            $this->comparison = Expense::getComparison($currentStart, $currentEnd, $previousStart, $previousEnd);
            $this->comparison['period1_label'] = $currentStart->format('Y');
            $this->comparison['period2_label'] = $previousStart->format('Y');
        }
    }

    public function exportData($format = 'excel')
    {
        // This would trigger an export - for now just show a message
        session()->flash('info', 'Export functionality will be implemented in the reporting module.');
    }

    public function render()
    {
        return view('livewire.admin.expense-analytics', [
            'categories' => Expense::getCategories(),
            'years' => range(Carbon::now()->year - 5, Carbon::now()->year + 1),
            'months' => [
                1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
            ],
        ]);
    }
}