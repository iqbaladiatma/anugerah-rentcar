<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category',
        'description',
        'amount',
        'expense_date',
        'receipt_photo',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'expense_date' => 'date',
        'created_by' => 'integer',
    ];

    /**
     * Expense category constants.
     */
    const CATEGORY_SALARY = 'salary';
    const CATEGORY_UTILITIES = 'utilities';
    const CATEGORY_SUPPLIES = 'supplies';
    const CATEGORY_MARKETING = 'marketing';
    const CATEGORY_OTHER = 'other';

    /**
     * Get the user who created the expense.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get receipt photo URL.
     */
    public function getReceiptPhotoUrlAttribute(): ?string
    {
        return $this->receipt_photo ? asset('storage/' . $this->receipt_photo) : null;
    }

    /**
     * Get category display name.
     */
    public function getCategoryDisplayNameAttribute(): string
    {
        return match($this->category) {
            self::CATEGORY_SALARY => 'Salary',
            self::CATEGORY_UTILITIES => 'Utilities',
            self::CATEGORY_SUPPLIES => 'Supplies',
            self::CATEGORY_MARKETING => 'Marketing',
            self::CATEGORY_OTHER => 'Other',
            default => ucfirst($this->category),
        };
    }

    /**
     * Get all available categories.
     */
    public static function getCategories(): array
    {
        return [
            self::CATEGORY_SALARY => 'Salary',
            self::CATEGORY_UTILITIES => 'Utilities',
            self::CATEGORY_SUPPLIES => 'Supplies',
            self::CATEGORY_MARKETING => 'Marketing',
            self::CATEGORY_OTHER => 'Other',
        ];
    }

    /**
     * Get monthly expense summary.
     */
    public static function getMonthlySummary(int $year, int $month): array
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();

        $expenses = static::whereBetween('expense_date', [$startDate, $endDate])->get();

        $summary = [
            'total_amount' => $expenses->sum('amount'),
            'total_count' => $expenses->count(),
            'by_category' => [],
            'daily_breakdown' => [],
        ];

        // Group by category
        foreach (static::getCategories() as $key => $label) {
            $categoryExpenses = $expenses->where('category', $key);
            $summary['by_category'][$key] = [
                'label' => $label,
                'amount' => $categoryExpenses->sum('amount'),
                'count' => $categoryExpenses->count(),
                'percentage' => $summary['total_amount'] > 0 
                    ? ($categoryExpenses->sum('amount') / $summary['total_amount']) * 100 
                    : 0,
            ];
        }

        // Daily breakdown
        $dailyExpenses = $expenses->groupBy(function($expense) {
            return $expense->expense_date->format('Y-m-d');
        });

        foreach ($dailyExpenses as $date => $dayExpenses) {
            $summary['daily_breakdown'][$date] = [
                'amount' => $dayExpenses->sum('amount'),
                'count' => $dayExpenses->count(),
            ];
        }

        return $summary;
    }

    /**
     * Get yearly expense summary.
     */
    public static function getYearlySummary(int $year): array
    {
        $startDate = Carbon::create($year, 1, 1);
        $endDate = $startDate->copy()->endOfYear();

        $expenses = static::whereBetween('expense_date', [$startDate, $endDate])->get();

        $summary = [
            'total_amount' => $expenses->sum('amount'),
            'total_count' => $expenses->count(),
            'by_category' => [],
            'monthly_breakdown' => [],
            'average_monthly' => 0,
        ];

        // Group by category
        foreach (static::getCategories() as $key => $label) {
            $categoryExpenses = $expenses->where('category', $key);
            $summary['by_category'][$key] = [
                'label' => $label,
                'amount' => $categoryExpenses->sum('amount'),
                'count' => $categoryExpenses->count(),
                'percentage' => $summary['total_amount'] > 0 
                    ? ($categoryExpenses->sum('amount') / $summary['total_amount']) * 100 
                    : 0,
            ];
        }

        // Monthly breakdown
        for ($month = 1; $month <= 12; $month++) {
            $monthStart = Carbon::create($year, $month, 1);
            $monthEnd = $monthStart->copy()->endOfMonth();
            
            $monthExpenses = $expenses->filter(function($expense) use ($monthStart, $monthEnd) {
                return $expense->expense_date >= $monthStart && $expense->expense_date <= $monthEnd;
            });

            $summary['monthly_breakdown'][$month] = [
                'month' => $monthStart->format('F'),
                'amount' => $monthExpenses->sum('amount'),
                'count' => $monthExpenses->count(),
            ];
        }

        $summary['average_monthly'] = $summary['total_amount'] / 12;

        return $summary;
    }

    /**
     * Get expense comparison between periods.
     */
    public static function getComparison(Carbon $startDate1, Carbon $endDate1, Carbon $startDate2, Carbon $endDate2): array
    {
        $period1Expenses = static::whereBetween('expense_date', [$startDate1, $endDate1])->get();
        $period2Expenses = static::whereBetween('expense_date', [$startDate2, $endDate2])->get();

        $period1Total = $period1Expenses->sum('amount');
        $period2Total = $period2Expenses->sum('amount');

        $comparison = [
            'period1' => [
                'total' => $period1Total,
                'count' => $period1Expenses->count(),
                'start_date' => $startDate1->format('Y-m-d'),
                'end_date' => $endDate1->format('Y-m-d'),
            ],
            'period2' => [
                'total' => $period2Total,
                'count' => $period2Expenses->count(),
                'start_date' => $startDate2->format('Y-m-d'),
                'end_date' => $endDate2->format('Y-m-d'),
            ],
            'difference' => [
                'amount' => $period1Total - $period2Total,
                'percentage' => $period2Total > 0 ? (($period1Total - $period2Total) / $period2Total) * 100 : 0,
            ],
        ];

        return $comparison;
    }

    /**
     * Calculate total operational expenses for profitability.
     */
    public static function getTotalOperationalExpenses(Carbon $startDate, Carbon $endDate): float
    {
        return static::whereBetween('expense_date', [$startDate, $endDate])
                    ->sum('amount');
    }

    /**
     * Scope to filter by category.
     */
    public function scopeOfCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeInDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by month.
     */
    public function scopeInMonth($query, int $year, int $month)
    {
        $startDate = Carbon::create($year, $month, 1);
        $endDate = $startDate->copy()->endOfMonth();
        
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }

    /**
     * Scope to filter by year.
     */
    public function scopeInYear($query, int $year)
    {
        $startDate = Carbon::create($year, 1, 1);
        $endDate = $startDate->copy()->endOfYear();
        
        return $query->whereBetween('expense_date', [$startDate, $endDate]);
    }

    /**
     * Scope to filter recent expenses.
     */
    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('expense_date', '>=', Carbon::now()->subDays($days));
    }

    /**
     * Boot method to set created_by automatically.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($expense) {
            if (!$expense->created_by && auth()->check()) {
                $expense->created_by = auth()->id();
            }
        });
    }
}