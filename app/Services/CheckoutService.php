<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\CarInspection;
use App\Models\Car;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    protected InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    /**
     * Process vehicle checkout for a booking.
     */
    public function processCheckout(Booking $booking, array $inspectionData): array
    {
        DB::beginTransaction();

        try {
            // Validate booking can be checked out
            $this->validateCheckout($booking);

            // Create checkout inspection record
            $inspection = $this->createCheckoutInspection($booking, $inspectionData);

            // Update booking status to active
            $booking->activate();

            // Update vehicle status to rented
            $booking->car->markAsRented();

            // Generate delivery document
            $deliveryDocument = $this->invoiceService->generateDeliveryDocumentData($booking);

            DB::commit();

            return [
                'success' => true,
                'inspection' => $inspection,
                'delivery_document' => $deliveryDocument,
                'message' => 'Vehicle checkout completed successfully'
            ];

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Validate that booking can be checked out.
     */
    public function validateCheckout(Booking $booking): void
    {
        if ($booking->booking_status !== Booking::STATUS_CONFIRMED) {
            throw new \InvalidArgumentException('Only confirmed bookings can be checked out');
        }

        if ($booking->checkoutInspection()) {
            throw new \InvalidArgumentException('Vehicle has already been checked out');
        }

        if ($booking->car->status !== Car::STATUS_AVAILABLE) {
            throw new \InvalidArgumentException('Vehicle is not available for checkout');
        }

        // Check if checkout is within reasonable time frame (e.g., not more than 1 day early)
        $earliestCheckout = $booking->start_date->copy()->subDay();
        if (Carbon::now() < $earliestCheckout) {
            throw new \InvalidArgumentException('Checkout is too early for this booking');
        }
    }

    /**
     * Create checkout inspection record.
     */
    public function createCheckoutInspection(Booking $booking, array $data): CarInspection
    {
        $inspectionData = [
            'booking_id' => $booking->id,
            'inspection_type' => CarInspection::TYPE_CHECKOUT,
            'fuel_level' => $data['fuel_level'] ?? CarInspection::FUEL_FULL,
            'odometer_reading' => $data['odometer_reading'] ?? $booking->car->current_odometer,
            'exterior_condition' => $data['exterior_condition'] ?? [],
            'interior_condition' => $data['interior_condition'] ?? [],
            'photos' => [],
            'notes' => $data['notes'] ?? null,
        ];

        // Handle photo uploads
        if (!empty($data['photos'])) {
            $inspectionData['photos'] = $this->storeInspectionPhotos($data['photos'], $booking, 'checkout');
        }

        // Handle digital signatures
        if (!empty($data['inspector_signature'])) {
            $inspectionData['inspector_signature'] = $this->storeSignature(
                $data['inspector_signature'], 
                $booking, 
                'inspector_checkout'
            );
        }

        if (!empty($data['customer_signature'])) {
            $inspectionData['customer_signature'] = $this->storeSignature(
                $data['customer_signature'], 
                $booking, 
                'customer_checkout'
            );
        }

        $inspection = CarInspection::create($inspectionData);

        // Update vehicle odometer if provided
        if (!empty($data['odometer_reading'])) {
            $booking->car->update(['current_odometer' => $data['odometer_reading']]);
        }

        return $inspection;
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
     * Get checkout preparation data.
     */
    public function getCheckoutPreparationData(Booking $booking): array
    {
        return [
            'booking' => $booking->load(['customer', 'car', 'driver']),
            'vehicle_current_condition' => [
                'fuel_level' => CarInspection::FUEL_FULL,
                'odometer_reading' => $booking->car->current_odometer,
                'last_inspection' => $this->getLastInspectionForVehicle($booking->car),
            ],
            'required_documents' => [
                'customer_id' => 'Customer ID/KTP',
                'driving_license' => 'Valid Driving License',
                'booking_confirmation' => 'Booking Confirmation',
            ],
            'inspection_checklist' => $this->getInspectionChecklist(),
            'delivery_terms' => $this->invoiceService->getDeliveryTermsAndConditions(),
        ];
    }

    /**
     * Get last inspection for vehicle.
     */
    private function getLastInspectionForVehicle(Car $car): ?CarInspection
    {
        return CarInspection::whereHas('booking', function ($query) use ($car) {
            $query->where('car_id', $car->id);
        })
        ->where('inspection_type', CarInspection::TYPE_CHECKIN)
        ->latest()
        ->first();
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
     * Get checkout summary for confirmation.
     */
    public function getCheckoutSummary(Booking $booking, array $inspectionData): array
    {
        $validation = $this->validateInspectionData($inspectionData);
        
        return [
            'booking_details' => [
                'booking_number' => $booking->booking_number,
                'customer_name' => $booking->customer->name,
                'vehicle' => $booking->car->license_plate . ' - ' . $booking->car->brand . ' ' . $booking->car->model,
                'rental_period' => $booking->start_date->format('d/m/Y H:i') . ' - ' . $booking->end_date->format('d/m/Y H:i'),
                'duration' => $booking->getDurationInDays() . ' days',
            ],
            'vehicle_condition' => [
                'fuel_level' => $inspectionData['fuel_level'] ?? 'Not specified',
                'odometer_reading' => $inspectionData['odometer_reading'] ?? 'Not specified',
                'exterior_issues' => count($inspectionData['exterior_condition'] ?? []),
                'interior_issues' => count($inspectionData['interior_condition'] ?? []),
                'photos_count' => count($inspectionData['photos'] ?? []),
            ],
            'signatures' => [
                'inspector_signed' => !empty($inspectionData['inspector_signature']),
                'customer_signed' => !empty($inspectionData['customer_signature']),
            ],
            'validation' => $validation,
            'ready_for_checkout' => $validation['is_valid'] && 
                                   !empty($inspectionData['inspector_signature']) && 
                                   !empty($inspectionData['customer_signature']),
        ];
    }
}