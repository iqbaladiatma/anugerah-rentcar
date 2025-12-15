<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Customer;
use App\Models\Setting;
use Carbon\Carbon;

class BookingCalculatorService
{
    /**
     * Calculate booking pricing for given parameters.
     */
    public function calculateBookingPrice(array $params): array
    {
        $car = Car::findOrFail($params['car_id']);
        $customer = isset($params['customer_id']) ? Customer::find($params['customer_id']) : null;
        
        $startDate = Carbon::parse($params['start_date']);
        $endDate = Carbon::parse($params['end_date']);
        $withDriver = $params['with_driver'] ?? false;
        $isOutOfTown = $params['is_out_of_town'] ?? false;
        $outOfTownFee = $params['out_of_town_fee'] ?? 0;

        // Calculate duration
        $durationInDays = $this->calculateDurationInDays($startDate, $endDate);
        $durationInHours = $this->calculateDurationInHours($startDate, $endDate);

        // Calculate base amount (vehicle rental)
        $baseAmount = $this->calculateBaseAmount($car, $durationInDays);

        // Calculate driver fee
        $driverFee = $this->calculateDriverFee($car, $durationInDays, $withDriver);

        // Calculate subtotal before discount
        $subtotal = $baseAmount + $driverFee + $outOfTownFee;

        // Calculate member discount
        $memberDiscount = $this->calculateMemberDiscount($customer, $subtotal);

        // Calculate total amount
        $totalAmount = $subtotal - $memberDiscount;

        // Calculate deposit (typically 30% of total)
        $depositAmount = $this->calculateDepositAmount($totalAmount);

        return [
            'duration_days' => $durationInDays,
            'duration_hours' => $durationInHours,
            'base_amount' => $baseAmount,
            'driver_fee' => $driverFee,
            'out_of_town_fee' => $outOfTownFee,
            'subtotal' => $subtotal,
            'member_discount' => $memberDiscount,
            'total_amount' => $totalAmount,
            'deposit_amount' => $depositAmount,
            'remaining_amount' => $totalAmount - $depositAmount,
            'breakdown' => $this->getPriceBreakdown($car, $durationInDays, $withDriver, $customer)
        ];
    }

    /**
     * Calculate duration in days (minimum 1 day).
     */
    public function calculateDurationInDays(Carbon $startDate, Carbon $endDate): int
    {
        return max(1, $startDate->diffInDays($endDate) + 1);
    }

    /**
     * Calculate duration in hours.
     */
    public function calculateDurationInHours(Carbon $startDate, Carbon $endDate): int
    {
        return $startDate->diffInHours($endDate);
    }

    /**
     * Calculate base rental amount using car rates.
     */
    public function calculateBaseAmount(Car $car, int $days): float
    {
        return $car->calculateRate($days);
    }

    /**
     * Calculate driver fee if driver is requested.
     */
    public function calculateDriverFee(Car $car, int $days, bool $withDriver): float
    {
        if (!$withDriver) {
            return 0;
        }

        return $days * $car->driver_fee_per_day;
    }

    /**
     * Calculate member discount amount.
     */
    public function calculateMemberDiscount(?Customer $customer, float $amount): float
    {
        if (!$customer || !$customer->is_member) {
            return 0;
        }

        return $customer->calculateMemberDiscountAmount($amount);
    }

    /**
     * Calculate deposit amount (30% of total).
     */
    public function calculateDepositAmount(float $totalAmount): float
    {
        return round($totalAmount * 0.3, 2);
    }

    /**
     * Get detailed price breakdown.
     */
    public function getPriceBreakdown(Car $car, int $days, bool $withDriver, ?Customer $customer): array
    {
        $breakdown = [];

        // Vehicle rental breakdown
        if ($days >= 7) {
            $weeks = floor($days / 7);
            $remainingDays = $days % 7;
            
            if ($weeks > 0) {
                $breakdown[] = [
                    'description' => "Weekly rate ({$weeks} week" . ($weeks > 1 ? 's' : '') . ")",
                    'quantity' => $weeks,
                    'rate' => $car->weekly_rate,
                    'amount' => $weeks * $car->weekly_rate
                ];
            }
            
            if ($remainingDays > 0) {
                $breakdown[] = [
                    'description' => "Daily rate ({$remainingDays} day" . ($remainingDays > 1 ? 's' : '') . ")",
                    'quantity' => $remainingDays,
                    'rate' => $car->daily_rate,
                    'amount' => $remainingDays * $car->daily_rate
                ];
            }
        } else {
            $breakdown[] = [
                'description' => "Daily rate ({$days} day" . ($days > 1 ? 's' : '') . ")",
                'quantity' => $days,
                'rate' => $car->daily_rate,
                'amount' => $days * $car->daily_rate
            ];
        }

        // Driver fee breakdown
        if ($withDriver) {
            $breakdown[] = [
                'description' => "Driver fee ({$days} day" . ($days > 1 ? 's' : '') . ")",
                'quantity' => $days,
                'rate' => $car->driver_fee_per_day,
                'amount' => $days * $car->driver_fee_per_day
            ];
        }

        // Member discount breakdown
        if ($customer && $customer->is_member) {
            $discountPercentage = $customer->getMemberDiscountPercentage();
            $breakdown[] = [
                'description' => "Member discount ({$discountPercentage}%)",
                'quantity' => 1,
                'rate' => -$discountPercentage,
                'amount' => 'calculated_from_subtotal',
                'is_discount' => true
            ];
        }

        return $breakdown;
    }

