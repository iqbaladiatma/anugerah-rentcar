<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;

class PenaltyCalculatorService
{
    /**
     * Calculate late penalty for a booking based on actual return time.
     */
    public function calculateLatePenalty(Booking $booking, ?Carbon $actualReturnDate = null): array
    {
        $actualReturn = $actualReturnDate ?? $booking->actual_return_date;
        
        if (!$actualReturn || $actualReturn <= $booking->end_date) {
            return [
                'penalty_amount' => 0,
                'late_hours' => 0,
                'late_days' => 0,
                'penalty_type' => 'none',
                'calculation_details' => 'Vehicle returned on time'
            ];
        }

        $lateHours = $booking->end_date->diffInHours($actualReturn);
        $lateDays = ceil($lateHours / 24);
        $settings = Setting::current();

        if ($lateHours <= 24) {
            // Hourly penalty for delays under 24 hours
            $penaltyAmount = $lateHours * $settings->getLatePenaltyRate();
            $penaltyType = 'hourly';
            $calculationDetails = "Late by {$lateHours} hours × " . number_format($settings->getLatePenaltyRate()) . " per hour";
        } else {
            // Daily extension rate for delays over 24 hours
            $penaltyAmount = $lateDays * $booking->car->daily_rate;
            $penaltyType = 'daily_extension';
            $calculationDetails = "Late by {$lateDays} days × " . number_format($booking->car->daily_rate) . " daily rate";
        }

        return [
            'penalty_amount' => $penaltyAmount,
            'late_hours' => $lateHours,
            'late_days' => $lateDays,
            'penalty_type' => $penaltyType,
            'calculation_details' => $calculationDetails,
            'hourly_rate' => $settings->getLatePenaltyRate(),
            'daily_rate' => $booking->car->daily_rate
        ];
    }

    /**
     * Calculate penalty for a specific late duration.
     */
    public function calculatePenaltyForDuration(Booking $booking, int $lateHours): array
    {
        if ($lateHours <= 0) {
            return [
                'penalty_amount' => 0,
                'penalty_type' => 'none',
                'calculation_details' => 'No late penalty'
            ];
        }

        $settings = Setting::current();
        $lateDays = ceil($lateHours / 24);

        if ($lateHours <= 24) {
            // Hourly penalty
            $penaltyAmount = $lateHours * $settings->getLatePenaltyRate();
            $penaltyType = 'hourly';
            $calculationDetails = "{$lateHours} hours × " . number_format($settings->getLatePenaltyRate()) . " per hour";
        } else {
            // Daily extension
            $penaltyAmount = $lateDays * $booking->car->daily_rate;
            $penaltyType = 'daily_extension';
            $calculationDetails = "{$lateDays} days × " . number_format($booking->car->daily_rate) . " daily rate";
        }

        return [
            'penalty_amount' => $penaltyAmount,
            'late_hours' => $lateHours,
            'late_days' => $lateDays,
            'penalty_type' => $penaltyType,
            'calculation_details' => $calculationDetails
        ];
    }

    /**
     * Get penalty rate information.
     */
    public function getPenaltyRates(Booking $booking): array
    {
        $settings = Setting::current();
        
        return [
            'hourly_rate' => $settings->getLatePenaltyRate(),
            'daily_rate' => $booking->car->daily_rate,
            'hourly_threshold' => 24, // Hours after which daily rate applies
            'currency' => 'IDR'
        ];
    }

    /**
     * Calculate penalty tiers for different late durations.
     */
    public function calculatePenaltyTiers(Booking $booking): array
    {
        $tiers = [];
        $durations = [1, 3, 6, 12, 24, 48, 72]; // Hours

        foreach ($durations as $hours) {
            $penalty = $this->calculatePenaltyForDuration($booking, $hours);
            $tiers[] = [
                'duration_hours' => $hours,
                'duration_label' => $this->formatDuration($hours),
                'penalty_amount' => $penalty['penalty_amount'],
                'penalty_type' => $penalty['penalty_type']
            ];
        }

        return $tiers;
    }

    /**
     * Estimate penalty for current overdue booking.
     */
    public function estimateCurrentPenalty(Booking $booking): array
    {
        if ($booking->booking_status !== Booking::STATUS_ACTIVE) {
            return [
                'error' => 'Booking is not active',
                'penalty_amount' => 0
            ];
        }

        if (Carbon::now() <= $booking->end_date) {
            return [
                'penalty_amount' => 0,
                'status' => 'not_overdue',
                'time_remaining' => $booking->end_date->diffForHumans()
            ];
        }

        return $this->calculateLatePenalty($booking, Carbon::now());
    }

