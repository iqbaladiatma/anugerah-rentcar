<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;

class InvoiceService
{
    /**
     * Generate invoice data for a booking.
     */
    public function generateInvoiceData(Booking $booking): array
    {
        $settings = Setting::current();
        
        return [
            'invoice_number' => $this->generateInvoiceNumber($booking),
            'invoice_date' => Carbon::now(),
            'company' => [
                'name' => $settings->company_name,
                'address' => $settings->company_address,
                'phone' => $settings->company_phone,
                'logo_url' => $settings->company_logo_url
            ],
            'customer' => [
                'name' => $booking->customer->name,
                'phone' => $booking->customer->phone,
                'email' => $booking->customer->email,
                'address' => $booking->customer->address,
                'nik' => $booking->customer->nik
            ],
            'booking' => [
                'booking_number' => $booking->booking_number,
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date,
                'actual_return_date' => $booking->actual_return_date,
                'duration_days' => $booking->getDurationInDays(),
                'pickup_location' => $booking->pickup_location,
                'return_location' => $booking->return_location,
                'with_driver' => $booking->with_driver,
                'is_out_of_town' => $booking->is_out_of_town
            ],
            'vehicle' => [
                'license_plate' => $booking->car->license_plate,
                'brand' => $booking->car->brand,
                'model' => $booking->car->model,
                'year' => $booking->car->year,
                'color' => $booking->car->color
            ],
            'pricing' => [
                'base_amount' => $booking->base_amount,
                'driver_fee' => $booking->driver_fee,
                'out_of_town_fee' => $booking->out_of_town_fee,
                'member_discount' => $booking->member_discount,
                'late_penalty' => $booking->late_penalty,
                'subtotal' => $booking->base_amount + $booking->driver_fee + $booking->out_of_town_fee,
                'total_amount' => $booking->total_amount,
                'deposit_amount' => $booking->deposit_amount,
                'remaining_amount' => $booking->total_amount - $booking->deposit_amount
            ],
            'payment' => [
                'status' => $booking->payment_status,
                'deposit_paid' => $booking->deposit_amount,
                'amount_due' => $booking->total_amount - $booking->deposit_amount
            ]
        ];
    }

    /**
     * Generate delivery document data.
     */
    public function generateDeliveryDocumentData(Booking $booking): array
    {
        $invoiceData = $this->generateInvoiceData($booking);
        $checkoutInspection = $booking->checkoutInspection();
        
        $deliveryData = $invoiceData;
        $deliveryData['document_type'] = 'delivery';
        $deliveryData['delivery_date'] = Carbon::now();
        
        if ($checkoutInspection) {
            $deliveryData['vehicle_condition'] = [
                'fuel_level' => $checkoutInspection->fuel_level,
                'odometer_reading' => $checkoutInspection->odometer_reading,
                'exterior_condition' => $checkoutInspection->exterior_condition,
                'interior_condition' => $checkoutInspection->interior_condition,
                'photos' => $checkoutInspection->photos,
                'inspector_signature' => $checkoutInspection->inspector_signature,
                'customer_signature' => $checkoutInspection->customer_signature,
                'notes' => $checkoutInspection->notes
            ];
        }

        $deliveryData['terms_and_conditions'] = $this->getDeliveryTermsAndConditions();
        
        return $deliveryData;
    }

    /**
     * Generate final invoice data (after return).
     */
    public function generateFinalInvoiceData(Booking $booking): array
    {
        $invoiceData = $this->generateInvoiceData($booking);
        $checkinInspection = $booking->checkinInspection();
        
        $finalData = $invoiceData;
        $finalData['document_type'] = 'final_invoice';
        $finalData['final_date'] = Carbon::now();
        
        if ($checkinInspection) {
            $finalData['return_condition'] = [
                'fuel_level' => $checkinInspection->fuel_level,
                'odometer_reading' => $checkinInspection->odometer_reading,
                'exterior_condition' => $checkinInspection->exterior_condition,
                'interior_condition' => $checkinInspection->interior_condition,
                'photos' => $checkinInspection->photos,
                'inspector_signature' => $checkinInspection->inspector_signature,
                'customer_signature' => $checkinInspection->customer_signature,
                'notes' => $checkinInspection->notes
            ];
        }

        // Add penalty calculation if applicable
        if ($booking->late_penalty > 0) {
            $penaltyCalculator = new PenaltyCalculatorService();
            $finalData['penalty_details'] = $penaltyCalculator->getPenaltyBreakdown($booking, $booking->actual_return_date);
        }

        return $finalData;
    }