    /**
     * Calculate real-time pricing for booking form.
     */
    public function calculateRealTimePrice(array $params): array
    {
        try {
            return $this->calculateBookingPrice($params);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Unable to calculate pricing: ' . $e->getMessage(),
                'total_amount' => 0,
                'base_amount' => 0,
                'driver_fee' => 0,
                'member_discount' => 0,
                'deposit_amount' => 0
            ];
        }
    }

    /**
     * Validate booking parameters for pricing calculation.
     */
    public function validateBookingParameters(array $params): array
    {
        $errors = [];

        if (empty($params['car_id'])) {
            $errors[] = 'Car ID is required';
        } else {
            $car = Car::find($params['car_id']);
            if (!$car) {
                $errors[] = 'Invalid car selected';
            } elseif ($car->status !== Car::STATUS_AVAILABLE) {
                $errors[] = 'Selected car is not available';
            }
        }

        if (empty($params['start_date'])) {
            $errors[] = 'Start date is required';
        }

        if (empty($params['end_date'])) {
            $errors[] = 'End date is required';
        }

        if (!empty($params['start_date']) && !empty($params['end_date'])) {
            $startDate = Carbon::parse($params['start_date']);
            $endDate = Carbon::parse($params['end_date']);

            if ($startDate >= $endDate) {
                $errors[] = 'End date must be after start date';
            }

            if ($startDate < Carbon::now()) {
                $errors[] = 'Start date cannot be in the past';
            }
        }

        if (isset($params['customer_id']) && !empty($params['customer_id'])) {
            $customer = Customer::find($params['customer_id']);
            if (!$customer) {
                $errors[] = 'Invalid customer selected';
            } elseif ($customer->is_blacklisted) {
                $errors[] = 'Customer is blacklisted and cannot make bookings';
            }
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Compare pricing between different vehicles.
     */
    public function comparePricing(array $carIds, array $bookingParams): array
    {
        $comparisons = [];

        foreach ($carIds as $carId) {
            $params = array_merge($bookingParams, ['car_id' => $carId]);
            $validation = $this->validateBookingParameters($params);

            if ($validation['is_valid']) {
                $pricing = $this->calculateBookingPrice($params);
                $car = Car::find($carId);
                
                $comparisons[] = [
                    'car' => [
                        'id' => $car->id,
                        'license_plate' => $car->license_plate,
                        'brand' => $car->brand,
                        'model' => $car->model,
                        'daily_rate' => $car->daily_rate,
                        'weekly_rate' => $car->weekly_rate
                    ],
                    'pricing' => $pricing
                ];
            }
        }

        // Sort by total amount
        usort($comparisons, function ($a, $b) {
            return $a['pricing']['total_amount'] <=> $b['pricing']['total_amount'];
        });

        return $comparisons;
    }

    /**
     * Calculate package pricing (weekly/monthly discounts).
     */
    public function calculatePackagePrice(Car $car, int $days, string $packageType = 'daily'): array
    {
        $basePrice = $car->daily_rate * $days;
        $packagePrice = $basePrice;
        $savings = 0;

        switch ($packageType) {
            case 'weekly':
                if ($days >= 7) {
                    $weeks = floor($days / 7);
                    $remainingDays = $days % 7;
                    $packagePrice = ($weeks * $car->weekly_rate) + ($remainingDays * $car->daily_rate);
                    $savings = $basePrice - $packagePrice;
                }
                break;
            
            case 'monthly':
                if ($days >= 30) {
                    // Assume monthly rate is 25 times daily rate (5 days discount per month)
                    $months = floor($days / 30);
                    $remainingDays = $days % 30;
                    $monthlyRate = $car->daily_rate * 25;
                    $packagePrice = ($months * $monthlyRate) + ($remainingDays * $car->daily_rate);
                    $savings = $basePrice - $packagePrice;
                }
                break;
        }

        return [
            'package_type' => $packageType,
            'base_price' => $basePrice,
            'package_price' => $packagePrice,
            'savings' => $savings,
            'savings_percentage' => $basePrice > 0 ? ($savings / $basePrice) * 100 : 0
        ];
    }
}