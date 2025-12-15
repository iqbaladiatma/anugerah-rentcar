<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Services\CustomerService;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerSearch extends Component
{
    use WithPagination;

    protected CustomerService $customerService;

    // Search filters
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $nik = '';
    public ?bool $is_member = null;
    public ?bool $is_blacklisted = null;
    public string $loyalty_tier = '';
    public string $risk_level = '';

    // Advanced filters
    public bool $showAdvancedFilters = false;
    public ?int $min_bookings = null;
    public ?int $max_bookings = null;
    public ?float $min_revenue = null;
    public ?float $max_revenue = null;
    public bool $has_overdue_bookings = false;

    // Results
    public $searchResults = null;
    public bool $hasSearched = false;

    public function boot(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    public function updatedName()
    {
        $this->performSearch();
    }

    public function updatedPhone()
    {
        $this->performSearch();
    }

    public function updatedEmail()
    {
        $this->performSearch();
    }

    public function updatedNik()
    {
        $this->performSearch();
    }

    public function updatedIsMember()
    {
        $this->performSearch();
    }

    public function updatedIsBlacklisted()
    {
        $this->performSearch();
    }

    public function toggleAdvancedFilters()
    {
        $this->showAdvancedFilters = !$this->showAdvancedFilters;
    }

    public function performSearch()
    {
        $this->resetPage();
        
        $filters = array_filter([
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
            'nik' => $this->nik,
            'is_member' => $this->is_member,
            'is_blacklisted' => $this->is_blacklisted,
        ], function ($value) {
            return $value !== null && $value !== '';
        });

        if (empty($filters) && !$this->hasAdvancedFilters()) {
            $this->searchResults = collect();
            $this->hasSearched = false;
            return;
        }

        $query = Customer::query()->with(['bookings']);

        // Apply basic filters
        foreach ($filters as $field => $value) {
            if ($field === 'name') {
                $query->where('name', 'like', '%' . $value . '%');
            } elseif (in_array($field, ['phone', 'email', 'nik'])) {
                $query->where($field, 'like', '%' . $value . '%');
            } else {
                $query->where($field, $value);
            }
        }

        // Apply advanced filters
        if ($this->min_bookings !== null || $this->max_bookings !== null) {
            $query->withCount('bookings');
            
            if ($this->min_bookings !== null) {
                $query->having('bookings_count', '>=', $this->min_bookings);
            }
            
            if ($this->max_bookings !== null) {
                $query->having('bookings_count', '<=', $this->max_bookings);
            }
        }

        if ($this->has_overdue_bookings) {
            $query->whereHas('bookings', function ($q) {
                $q->overdue();
            });
        }

        $customers = $query->orderBy('name')->paginate(20);

        // Apply revenue and loyalty tier filters (post-query filtering for complex calculations)
        $filteredCustomers = $customers->getCollection()->filter(function ($customer) {
            $statistics = $this->customerService->getCustomerStatistics($customer);
            
            // Revenue filter
            if ($this->min_revenue !== null && $statistics['total_revenue'] < $this->min_revenue) {
                return false;
            }
            
            if ($this->max_revenue !== null && $statistics['total_revenue'] > $this->max_revenue) {
                return false;
            }

            // Loyalty tier filter
            if ($this->loyalty_tier) {
                $loyaltyTier = $this->customerService->getCustomerLoyaltyTier($customer);
                if ($loyaltyTier !== $this->loyalty_tier) {
                    return false;
                }
            }

            // Risk level filter
            if ($this->risk_level) {
                $riskAssessment = $this->customerService->getCustomerRiskAssessment($customer);
                if ($riskAssessment['risk_level'] !== $this->risk_level) {
                    return false;
                }
            }

            return true;
        });

        $customers->setCollection($filteredCustomers);
        $this->searchResults = $customers;
        $this->hasSearched = true;
    }

    public function clearFilters()
    {
        $this->name = '';
        $this->phone = '';
        $this->email = '';
        $this->nik = '';
        $this->is_member = null;
        $this->is_blacklisted = null;
        $this->loyalty_tier = '';
        $this->risk_level = '';
        $this->min_bookings = null;
        $this->max_bookings = null;
        $this->min_revenue = null;
        $this->max_revenue = null;
        $this->has_overdue_bookings = false;
        $this->searchResults = null;
        $this->hasSearched = false;
        $this->resetPage();
    }

    private function hasAdvancedFilters(): bool
    {
        return $this->min_bookings !== null ||
               $this->max_bookings !== null ||
               $this->min_revenue !== null ||
               $this->max_revenue !== null ||
               $this->loyalty_tier !== '' ||
               $this->risk_level !== '' ||
               $this->has_overdue_bookings;
    }

    public function render()
    {
        $customerStats = [];
        
        if ($this->searchResults && $this->searchResults->count() > 0) {
            foreach ($this->searchResults as $customer) {
                $customerStats[$customer->id] = [
                    'statistics' => $this->customerService->getCustomerStatistics($customer),
                    'loyalty_tier' => $this->customerService->getCustomerLoyaltyTier($customer),
                    'risk_assessment' => $this->customerService->getCustomerRiskAssessment($customer),
                ];
            }
        }

        return view('livewire.admin.customer-search', [
            'customerStats' => $customerStats,
            'memberOptions' => [
                null => 'All',
                true => 'Members',
                false => 'Non-Members',
            ],
            'blacklistOptions' => [
                null => 'All',
                false => 'Active',
                true => 'Blacklisted',
            ],
            'loyaltyTierOptions' => [
                '' => 'All Tiers',
                'bronze' => 'Bronze',
                'silver' => 'Silver',
                'gold' => 'Gold',
                'platinum' => 'Platinum',
            ],
            'riskLevelOptions' => [
                '' => 'All Risk Levels',
                'low' => 'Low Risk',
                'medium' => 'Medium Risk',
                'high' => 'High Risk',
            ],
        ]);
    }
}