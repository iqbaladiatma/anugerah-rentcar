<?php

namespace App\Livewire\Admin;

use App\Models\Expense;
use App\Models\Booking;
use Livewire\Component;
use Carbon\Carbon;

class ExpenseAnalytics extends Component
{
    public $period = 'month';
    public $year;
    public $month;
    public $startDate;
    public $endDate;
    
    public $analytics = [];
    public $profitability = [];
    public $chartData = [];

    public function mount()
    {
        $this->year = Carbon::now()->year;
        $this->month = Carbon::now()->month;
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        
        $this->loadAnalytics();
    }

    public function updatedPeriod()
    {
        $this->loadAnalytics();
    }

    public function updatedYear()
    {
        $this->loadAnalytics();
    }

    public function updatedMonth()
    {
        $this->loadAnalytics();
    }

    public function updatedStartDate()
    {
        if ($this->period === 'custom') {
            $this->loadAnalytics();
        }
    }

    public function updatedEndDate()
    {
        if ($this->period === 'custom') {
            $this->loadAnalytics();
        }
    }

    public function loadAnalytics()
    {
        switch ($this->period) {
            case 'month':
                $this->analytics = Expense::getMonthlySummary($this->year, $this->month);
                $this->loadProfitability(
                    Carbon::create($this->year, $this->month, 1),
                    Carbon::create($this->year, $this->month, 1)->endOfMonth()
                );
                break;
                
            case 'year':
                $this->analytics = Expense::getYearlySummary($this->year);
                $this->loadProfitability(
                    Carbon::create($this->year, 1, 1),
                    Carbon::create($this->year, 12, 31)
                );
                break;
                
            case 'custom':
                if ($this->startDate && $this->endDate) {
                    $startDate = Carbon::parse($this->startDate);
                    $endDate = Carbon::parse($this->endDate);
                    
                    $expenses = Expense::inDateRange($startDate, $endDate)->get();
                    
                    $this->analytics = [
                        'total_amount' => $expenses->sum('amount'),
                        'total_count' => $expenses->count(),
                        'by_category' => [],
                        'period' => [
                            'start_date' => $startDate->format('Y-m-d'),
                            'end_date' => $endDate->format('Y-m-d'),
                            'days' => $startDate->diffInDays($endDate) + 1
                        ]
                    ];

                    foreach (Expense::getCategories() as $key => $label) {
                        $categoryExpenses = $expenses->where('category', $key);
                        $this->analytics['by_category'][$key] = [
                            'label' => $label,
                            'amount' => $categoryExpenses->sum('amount'),
                            'count' => $categoryExpenses->count(),
                            'percentage' => $this->analytics['total_amount'] > 0 
                                ? ($categoryExpenses->sum('amount') / $this->analytics['total_amount']) * 100 
                                : 0,
                        ];
                    }
                    
                    $this->loadProfitability($startDate, $endDate);
                }
                break;
        }
        
        $this->prepareChartData();
    }

    private function loadProfitability(Carbon $startDate, Carbon $endDate)
    {
        // Get total expenses
        $totalExpenses = Expense::getTotalOperationalExpenses($startDate, $endDate);
        
        // Get rental revenue from bookings
        $totalRevenue = Booking::whereBetween('start_date', [$startDate, $endDate])
            ->where('booking_status', '!=', 'cancelled')
            ->sum('total_amount');
            
        $bookingsCount = Booking::whereBetween('start_date', [$startDate, $endDate])
            ->where('booking_status', '!=', 'cancelled')
            ->count();

        $grossProfit = $totalRevenue - $totalExpenses;
        $profitMargin = $totalRevenue > 0 ? ($grossProfit / $totalRevenue) * 100 : 0;

        $this->profitability = [
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'days' => $startDate->diffInDays($endDate) + 1
            ],
            'revenue' => [
                'total' => $totalRevenue,
                'bookings_count' => $bookingsCount,
                'average_per_booking' => $bookingsCount > 0 ? $totalRevenue / $bookingsCount : 0
            ],
            'expenses' => [
                'total' => $totalExpenses,
                'by_category' => []
            ],
            'profit' => [
                'gross' => $grossProfit,
                'margin_percentage' => $profitMargin,
                'daily_average' => $grossProfit / ($startDate->diffInDays($endDate) + 1)
            ]
        ];

        // Get expense breakdown by category
        $expenses = Expense::inDateRange($startDate, $endDate)->get();
        foreach (Expense::getCategories() as $key => $label) {
            $categoryExpenses = $expenses->where('category', $key);
            $this->profitability['expenses']['by_category'][$key] = [
                'label' => $label,
                'amount' => $categoryExpenses->sum('amount'),
                'count' => $categoryExpenses->count(),
                'percentage' => $totalExpenses > 0 
                    ? ($categoryExpenses->sum('amount') / $totalExpenses) * 100 
                    : 0,
            ];
        }
    }

    private function prepareChartData()
    {
        if (empty($this->analytics)) {
            return;
        }

        // Prepare category chart data
        $categoryData = [];
        $categoryLabels = [];
        $categoryColors = [
            'salary' => '#3B82F6',
            'utilities' => '#EAB308', 
            'supplies' => '#10B981',
            'marketing' => '#8B5CF6',
            'other' => '#6B7280'
        ];

        foreach ($this->analytics['by_category'] as $key => $category) {
            if ($category['amount'] > 0) {
                $categoryLabels[] = $category['label'];
                $categoryData[] = $category['amount'];
            }
        }

        $this->chartData = [
            'categories' => [
                'labels' => $categoryLabels,
                'data' => $categoryData,
                'colors' => array_values(array_intersect_key($categoryColors, array_flip(array_keys($this->analytics['by_category']))))
            ]
        ];

        // Prepare trend data for yearly view
        if ($this->period === 'year' && isset($this->analytics['monthly_breakdown'])) {
            $trendLabels = [];
            $trendData = [];
            
            foreach ($this->analytics['monthly_breakdown'] as $monthData) {
                $trendLabels[] = $monthData['month'];
                $trendData[] = $monthData['amount'];
            }
            
            $this->chartData['trend'] = [
                'labels' => $trendLabels,
                'data' => $trendData
            ];
        }
    }

    public function exportData()
    {
        // This would integrate with Excel export functionality
        session()->flash('info', 'Export functionality will be implemented in the reporting module.');
    }

    public function render()
    {
        return view('livewire.admin.expense-analytics');
    }
}