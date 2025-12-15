<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\CarInspection;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CheckinService
{
    protected InvoiceService $invoiceService;
    protected PenaltyCalculatorService $penaltyCalculator;

    public function __construct(InvoiceService $invoiceService, PenaltyCalculatorService $penaltyCalculator)
    {
        $this->invoiceService = $invoiceService;
        $this->penaltyCalculator = $penaltyCalculator;
    }

    /**
     * Process vehicle check-in for a booking.
     */
    public function processCheckin(Booking $booking, array $inspectionData): array
    {
        DB::beginTransaction();

        try {
            // Validate booking can be checked in
            $this->validateCheckin($booking);

            // Set actual return date if not provided
            if (empty($inspectionData['actual_return_date'])) {
                $inspectionData['actual_return_date'] = Carbon::now();
            }

            // Create checkin inspection record
            $inspection = $this->createCheckinInspection($booking, $inspectionData);

            // Update booking with actual return date
            $booking->update(['actual_return_date' => $inspectionData['actual_return_date']]);

            // Calculate and update late penalty if applicable
            $penaltyCalculation = $this->penaltyCalculator->calculateLatePenalty($booking, $inspectionData['actual_return_date']);
            if ($penaltyCalculation['penalty_amount'] > 0) {
                $booking->update(['late_penalty' => $penaltyCalculation['penalty_amount']]);
                $booking->updatePricing();
            }

            // Complete the booking
            $booking->complete();

            // Update vehicle status and odometer
            $this->updateVehicleAfterReturn($booking, $inspectionData);

            // Generate final invoice
            $finalInvoice = $this->invoiceService->generateFinalInvoiceData($booking);

            DB::commit();

            return [
                'success' => true,
                'inspection' => $inspection,
                'penalty_calculation' => $penaltyCalculation,
                'final_invoice' => $finalInvoice,
                'message' => 'Vehicle check-in completed successfully'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Validate that booking can be checked in.
     */
    public function validateCheckin(Booking $booking): void
    {
        if ($booking->booking_status !== Booking::STATUS_ACTIVE) {
            throw new \InvalidArgumentException('Only active bookings can be checked in');
        }

        if ($booking->checkinInspection()) {
            throw new \InvalidArgumentException('Vehicle has already been checked in');
        }

        if (!$booking->checkoutInspection()) {
            throw new \InvalidArgumentException('Vehicle must be checked out before check-in');
        }
    }

    /**
     * Create checkin inspection record.
     */
    public function createCheckinInspection(Booking $booking, array $data): CarInspection
    {
        $inspectionData = [
            'booking_id' => $booking->id,
            'inspection_type' => CarInspection::TYPE_CHECKIN,
            'fuel_level' => $data['fuel_level'] ?? CarInspection::FUEL_FULL,
            'odometer_reading' => $data['odometer_reading'] ?? $booking->car->current_odometer,
            'exterior_condition' => $data['exterior_condition'] ?? [],
            'interior_condition' => $data['interior_condition'] ?? [],
            'photos' => [],
            'notes' => $data['notes'] ?? null,
        ];

        // Handle photo uploads
        if (!empty($data['photos'])) {
            $inspectionData['photos'] = $this->storeInspectionPhotos($data['photos'], $booking, 'checkin');
        }

        // Handle digital signatures
        if (!empty($data['inspector_signature'])) {
            $inspectionData['inspector_signature'] = $this->storeSignature(
                $data['inspector_signature'], 
                $booking, 
                'inspector_checkin'
            );
        }

        if (!empty($data['customer_signature'])) {
            $inspectionData['customer_signature'] = $this->storeSignature(
                $data['customer_signature'], 
                $booking, 
                'customer_checkin'
            );
        }

        return CarInspection::create($inspectionData);
    }

    /**
     * Update vehicle information after return.
     */
    public function updateVehicleAfterReturn(Booking $booking, array $inspectionData): void
    {
        $updateData = [];

        // Update odometer if provided
        if (!empty($inspectionData['odometer_reading'])) {
            $updateData['current_odometer'] = $inspectionData['odometer_reading'];
        }

        // Mark vehicle as available (done by booking->complete())
        $updateData['status'] = Car::STATUS_AVAILABLE;

        if (!empty($updateData)) {
            $booking->car->update($updateData);
        }
    }

    /**
     * Store inspection photos.
     */
    public function storeInspectionPhotos(array $photos, Booking $booking, string $type): array
    {
        $storedPhotos = [];
        
        foreach ($photos as $index => $photo) {
            if ($photo) {
                $filename = $this->generateInspectionPhotoFilename($booking, $type, $index);
                $path = $photo->storeAs('inspections', $filename, 'public');
                $storedPhotos[] = $path;
            }
        }

        return $storedPhotos;
    }

    /**
     * Store digital signature.
     */
    public function storeSignature($signatureData, Booking $booking, string $type): string
    {
        // Handle base64 signature data
        if (is_string($signatureData) && str_starts_with($signatureData, 'data:image/')) {
            $filename = $this->generateSignatureFilename($booking, $type);
            $path = "signatures/{$filename}";
            
            // Extract base64 data
            $imageData = substr($signatureData, strpos($signatureData, ',') + 1);
            $decodedImage = base64_decode($imageData);
            
            Storage::disk('public')->put($path, $decodedImage);
            
            return $path;
        }

        // Handle uploaded file
        if (is_object($signatureData) && method_exists($signatureData, 'store')) {
            $filename = $this->generateSignatureFilename($booking, $type);
            return $signatureData->storeAs('signatures', $filename, 'public');
        }

        throw new \InvalidArgumentException('Invalid signature data format');
    }

    /**
     * Generate filename for inspection photos.
     */
    private function generateInspectionPhotoFilename(Booking $booking, string $type, int $index): string
    {
        $timestamp = Carbon::now()->format('YmdHis');
        $sanitizedBooking = preg_replace('/[^A-Za-z0-9\-]/', '_', $booking->booking_number);
        
        return "{$sanitizedBooking}_{$type}_photo_{$index}_{$timestamp}.jpg";
    }

    /**
     * Generate filename for signatures.
     */
    private function generateSignatureFilename(Booking $booking, string $type): string
    {
        $timestamp = Carbon::now()->format('YmdHis');
        $sanitizedBooking = preg_replace('/[^A-Za-z0-9\-]/', '_', $booking->booking_number);
        
        return "{$sanitizedBooking}_{$type}_signature_{$timestamp}.png";
    }

    /**
     * Get checkin preparation data.
     */
    public function getCheckinPreparationData(Booking $booking): array
    {
        $checkoutInspection = $booking->checkoutInspection();
        
        return [
            'booking' => $booking->load(['customer', 'car', 'driver']),
            'checkout_condition' => $checkoutInspection ? [
                'fuel_level' => $checkoutInspection->fuel_level,
                'odometer_reading' => $checkoutInspection->odometer_reading,
                'exterior_condition' => $checkoutInspection->exterior_condition,
                'interior_condition' => $checkoutInspection->interior_condition,
                'photos' => $checkoutInspection->photos,
            ] : null,
            'expected_return_date' => $booking->end_date,
            'current_time' => Carbon::now(),
            'is_overdue' => $booking->isOverdue(),
            'penalty_estimate' => $this->penaltyCalculator->estimateCurrentPenalty($booking),
            'inspection_checklist' => $this->getInspectionChecklist(),
        ];
    }

    /**
     * Get inspection checklist items.
     */
    public function getInspectionChecklist(): array
    {
        return [
            'exterior' => [
                'front_bumper' => 'Front Bumper',
                'rear_bumper' => 'Rear Bumper',
                'left_side' => 'Left Side',
                'right_side' => 'Right Side',
                'roof' => 'Roof',
                'windshield' => 'Windshield',
                'headlights' => 'Headlights',
                'taillights' => 'Taillights',
                'mirrors' => 'Side Mirrors',
                'tires' => 'Tires and Wheels',
            ],
            'interior' => [
                'dashboard' => 'Dashboard',
                'seats' => 'Seats',
                'steering_wheel' => 'Steering Wheel',
                'gear_shift' => 'Gear Shift',
                'air_conditioning' => 'Air Conditioning',
                'radio_system' => 'Radio/Entertainment System',
                'floor_mats' => 'Floor Mats',
                'trunk' => 'Trunk/Storage',
            ],
            'mechanical' => [
                'engine' => 'Engine Condition',
                'brakes' => 'Brake System',
                'lights' => 'All Lights Working',
                'horn' => 'Horn',
                'wipers' => 'Windshield Wipers',
                'battery' => 'Battery',
            ]
        ];
    }

    /**
     * Compare checkout and checkin conditions.
     */
    public function compareInspections(Booking $booking): array
    {
        $checkoutInspection = $booking->checkoutInspection();
        $checkinInspection = $booking->checkinInspection();

        if (!$checkoutInspection || !$checkinInspection) {
            return [
                'error' => 'Both checkout and checkin inspections are required for comparison'
            ];
        }

        return $checkinInspection->compareWith($checkoutInspection);
    }

    /**
     * Validate inspection data.
     */
    public function validateInspectionData(array $data): array
    {
        $errors = [];

        // Validate required fields
        if (empty($data['fuel_level'])) {
            $errors[] = 'Fuel level is required';
        }

        if (empty($data['odometer_reading']) || !is_numeric($data['odometer_reading'])) {
            $errors[] = 'Valid odometer reading is required';
        }

        // Validate fuel level
        $validFuelLevels = [
            CarInspection::FUEL_EMPTY,
            CarInspection::FUEL_QUARTER,
            CarInspection::FUEL_HALF,
            CarInspection::FUEL_THREE_QUARTER,
            CarInspection::FUEL_FULL,
        ];

        if (!empty($data['fuel_level']) && !in_array($data['fuel_level'], $validFuelLevels)) {
            $errors[] = 'Invalid fuel level selected';
        }

        // Validate odometer reading is reasonable
        if (!empty($data['odometer_reading']) && $data['odometer_reading'] < 0) {
            $errors[] = 'Odometer reading cannot be negative';
        }

        return [
            'is_valid' => empty($errors),
            'errors' => $errors
        ];
    }

    /**
     * Get checkin summary for confirmation.
     */
    public function getCheckinSummary(Booking $booking, array $inspectionData): array
    {
        $validation = $this->validateInspectionData($inspectionData);
        $penaltyCalculation = $this->penaltyCalculator->calculateLatePenalty(
            $booking, 
            $inspectionData['actual_return_date'] ?? Carbon::now()
        );
        
        return [
            'booking_details' => [
                'booking_number' => $booking->booking_number,
                'customer_name' => $booking->customer->name,
                'vehicle' => $booking->car->license_plate . ' - ' . $booking->car->brand . ' ' . $booking->car->model,
                'scheduled_return' => $booking->end_date->format('d/m/Y H:i'),
                'actual_return' => ($inspectionData['actual_return_date'] ?? Carbon::now())->format('d/m/Y H:i'),
                'duration' => $booking->getDurationInDays() . ' days',
            ],
            'vehicle_condition' => [
                'fuel_level' => $inspectionData['fuel_level'] ?? 'Not specified',
                'odometer_reading' => $inspectionData['odometer_reading'] ?? 'Not specified',
                'exterior_issues' => count($inspectionData['exterior_condition'] ?? []),
                'interior_issues' => count($inspectionData['interior_condition'] ?? []),
                'photos_count' => count($inspectionData['photos'] ?? []),
            ],
            'penalty_calculation' => $penaltyCalculation,
            'signatures' => [
                'inspector_signed' => !empty($inspectionData['inspector_signature']),
                'customer_signed' => !empty($inspectionData['customer_signature']),
            ],
            'validation' => $validation,
            'ready_for_checkin' => $validation['is_valid'] && 
                                  !empty($inspectionData['inspector_signature']) && 
                                  !empty($inspectionData['customer_signature']),
            'final_amount' => $booking->total_amount + $penaltyCalculation['penalty_amount'],
        ];
    }

    /**
     * Process bulk checkin for multiple bookings.
     */
    public function processBulkCheckin(array $bookingIds, array $commonInspectionData = []): array
    {
        $results = [];
        $successCount = 0;
        $errorCount = 0;

        foreach ($bookingIds as $bookingId) {
            try {
                $booking = Booking::findOrFail($bookingId);
                $result = $this->processCheckin($booking, $commonInspectionData);
                $results[] = [
                    'booking_id' => $bookingId,
                    'booking_number' => $booking->booking_number,
                    'success' => true,
                    'result' => $result
                ];
                $successCount++;
            } catch (\Exception $e) {
                $results[] = [
                    'booking_id' => $bookingId,
                    'success' => false,
                    'error' => $e->getMessage()
                ];
                $errorCount++;
            }
        }

        return [
            'total_processed' => count($bookingIds),
            'success_count' => $successCount,
            'error_count' => $errorCount,
            'results' => $results
        ];
    }

    /**
     * Get overdue bookings that need immediate checkin.
     */
    public function getOverdueBookings(): array
    {
        $overdueBookings = Booking::overdue()
            ->with(['customer', 'car'])
            ->get();

        return $overdueBookings->map(function ($booking) {
            $penaltyEstimate = $this->penaltyCalculator->estimateCurrentPenalty($booking);
            
            return [
                'booking' => $booking,
                'overdue_hours' => $booking->end_date->diffInHours(Carbon::now()),
                'penalty_estimate' => $penaltyEstimate,
                'customer_contact' => [
                    'name' => $booking->customer->name,
                    'phone' => $booking->customer->phone,
                    'email' => $booking->customer->email,
                ]
            ];
        })->toArray();
    }

    /**
     * Generate checkin report for a date range.
     */
    public function generateCheckinReport(Carbon $startDate, Carbon $endDate): array
    {
        $checkins = Booking::whereNotNull('actual_return_date')
            ->whereBetween('actual_return_date', [$startDate, $endDate])
            ->with(['customer', 'car', 'carInspections'])
            ->get();

        $totalCheckins = $checkins->count();
        $onTimeReturns = $checkins->where('late_penalty', 0)->count();
        $lateReturns = $checkins->where('late_penalty', '>', 0)->count();
        $totalPenalties = $checkins->sum('late_penalty');

        return [
            'period' => [
                'start' => $startDate,
                'end' => $endDate
            ],
            'summary' => [
                'total_checkins' => $totalCheckins,
                'on_time_returns' => $onTimeReturns,
                'late_returns' => $lateReturns,
                'on_time_percentage' => $totalCheckins > 0 ? ($onTimeReturns / $totalCheckins) * 100 : 0,
                'total_penalties' => $totalPenalties,
                'average_penalty' => $lateReturns > 0 ? $totalPenalties / $lateReturns : 0,
            ],
            'checkins' => $checkins->map(function ($booking) {
                return [
                    'booking_number' => $booking->booking_number,
                    'customer_name' => $booking->customer->name,
                    'vehicle' => $booking->car->license_plate,
                    'scheduled_return' => $booking->end_date,
                    'actual_return' => $booking->actual_return_date,
                    'late_penalty' => $booking->late_penalty,
                    'has_damage' => $booking->checkinInspection()?->hasDamage() ?? false,
                ];
            })->toArray()
        ];
    }
}