<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ExpenseController extends Controller
{
    /**
     * Display a listing of expenses.
     */
    public function index(Request $request): View
    {
        $query = Expense::with('creator')->latest('expense_date');

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('start_date')) {
            $query->where('expense_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('expense_date', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $expenses = $query->paginate(15)->withQueryString();

        // Get summary statistics
        $totalExpenses = $query->sum('amount');
        $expenseCount = $query->count();

        // Get monthly summary for current month
        $currentMonth = Carbon::now();
        $monthlySummary = Expense::getMonthlySummary($currentMonth->year, $currentMonth->month);

        return view('admin.expenses.index', compact(
            'expenses',
            'totalExpenses',
            'expenseCount',
            'monthlySummary'
        ));
    }

    /**
     * Show the form for creating a new expense.
     */
    public function create(): View
    {
        return view('admin.expenses.create', [
            'categories' => Expense::getCategories(),
        ]);
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:salary,utilities,supplies,marketing,other',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'expense_date' => 'required|date|before_or_equal:today',
            'receipt_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle receipt photo upload
        if ($request->hasFile('receipt_photo')) {
            $validated['receipt_photo'] = $request->file('receipt_photo')
                ->store('expenses/receipts', 'public');
        }

        Expense::create($validated);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense recorded successfully.');
    }

    /**
     * Display the specified expense.
     */
    public function show(Expense $expense): View
    {
        $expense->load('creator');
        
        return view('admin.expenses.show', compact('expense'));
    }

    /**
     * Show the form for editing the specified expense.
     */
    public function edit(Expense $expense): View
    {
        return view('admin.expenses.edit', [
            'expense' => $expense,
            'categories' => Expense::getCategories(),
        ]);
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validate([
            'category' => 'required|in:salary,utilities,supplies,marketing,other',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|max:999999.99',
            'expense_date' => 'required|date|before_or_equal:today',
            'receipt_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle receipt photo upload
        if ($request->hasFile('receipt_photo')) {
            // Delete old photo if exists
            if ($expense->receipt_photo) {
                Storage::disk('public')->delete($expense->receipt_photo);
            }
            
            $validated['receipt_photo'] = $request->file('receipt_photo')
                ->store('expenses/receipts', 'public');
        }

        $expense->update($validated);

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense updated successfully.');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy(Expense $expense): RedirectResponse
    {
        // Delete receipt photo if exists
        if ($expense->receipt_photo) {
            Storage::disk('public')->delete($expense->receipt_photo);
        }

        $expense->delete();

        return redirect()->route('admin.expenses.index')
            ->with('success', 'Expense deleted successfully.');
    }

    /**
     * Display expense reports and analytics.
     */
    public function reports(Request $request): View
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        // Get yearly summary
        $yearlySummary = Expense::getYearlySummary($year);

        // Get monthly summary if month is specified
        $monthlySummary = null;
        if ($month) {
            $monthlySummary = Expense::getMonthlySummary($year, $month);
        }

        // Get comparison with previous period
        $comparison = null;
        if ($month) {
            // Compare with previous month
            $currentStart = Carbon::create($year, $month, 1);
            $currentEnd = $currentStart->copy()->endOfMonth();
            $previousStart = $currentStart->copy()->subMonth();
            $previousEnd = $previousStart->copy()->endOfMonth();
            
            $comparison = Expense::getComparison($currentStart, $currentEnd, $previousStart, $previousEnd);
        } else {
            // Compare with previous year
            $currentStart = Carbon::create($year, 1, 1);
            $currentEnd = $currentStart->copy()->endOfYear();
            $previousStart = $currentStart->copy()->subYear();
            $previousEnd = $previousStart->copy()->endOfYear();
            
            $comparison = Expense::getComparison($currentStart, $currentEnd, $previousStart, $previousEnd);
        }

        // Get recent expenses for quick overview
        $recentExpenses = Expense::with('creator')
            ->recent(30)
            ->orderBy('expense_date', 'desc')
            ->limit(10)
            ->get();

        return view('admin.expenses.reports', compact(
            'yearlySummary',
            'monthlySummary',
            'comparison',
            'recentExpenses',
            'year',
            'month'
        ));
    }

    /**
     * Get monthly expense summary.
     */
    public function monthlySummary(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month', Carbon::now()->month);

        $summary = Expense::getMonthlySummary($year, $month);

        return response()->json($summary);
    }

    /**
     * Get yearly expense summary.
     */
    public function yearlySummary(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);

        $summary = Expense::getYearlySummary($year);

        return response()->json($summary);
    }

    /**
     * Get expense comparison data.
     */
    public function comparison(Request $request)
    {
        $validated = $request->validate([
            'start_date_1' => 'required|date',
            'end_date_1' => 'required|date|after_or_equal:start_date_1',
            'start_date_2' => 'required|date',
            'end_date_2' => 'required|date|after_or_equal:start_date_2',
        ]);

        $comparison = Expense::getComparison(
            Carbon::parse($validated['start_date_1']),
            Carbon::parse($validated['end_date_1']),
            Carbon::parse($validated['start_date_2']),
            Carbon::parse($validated['end_date_2'])
        );

        return response()->json($comparison);
    }

    /**
     * Get expense analytics data.
     */
    public function analytics(Request $request)
    {
        $year = $request->get('year', Carbon::now()->year);
        $month = $request->get('month');

        $data = [
            'yearly_summary' => Expense::getYearlySummary($year),
            'categories' => Expense::getCategories(),
        ];

        if ($month) {
            $data['monthly_summary'] = Expense::getMonthlySummary($year, $month);
        }

        // Get trend data for the last 12 months
        $trendData = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthSummary = Expense::getMonthlySummary($date->year, $date->month);
            $trendData[] = [
                'month' => $date->format('M Y'),
                'total' => $monthSummary['total_amount'],
                'count' => $monthSummary['total_count'],
            ];
        }
        $data['trend_data'] = $trendData;

        return response()->json($data);
    }

    /**
     * Get expense data for profitability calculations.
     */
    public function profitability(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);

        $totalExpenses = Expense::getTotalOperationalExpenses($startDate, $endDate);
        
        $expensesByCategory = Expense::inDateRange($startDate, $endDate)
            ->selectRaw('category, SUM(amount) as total')
            ->groupBy('category')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->category => $item->total];
            });

        return response()->json([
            'total_expenses' => $totalExpenses,
            'expenses_by_category' => $expensesByCategory,
            'period' => [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
            ],
        ]);
    }

    /**
     * Search expenses with filters.
     */
    public function search(Request $request)
    {
        $query = Expense::with('creator')->latest('expense_date');

        // Apply filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('start_date')) {
            $query->where('expense_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('expense_date', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('min_amount')) {
            $query->where('amount', '>=', $request->min_amount);
        }

        if ($request->filled('max_amount')) {
            $query->where('amount', '<=', $request->max_amount);
        }

        $expenses = $query->paginate(15);

        return response()->json([
            'expenses' => $expenses->items(),
            'pagination' => [
                'current_page' => $expenses->currentPage(),
                'last_page' => $expenses->lastPage(),
                'per_page' => $expenses->perPage(),
                'total' => $expenses->total(),
            ],
            'summary' => [
                'total_amount' => $query->sum('amount'),
                'count' => $query->count(),
            ],
        ]);
    }
}