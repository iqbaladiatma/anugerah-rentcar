<?php

namespace App\Livewire\Admin;

use App\Models\Expense;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class ExpenseList extends Component
{
    use WithPagination;

    #[Url]
    public $search = '';
    
    #[Url]
    public $category = '';
    
    #[Url]
    public $startDate = '';
    
    #[Url]
    public $endDate = '';
    
    #[Url]
    public $minAmount = '';
    
    #[Url]
    public $maxAmount = '';

    public $sortField = 'expense_date';
    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'category' => ['except' => ''],
        'startDate' => ['except' => ''],
        'endDate' => ['except' => ''],
        'minAmount' => ['except' => ''],
        'maxAmount' => ['except' => ''],
    ];

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

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->category = '';
        $this->startDate = '';
        $this->endDate = '';
        $this->minAmount = '';
        $this->maxAmount = '';
        $this->resetPage();
    }

    public function deleteExpense($expenseId)
    {
        $expense = Expense::findOrFail($expenseId);
        
        // Delete receipt photo if exists
        if ($expense->receipt_photo) {
            \Storage::disk('public')->delete($expense->receipt_photo);
        }

        $expense->delete();

        session()->flash('success', 'Expense deleted successfully.');
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

        // Apply sorting
        $query->orderBy($this->sortField, $this->sortDirection);

        $expenses = $query->paginate(15);

        // Calculate summary for current filters
        $summaryQuery = clone $query;
        $totalAmount = $summaryQuery->sum('amount');
        $totalCount = $summaryQuery->count();

        return view('livewire.admin.expense-list', [
            'expenses' => $expenses,
            'categories' => Expense::getCategories(),
            'totalAmount' => $totalAmount,
            'totalCount' => $totalCount,
        ]);
    }
}