    /**
     * Calculate grace period adjustments.
     */
    public function calculateWithGracePeriod(Booking $booking, Carbon $actualReturnDate, int $graceMinutes = 30): array
    {
        $adjustedReturnDate = $actualReturnDate->copy()->subMinutes($graceMinutes);
        
        if ($adjustedReturnDate <= $booking->end_date) {
            return [
                'penalty_amount' => 0,
                'grace_period_applied' => true,
                'grace_minutes' => $graceMinutes,
                'calculation_details' => "Grace period of {$graceMinutes} minutes applied - no penalty"
            ];
        }

        $penalty = $this->calculateLatePenalty($booking, $adjustedReturnDate);
        $penalty['grace_period_applied'] = true;
        $penalty['grace_minutes'] = $graceMinutes;
        
        return $penalty;
    }

    /**
     * Get penalty calculation breakdown for display.
     */
    public function getPenaltyBreakdown(Booking $booking, Carbon $actualReturnDate): array
    {
        $penalty = $this->calculateLatePenalty($booking, $actualReturnDate);
        $settings = Setting::current();

        $breakdown = [
            'booking_details' => [
                'booking_number' => $booking->booking_number,
                'scheduled_return' => $booking->end_date,
                'actual_return' => $actualReturnDate,
                'car' => $booking->car->license_plate
            ],
            'penalty_calculation' => $penalty,
            'rates' => [
                'hourly_penalty_rate' => $settings->getLatePenaltyRate(),
                'daily_extension_rate' => $booking->car->daily_rate
            ]
        ];

        if ($penalty['penalty_amount'] > 0) {
            $breakdown['payment_info'] = [
                'original_total' => $booking->total_amount,
                'penalty_amount' => $penalty['penalty_amount'],
                'new_total' => $booking->total_amount + $penalty['penalty_amount'],
                'deposit_paid' => $booking->deposit_amount,
                'remaining_due' => ($booking->total_amount + $penalty['penalty_amount']) - $booking->deposit_amount
            ];
        }

        return $breakdown;
    }

    /**
     * Check if penalty calculation is accurate for a booking.
     */
    public function validatePenaltyCalculation(Booking $booking): array
    {
        if (!$booking->actual_return_date) {
            return [
                'is_valid' => false,
                'error' => 'No actual return date recorded'
            ];
        }

        $calculatedPenalty = $this->calculateLatePenalty($booking);
        $recordedPenalty = $booking->late_penalty;

        $isValid = abs($calculatedPenalty['penalty_amount'] - $recordedPenalty) < 0.01; // Allow for rounding differences

        return [
            'is_valid' => $isValid,
            'calculated_penalty' => $calculatedPenalty['penalty_amount'],
            'recorded_penalty' => $recordedPenalty,
            'difference' => $calculatedPenalty['penalty_amount'] - $recordedPenalty,
            'calculation_details' => $calculatedPenalty
        ];
    }

    /**
     * Format duration for display.
     */
    private function formatDuration(int $hours): string
    {
        if ($hours < 24) {
            return $hours . ' hour' . ($hours > 1 ? 's' : '');
        } else {
            $days = $hours / 24;
            return $days . ' day' . ($days > 1 ? 's' : '');
        }
    }

    /**
     * Get penalty statistics for reporting.
     */
    public function getPenaltyStatistics(Carbon $startDate, Carbon $endDate): array
    {
        $bookingsWithPenalties = Booking::where('late_penalty', '>', 0)
            ->whereBetween('actual_return_date', [$startDate, $endDate])
            ->get();

        $totalPenalties = $bookingsWithPenalties->sum('late_penalty');
        $averagePenalty = $bookingsWithPenalties->count() > 0 ? $totalPenalties / $bookingsWithPenalties->count() : 0;
        
        $penaltyTypes = $bookingsWithPenalties->map(function ($booking) {
            $penalty = $this->calculateLatePenalty($booking);
            return $penalty['penalty_type'];
        })->countBy();

        return [
            'total_penalties' => $totalPenalties,
            'penalty_count' => $bookingsWithPenalties->count(),
            'average_penalty' => $averagePenalty,
            'penalty_types' => $penaltyTypes->toArray(),
            'date_range' => [
                'start' => $startDate,
                'end' => $endDate
            ]
        ];
    }
}