    /**
     * Generate unique invoice number.
     */
    public function generateInvoiceNumber(Booking $booking): string
    {
        $prefix = 'INV';
        $date = Carbon::now()->format('Ymd');
        $bookingId = str_pad($booking->id, 4, '0', STR_PAD_LEFT);
        
        return $prefix . $date . $bookingId;
    }

    /**
     * Generate receipt data for payment.
     */
    public function generateReceiptData(Booking $booking, float $paymentAmount, string $paymentMethod = 'cash'): array
    {
        $settings = Setting::current();
        
        return [
            'receipt_number' => $this->generateReceiptNumber($booking),
            'receipt_date' => Carbon::now(),
            'company' => [
                'name' => $settings->company_name,
                'address' => $settings->company_address,
                'phone' => $settings->company_phone
            ],
            'customer' => [
                'name' => $booking->customer->name,
                'phone' => $booking->customer->phone
            ],
            'booking' => [
                'booking_number' => $booking->booking_number,
                'vehicle' => $booking->car->license_plate . ' - ' . $booking->car->brand . ' ' . $booking->car->model
            ],
            'payment' => [
                'amount' => $paymentAmount,
                'method' => $paymentMethod,
                'total_booking_amount' => $booking->total_amount,
                'previous_payments' => $this->calculatePreviousPayments($booking),
                'remaining_balance' => $booking->total_amount - $this->calculatePreviousPayments($booking) - $paymentAmount
            ]
        ];
    }

    /**
     * Generate receipt number.
     */
    public function generateReceiptNumber(Booking $booking): string
    {
        $prefix = 'RCP';
        $date = Carbon::now()->format('Ymd');
        $sequence = Carbon::today()->format('Ymd') . str_pad($booking->id, 3, '0', STR_PAD_LEFT);
        
        return $prefix . $date . $sequence;
    }

    /**
     * Get itemized breakdown for invoice.
     */
    public function getItemizedBreakdown(Booking $booking): array
    {
        $items = [];
        
        // Base rental
        $items[] = [
            'description' => "Vehicle Rental - {$booking->car->license_plate} ({$booking->car->brand} {$booking->car->model})",
            'period' => $booking->start_date->format('d/m/Y') . ' - ' . $booking->end_date->format('d/m/Y'),
            'quantity' => $booking->getDurationInDays(),
            'unit' => 'days',
            'rate' => $booking->base_amount / $booking->getDurationInDays(),
            'amount' => $booking->base_amount
        ];

        // Driver fee
        if ($booking->with_driver && $booking->driver_fee > 0) {
            $items[] = [
                'description' => 'Driver Service',
                'period' => $booking->start_date->format('d/m/Y') . ' - ' . $booking->end_date->format('d/m/Y'),
                'quantity' => $booking->getDurationInDays(),
                'unit' => 'days',
                'rate' => $booking->driver_fee / $booking->getDurationInDays(),
                'amount' => $booking->driver_fee
            ];
        }

        // Out of town fee
        if ($booking->is_out_of_town && $booking->out_of_town_fee > 0) {
            $items[] = [
                'description' => 'Out of Town Fee',
                'period' => null,
                'quantity' => 1,
                'unit' => 'trip',
                'rate' => $booking->out_of_town_fee,
                'amount' => $booking->out_of_town_fee
            ];
        }

        // Member discount
        if ($booking->member_discount > 0) {
            $items[] = [
                'description' => 'Member Discount (' . $booking->customer->getMemberDiscountPercentage() . '%)',
                'period' => null,
                'quantity' => 1,
                'unit' => 'discount',
                'rate' => -$booking->member_discount,
                'amount' => -$booking->member_discount,
                'is_discount' => true
            ];
        }

        // Late penalty
        if ($booking->late_penalty > 0) {
            $penaltyCalculator = new PenaltyCalculatorService();
            $penaltyDetails = $penaltyCalculator->calculateLatePenalty($booking);
            
            $items[] = [
                'description' => 'Late Return Penalty',
                'period' => 'Late by ' . $penaltyDetails['late_hours'] . ' hours',
                'quantity' => $penaltyDetails['penalty_type'] === 'hourly' ? $penaltyDetails['late_hours'] : $penaltyDetails['late_days'],
                'unit' => $penaltyDetails['penalty_type'] === 'hourly' ? 'hours' : 'days',
                'rate' => $penaltyDetails['penalty_type'] === 'hourly' ? $penaltyDetails['hourly_rate'] : $penaltyDetails['daily_rate'],
                'amount' => $booking->late_penalty,
                'is_penalty' => true
            ];
        }

        return $items;
    }

