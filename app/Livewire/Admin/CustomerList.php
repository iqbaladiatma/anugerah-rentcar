<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Services\CustomerService;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class CustomerList extends Component
{
    use WithPagination;

    protected CustomerService $customerService;

    #[Url]
    public string $search = '';

    #[Url]
    public string $memberStatus = '';

    #[Url]
    public string $blacklistStatus = '';

    #[Url]
    public string $sortBy = 'name';

    #[Url]
    public string $sortDirection = 'asc';

    public bool $showMembersOnly = false;
    public bool $showBlacklistedOnly = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'memberStatus' => ['except' => ''],
        'blacklistStatus' => ['except' => ''],
        'sortBy' => ['except' => 'name'],
        'sortDirection' => ['except' => 'asc'],
    ];

    public function boot(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingMemberStatus()
    {
        $this->resetPage();
    }

    public function updatingBlacklistStatus()
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
    }

    public function toggleMembersOnly()
    {
        $this->showMembersOnly = !$this->showMembersOnly;
        $this->memberStatus = $this->showMembersOnly ? '1' : '';
        $this->resetPage();
    }

    public function toggleBlacklistedOnly()
    {
        $this->showBlacklistedOnly = !$this->showBlacklistedOnly;
        $this->blacklistStatus = $this->showBlacklistedOnly ? '1' : '';
        $this->resetPage();
    }

    public function updateMemberStatus($customerId, $isMember, $memberDiscount = null)
    {
        $customer = Customer::findOrFail($customerId);
        
        if ($isMember) {
            $this->customerService->assignMemberStatus($customer, $memberDiscount);
            session()->flash('success', "Customer {$customer->name} assigned member status successfully.");
        } else {
            $this->customerService->removeMemberStatus($customer);
            session()->flash('success', "Customer {$customer->name} member status removed successfully.");
        }
    }

    public function updateBlacklistStatus($customerId, $isBlacklisted, $reason = null)
    {
        $customer = Customer::findOrFail($customerId);
        
        if ($isBlacklisted && !$reason) {
            session()->flash('error', 'Blacklist reason is required.');
            return;
        }

        if ($isBlacklisted) {
            $this->customerService->blacklistCustomer($customer, $reason);
            session()->flash('success', "Customer {$customer->name} added to blacklist successfully.");
        } else {
            $this->customerService->removeFromBlacklist($customer);
            session()->flash('success', "Customer {$customer->name} removed from blacklist successfully.");
        }
    }

    public function clearFilters()
    {
        $this->search = '';
        $this->memberStatus = '';
        $this->blacklistStatus = '';
        $this->showMembersOnly = false;
        $this->showBlacklistedOnly = false;
        $this->resetPage();
    }

    public function render()
    {
        $query = Customer::query()
            ->with(['bookings' => function ($q) {
                $q->whereIn('booking_status', ['confirmed', 'active'])->latest();
            }]);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('phone', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%')
                  ->orWhere('nik', 'like', '%' . $this->search . '%');
            });
        }

        // Apply member status filter
        if ($this->memberStatus !== '') {
            $query->where('is_member', (bool) $this->memberStatus);
        }

        // Apply blacklist status filter
        if ($this->blacklistStatus !== '') {
            $query->where('is_blacklisted', (bool) $this->blacklistStatus);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $customers = $query->paginate(15);

        // Get customer statistics for each customer
        $customerStats = [];
        foreach ($customers as $customer) {
            $customerStats[$customer->id] = $this->customerService->getCustomerStatistics($customer);
        }

        return view('livewire.admin.customer-list', [
            'customers' => $customers,
            'customerStats' => $customerStats,
            'memberStatusOptions' => [
                '' => 'All Customers',
                '1' => 'Members Only',
                '0' => 'Non-Members Only',
            ],
            'blacklistStatusOptions' => [
                '' => 'All Customers',
                '0' => 'Active Customers',
                '1' => 'Blacklisted Only',
            ],
        ]);
    }
}