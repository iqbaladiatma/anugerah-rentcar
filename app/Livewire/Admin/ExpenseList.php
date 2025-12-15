<?php

namespace App\Livewire\Admin;

use App\Models\Expense;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class ExpenseList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';
    public $startDate = '';
    public $endDate = '';
    public $minAmount = '';
    public $maxAmount = '';
    public $createdBy = '';
    public $sortBy = 'expense_date';
    public $sortOrder = 'desc';
    public $perPage = 15;

    public $showFilters = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'sortBy' => ['except' => 'expense_date'],
        'sortOrder' => ['except' => 'desc'],
        'page' => ['except' => 1],
    ];

    public function mount()
    {
        // Set default date range to current month
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingCategory()
    {
        $this->resetPage();
    }

    public function updatingStartDate()
    {
        $this->resetPage();
    }

    public function updatingEndDate()
    {
        $this->resetPage();
    }

    public function updatingMinAmount()
    {
        $this->resetPage();
    }

    public function updatingMaxAmount()
    {
        $this->resetPage();
    }

    public function updatingCreatedBy()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($this->sortBy === $field) {
            $this->sortOrder = $this->sortOrder === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortOrder = 'asc';
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->endDate = Carbon::now()->endOfMonth()->format('Y-m-d');
        $this->minAmount = '';
        $this->maxAmount = '';
        $this->createdBy = '';
        $this->sortBy = 'expense_date';
        $this->sortOrder = 'desc';
        $this->resetPage();
    }

    public function toggleFilters()
    {
        $this->showFilters = !$this->showFilters;
    }

    public function setDateRange($range)
    {
        $now = Carbon::now();
        
        switch ($range) {
            case 'today':
                $this->startDate = $now->format('Y-m-d');
                $this->endDate = $now->format('Y-m-d');
                break;
            case 'yesterday':
                $yesterday = $now->subDay();
                $this->startDate = $yesterday->format('Y-m-d');
                $this->endDate = $yesterday->format('Y-m-d');
                break;
            case 'this_week':
                $this->startDate = $now->startOfWeek()->format('Y-m-d');
                $this->endDate = $now->endOfWeek()->format('Y-m-d');
                break;
            case 'last_week':
                $lastWeek = $now->subWeek();
                $this->startDate = $lastWeek->startOfWeek()->format('Y-m-d');
                $this->endDate = $lastWeek->endOfWeek()->format('Y-m-d');
                break;
            case 'this_month':
                $this->startDate = $now->startOfMonth()->format('Y-m-d');
                $this->endDate = $now->endOfMonth()->format('Y-m-d');
                break;
            case 'last_month':
                $lastMonth = $now->subMonth();
                $this->startDate = $lastMonth->startOfMonth()->format('Y-m-d');
                $this->endDate = $lastMonth->endOfMonth()->format('Y-m-d');
                break;
            case 'this_year':
                $this->startDate = $now->startOfYear()->format('Y-m-d');
                $this->endDate = $now->endOfYear()->format('Y-m-d');
                break;
        }
        
        $this->resetPage();
    }

    public function deleteExpense($expenseId)
    {
        $expense = Expense::find($expenseId);
        
        if ($expense) {
            // Delete receipt photo if exists
            if ($expense->receipt_photo) {
                \Storage::disk('public')->delete($expense->receipt_photo);
            }
            
            $expense->delete();
            
            session()->flash('success', 'Expense deleted successfully.');
        }
    }

    public function render()
    {
        $query = Expense::with('creator');

        // Apply filters
        if ($this->search) {
            $query->where('description', 'like', '%' . $this->search . '%');
        }

        if ($this->category) {
            $query->where('category', $this->category);
        }

        if ($this->startDate) {
            $query->where('expense_date', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->where('expense_date', '<=', $this->endDate);
        }

        if ($this->minAmount) {
            $query->where('amount', '>=', $this->minAmount);
        }

        if ($this->maxAmount) {
            $query->where('amount', '<=', $this->maxAmount);
        }

        if ($this->createdBy) {
            $query->where('created_by', $this->createdBy);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortOrder);

        $expenses = $query->paginate($this->perPage);

        // Calculate totals for current filter
        $totalAmount = $query->sum('amount');
        $totalCount = $query->count();

        return view('livewire.admin.expense-list', [
            'expenses' => $expenses,
            'categories' => Expense::getCategories(),
            'users' => User::where('role', '!=', 'customer')->get(),
            'totalAmount' => $totalAmount,
            'totalCount' => $totalCount,
        ]);
    }
}