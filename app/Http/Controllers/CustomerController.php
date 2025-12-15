<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Display a listing of customers.
     */
    public function index(): View
    {
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new customer.
     */
    public function create(): View
    {
        return view('admin.customers.create');
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers',
            'email' => 'nullable|email|max:255|unique:customers',
            'nik' => 'required|string|size:16|unique:customers',
            'address' => 'required|string|max:500',
            'ktp_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'sim_photo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'is_member' => 'boolean',
            'member_discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Handle photo uploads
        if ($request->hasFile('ktp_photo')) {
            $validated['ktp_photo'] = $this->storeCustomerDocument($request->file('ktp_photo'), $validated['nik'], 'ktp');
        }

        if ($request->hasFile('sim_photo')) {
            $validated['sim_photo'] = $this->storeCustomerDocument($request->file('sim_photo'), $validated['nik'], 'sim');
        }

        // Set default values
        $validated['is_member'] = $validated['is_member'] ?? false;
        $validated['is_blacklisted'] = false;

        $customer = Customer::create($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer created successfully.');
    }

    /**
     * Display the specified customer.
     */
    public function show(Customer $customer): View
    {
        $customer->load(['bookings' => function ($query) {
            $query->latest()->limit(10);
        }]);

        $statistics = $this->customerService->getCustomerStatistics($customer);
        $discountInfo = $this->customerService->getCustomerDiscountInfo($customer);
        $loyaltyTier = $this->customerService->getCustomerLoyaltyTier($customer);
        $riskAssessment = $this->customerService->getCustomerRiskAssessment($customer);

        return view('admin.customers.show', compact(
            'customer', 
            'statistics', 
            'discountInfo', 
            'loyaltyTier', 
            'riskAssessment'
        ));
    }

    /**
     * Show the form for editing the specified customer.
     */
    public function edit(Customer $customer): View
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'string', 'max:20', Rule::unique('customers')->ignore($customer->id)],
            'email' => ['nullable', 'email', 'max:255', Rule::unique('customers')->ignore($customer->id)],
            'nik' => ['required', 'string', 'size:16', Rule::unique('customers')->ignore($customer->id)],
            'address' => 'required|string|max:500',
            'ktp_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'sim_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'is_member' => 'boolean',
            'member_discount' => 'nullable|numeric|min:0|max:100',
        ]);

        // Handle photo uploads
        if ($request->hasFile('ktp_photo')) {
            // Delete old photo if exists
            if ($customer->ktp_photo) {
                Storage::disk('public')->delete($customer->ktp_photo);
            }
            $validated['ktp_photo'] = $this->storeCustomerDocument($request->file('ktp_photo'), $validated['nik'], 'ktp');
        }

        if ($request->hasFile('sim_photo')) {
            // Delete old photo if exists
            if ($customer->sim_photo) {
                Storage::disk('public')->delete($customer->sim_photo);
            }
            $validated['sim_photo'] = $this->storeCustomerDocument($request->file('sim_photo'), $validated['nik'], 'sim');
        }

        // Set default values
        $validated['is_member'] = $validated['is_member'] ?? false;

        $customer->update($validated);

        return redirect()->route('admin.customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy(Customer $customer): RedirectResponse
    {
        // Check if customer has active bookings
        if ($customer->activeBookings()->exists()) {
            return redirect()->route('admin.customers.index')
                ->with('error', 'Cannot delete customer with active bookings.');
        }

        // Delete photos
        if ($customer->ktp_photo) {
            Storage::disk('public')->delete($customer->ktp_photo);
        }
        if ($customer->sim_photo) {
            Storage::disk('public')->delete($customer->sim_photo);
        }

        $customer->delete();

        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer deleted successfully.');
    }

    /**
     * Display member customers.
     */
    public function members(): View
    {
        return view('admin.customers.members');
    }

    /**
     * Display blacklisted customers.
     */
    public function blacklist(): View
    {
        return view('admin.customers.blacklist');
    }

    /**
     * Update customer member status.
     */
    public function updateMemberStatus(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'is_member' => 'required|boolean',
            'member_discount' => 'nullable|numeric|min:0|max:100',
        ]);

        if ($validated['is_member']) {
            $this->customerService->assignMemberStatus(
                $customer, 
                $validated['member_discount'] ?? null
            );
            $message = 'Customer assigned member status successfully.';
        } else {
            $this->customerService->removeMemberStatus($customer);
            $message = 'Customer member status removed successfully.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update customer blacklist status.
     */
    public function updateBlacklistStatus(Request $request, Customer $customer): RedirectResponse
    {
        $validated = $request->validate([
            'is_blacklisted' => 'required|boolean',
            'blacklist_reason' => 'required_if:is_blacklisted,true|nullable|string|max:500',
        ]);

        if ($validated['is_blacklisted']) {
            $this->customerService->blacklistCustomer(
                $customer, 
                $validated['blacklist_reason']
            );
            $message = 'Customer added to blacklist successfully.';
        } else {
            $this->customerService->removeFromBlacklist($customer);
            $message = 'Customer removed from blacklist successfully.';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Search customers with filters.
     */
    public function search(Request $request): View
    {
        $filters = $request->validate([
            'name' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'nik' => 'nullable|string|max:16',
            'is_member' => 'nullable|boolean',
            'is_blacklisted' => 'nullable|boolean',
        ]);

        $customers = $this->customerService->searchCustomers($filters);

        return view('admin.customers.search', compact('customers', 'filters'));
    }

    /**
     * Get customer booking validation.
     */
    public function validateForBooking(Customer $customer): array
    {
        return $this->customerService->validateCustomerForBooking($customer);
    }

    /**
     * Store customer document with proper naming and validation.
     */
    private function storeCustomerDocument($file, string $nik, string $documentType): string
    {
        // Sanitize NIK for filename
        $sanitizedNik = preg_replace('/[^A-Za-z0-9]/', '_', $nik);
        
        // Generate filename with timestamp to avoid conflicts
        $timestamp = now()->format('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $filename = "customers/{$sanitizedNik}_{$documentType}_{$timestamp}.{$extension}";
        
        return $file->storeAs('public', $filename);
    }
}