    /**
     * Get delivery terms and conditions.
     */
    public function getDeliveryTermsAndConditions(): array
    {
        return [
            'Vehicle must be returned in the same condition as received',
            'Customer is responsible for any damage or loss during rental period',
            'Late return will incur penalty charges as per company policy',
            'Vehicle must be returned with the same fuel level as at delivery',
            'Customer must have valid driving license throughout rental period',
            'Any traffic violations during rental period are customer\'s responsibility',
            'Deposit will be refunded after vehicle inspection upon return',
            'Company reserves the right to terminate rental for policy violations'
        ];
    }

    /**
     * Calculate previous payments for a booking.
     */
    private function calculatePreviousPayments(Booking $booking): float
    {
        // This would typically query a payments table
        // For now, we'll use the deposit amount as previous payment
        return $booking->payment_status === Booking::PAYMENT_PAID ? $booking->total_amount : $booking->deposit_amount;
    }

    /**
     * Generate invoice summary for multiple bookings.
     */
    public function generateInvoiceSummary(array $bookingIds, Carbon $startDate, Carbon $endDate): array
    {
        $bookings = Booking::whereIn('id', $bookingIds)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['customer', 'car'])
            ->get();

        $summary = [
            'period' => [
                'start' => $startDate,
                'end' => $endDate
            ],
            'total_bookings' => $bookings->count(),
            'total_revenue' => $bookings->sum('total_amount'),
            'total_base_amount' => $bookings->sum('base_amount'),
            'total_driver_fees' => $bookings->sum('driver_fee'),
            'total_penalties' => $bookings->sum('late_penalty'),
            'total_discounts' => $bookings->sum('member_discount'),
            'bookings' => []
        ];

        foreach ($bookings as $booking) {
            $summary['bookings'][] = [
                'booking_number' => $booking->booking_number,
                'customer_name' => $booking->customer->name,
                'vehicle' => $booking->car->license_plate,
                'start_date' => $booking->start_date,
                'end_date' => $booking->end_date,
                'total_amount' => $booking->total_amount,
                'payment_status' => $booking->payment_status
            ];
        }

        return $summary;
    }

    /**
     * Validate invoice data completeness.
     */
    public function validateInvoiceData(Booking $booking): array
    {
        $errors = [];

        if (!$booking->customer) {
            $errors[] = 'Customer information is missing';
        }

        if (!$booking->car) {
            $errors[] = 'Vehicle information is missing';
        }

        if (!$booking->total_amount || $booking->total_amount <= 0) {
            $errors[] = 'Invalid total amount';
        }

        if (!$booking->start_date || !$booking->end_date) {
            $errors[] = 'Booking dates are incomplete';
        }

        $settings = Setting::current();
        if (!$settings->company_name) {
            $errors[] = 'Company information is incomplete';
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }
}