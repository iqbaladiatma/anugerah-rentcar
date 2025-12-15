<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Booking;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

class CustomerService
{
    /**
     * Search customers with multiple criteria.
     */
    public function searchCustomers(array $filters): Collection
    {
        $query = Customer::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['phone'])) {
            $query->where('phone', 'like', '%' . $filters['phone'] . '%');
        }

        if (!empty($filters['email'])) {
            $query->where('email', 'like', '%' . $filters['email'] . '%');
        }

        if (!empty($filters['nik'])) {
            $query->where('nik', 'like', '%' . $filters['nik'] . '%');
        }

        if (isset($filters['is_member'])) {
            $query->where('is_member', $filters['is_member']);
        }

        if (isset($filters['is_blacklisted'])) {
            $query->where('is_blacklisted', $filters['is_blacklisted']);
        }

        return $query->orderBy('name')->get();
    }

    /**
     * Get customers by member status.
     */
    public function getMemberCustomers(): Collection
    {
        return Customer::members()->orderBy('name')->get();
    }

    /**
     * Get blacklisted customers.
     */
    public function getBlacklistedCustomers(): Collection
    {
        return Customer::blacklisted()->orderBy('name')->get();
    }

    /**
     * Get active customers (not blacklisted).
     */
    public function getActiveCustomers(): Collection
    {
        return Customer::active()->orderBy('name')->get();
    }

    /**
     * Check if customer can make a new booking.
     */
    public function canCustomerMakeBooking(Customer $customer): bool
    {
        return $customer->canMakeBooking();
    }

    /**
     * Assign member status to customer.
     */
    public function assignMemberStatus(Customer $customer, ?float $customDiscountPercentage = null): void
    {
        $discountPercentage = $customDiscountPercentage ?? Setting::current()->getMemberDiscountPercentage();
        
        $customer->update([
            'is_member' => true,
            'member_discount' => $discountPercentage
        ]);
    }

    /**
     * Remove member status from customer.
     */
    public function removeMemberStatus(Customer $customer): void
    {
        $customer->update([
            'is_member' => false,
            'member_discount' => null
        ]);
    }

    /**
     * Add customer to blacklist.
     */
    public function blacklistCustomer(Customer $customer, string $reason): void
    {
        $customer->blacklist($reason);
        
        // Cancel any pending or confirmed bookings
        $customer->bookings()
            ->whereIn('booking_status', [Booking::STATUS_PENDING, Booking::STATUS_CONFIRMED])
            ->each(function ($booking) {
                $booking->cancel();
            });
    }

    /**
     * Remove customer from blacklist.
     */
    public function removeFromBlacklist(Customer $customer): void
    {
        $customer->removeFromBlacklist();
    }

    /**
     * Get customer booking statistics.
     */
    public function getCustomerStatistics(Customer $customer): array
    {
        $totalBookings = $customer->bookings()->count();
        $completedBookings = $customer->completedBookings()->count();
        $activeBookings = $customer->activeBookings()->count();
        $cancelledBookings = $customer->bookings()->where('booking_status', Booking::STATUS_CANCELLED)->count();
        
        $totalRevenue = $customer->bookings()
            ->where('booking_status', Booking::STATUS_COMPLETED)
            ->sum('total_amount');
            
        $averageBookingValue = $completedBookings > 0 ? $totalRevenue / $completedBookings : 0;
        
        $lastBooking = $customer->bookings()
            ->orderBy('created_at', 'desc')
            ->first();

        return [
            'total_bookings' => $totalBookings,
            'completed_bookings' => $completedBookings,
            'active_bookings' => $activeBookings,
            'cancelled_bookings' => $cancelledBookings,
            'total_revenue' => $totalRevenue,
            'average_booking_value' => $averageBookingValue,
            'last_booking_date' => $lastBooking?->created_at,
            'completion_rate' => $totalBookings > 0 ? ($completedBookings / $totalBookings) * 100 : 0
        ];
    }

    /**
     * Get customer discount information.
     */
    public function getCustomerDiscountInfo(Customer $customer): array
    {
        return [
            'is_member' => $customer->is_member,
            'discount_percentage' => $customer->getMemberDiscountPercentage(),
            'custom_discount' => $customer->member_discount,
            'system_default_discount' => Setting::current()->getMemberDiscountPercentage()
        ];
    }

    /**
     * Calculate member discount for amount.
     */
    public function calculateMemberDiscount(Customer $customer, float $amount): float
    {
        return $customer->calculateMemberDiscountAmount($amount);
    }

    /**
     * Apply member discount to amount.
     */
    public function applyMemberDiscount(Customer $customer, float $amount): float
    {
        return $customer->applyMemberDiscount($amount);
    }

    /**
     * Get customers with overdue bookings.
     */
    public function getCustomersWithOverdueBookings(): Collection
    {
        return Customer::whereHas('bookings', function (Builder $query) {
            $query->overdue();
        })->with(['bookings' => function ($query) {
            $query->overdue();
        }])->get();
    }

    /**
     * Get customer loyalty tier based on booking history.
     */
    public function getCustomerLoyaltyTier(Customer $customer): string
    {
        $completedBookings = $customer->completedBookings()->count();
        $totalRevenue = $customer->bookings()
            ->where('booking_status', Booking::STATUS_COMPLETED)
            ->sum('total_amount');

        if ($completedBookings >= 20 || $totalRevenue >= 50000000) {
            return 'platinum';
        } elseif ($completedBookings >= 10 || $totalRevenue >= 20000000) {
            return 'gold';
        } elseif ($completedBookings >= 5 || $totalRevenue >= 10000000) {
            return 'silver';
        } else {
            return 'bronze';
        }
    }

    /**
     * Get customer risk assessment.
     */
    public function getCustomerRiskAssessment(Customer $customer): array
    {
        $statistics = $this->getCustomerStatistics($customer);
        
        $riskFactors = [];
        $riskScore = 0;

        // Check completion rate
        if ($statistics['completion_rate'] < 80) {
            $riskFactors[] = 'Low completion rate';
            $riskScore += 30;
        }

        // Check for frequent cancellations
        if ($statistics['cancelled_bookings'] > 3) {
            $riskFactors[] = 'Frequent cancellations';
            $riskScore += 20;
        }

        // Check for overdue bookings
        $overdueBookings = $customer->bookings()->overdue()->count();
        if ($overdueBookings > 0) {
            $riskFactors[] = 'Has overdue bookings';
            $riskScore += 40;
        }

        // Check if blacklisted
        if ($customer->is_blacklisted) {
            $riskFactors[] = 'Currently blacklisted';
            $riskScore += 100;
        }

        // Determine risk level
        $riskLevel = 'low';
        if ($riskScore >= 70) {
            $riskLevel = 'high';
        } elseif ($riskScore >= 40) {
            $riskLevel = 'medium';
        }

        return [
            'risk_level' => $riskLevel,
            'risk_score' => $riskScore,
            'risk_factors' => $riskFactors,
            'overdue_bookings' => $overdueBookings
        ];
    }

    /**
     * Validate customer data for booking eligibility.
     */
    public function validateCustomerForBooking(Customer $customer): array
    {
        $errors = [];

        if ($customer->is_blacklisted) {
            $errors[] = 'Customer is blacklisted: ' . $customer->blacklist_reason;
        }

        if (!$customer->ktp_photo) {
            $errors[] = 'KTP photo is required';
        }

        if (!$customer->sim_photo) {
            $errors[] = 'SIM photo is required';
        }

        if (!$customer->phone) {
            $errors[] = 'Phone number is required';
        }

        // Check for active overdue bookings
        $overdueBookings = $customer->bookings()->overdue()->count();
        if ($overdueBookings > 0) {
            $errors[] = "Customer has {$overdueBookings} overdue booking(s)";
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }
}