<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Rules\SecureFileUpload;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    protected FileUploadService $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    /**
     * Display a listing of vehicles.
     */
    public function index(): View
    {
        return view('admin.vehicles.index');
    }

    /**
     * Show the form for creating a new vehicle.
     */
    public function create(): View
    {
        return view('admin.vehicles.create');
    }

    /**
     * Store a newly created vehicle in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:20|unique:cars',
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:30',
            'stnk_number' => 'required|string|max:50',
            'stnk_expiry' => 'required|date|after:today',
            'last_oil_change' => 'nullable|date|before_or_equal:today',
            'oil_change_interval_km' => 'nullable|integer|min:1000|max:50000',
            'current_odometer' => 'required|integer|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'required|numeric|min:0',
            'driver_fee_per_day' => 'required|numeric|min:0',
            'photo_front' => ['nullable', SecureFileUpload::vehiclePhoto()],
            'photo_side' => ['nullable', SecureFileUpload::vehiclePhoto()],
            'photo_back' => ['nullable', SecureFileUpload::vehiclePhoto()],
            'status' => ['required', Rule::in([Car::STATUS_AVAILABLE, Car::STATUS_MAINTENANCE, Car::STATUS_INACTIVE])],
        ]);

        // Handle photo uploads
        $photoFields = ['photo_front', 'photo_side', 'photo_back'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $result = $this->fileUploadService->uploadFile(
                    $request->file($field),
                    'vehicles',
                    'public',
                    [
                        'prefix' => $this->sanitizeLicensePlate($validated['license_plate']) . '_' . $field . '_',
                        'max_width' => 1920,
                        'max_height' => 1080,
                        'quality' => 85,
                        'generate_thumbnail' => true
                    ]
                );
                
                if ($result['success']) {
                    $validated[$field] = $result['path'];
                } else {
                    return redirect()->back()
                        ->withErrors([$field => implode(', ', $result['errors'])])
                        ->withInput();
                }
            }
        }

        $car = Car::create($validated);

        return redirect()->route('admin.vehicles.show', $car)
            ->with('success', 'Kendaraan berhasil ditambahkan.');
    }

    /**
     * Display the specified vehicle.
     */
    public function show(Car $vehicle): View
    {
        $vehicle->load(['bookings' => function ($query) {
            $query->latest()->limit(5);
        }, 'maintenances' => function ($query) {
            $query->latest()->limit(5);
        }]);

        return view('admin.vehicles.show', ['car' => $vehicle]);
    }

    /**
     * Show the form for editing the specified vehicle.
     */
    public function edit(Car $vehicle): View
    {
        return view('admin.vehicles.edit', ['car' => $vehicle]);
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, Car $vehicle): RedirectResponse
    {
        $validated = $request->validate([
            'license_plate' => ['required', 'string', 'max:20', Rule::unique('cars')->ignore($vehicle->id)],
            'brand' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'color' => 'required|string|max:30',
            'stnk_number' => 'required|string|max:50',
            'stnk_expiry' => 'required|date|after:today',
            'last_oil_change' => 'nullable|date|before_or_equal:today',
            'oil_change_interval_km' => 'nullable|integer|min:1000|max:50000',
            'current_odometer' => 'required|integer|min:0',
            'daily_rate' => 'required|numeric|min:0',
            'weekly_rate' => 'required|numeric|min:0',
            'driver_fee_per_day' => 'required|numeric|min:0',
            'photo_front' => ['nullable', SecureFileUpload::vehiclePhoto()],
            'photo_side' => ['nullable', SecureFileUpload::vehiclePhoto()],
            'photo_back' => ['nullable', SecureFileUpload::vehiclePhoto()],
            'status' => ['required', Rule::in([Car::STATUS_AVAILABLE, Car::STATUS_RENTED, Car::STATUS_MAINTENANCE, Car::STATUS_INACTIVE])],
        ]);

        // Handle photo uploads
        $photoFields = ['photo_front', 'photo_side', 'photo_back'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old photo if exists
                if ($vehicle->$field) {
                    $this->fileUploadService->deleteFile($vehicle->$field, 'public');
                }
                
                $result = $this->fileUploadService->uploadFile(
                    $request->file($field),
                    'vehicles',
                    'public',
                    [
                        'prefix' => $this->sanitizeLicensePlate($validated['license_plate']) . '_' . $field . '_',
                        'max_width' => 1920,
                        'max_height' => 1080,
                        'quality' => 85,
                        'generate_thumbnail' => true
                    ]
                );
                
                if ($result['success']) {
                    $validated[$field] = $result['path'];
                } else {
                    return redirect()->back()
                        ->withErrors([$field => implode(', ', $result['errors'])])
                        ->withInput();
                }
            }
        }

        $vehicle->update($validated);

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Data kendaraan berhasil diperbarui.');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(Car $vehicle): RedirectResponse
    {
        // Check if car has active bookings
        if ($vehicle->bookings()->whereIn('booking_status', ['confirmed', 'active'])->exists()) {
            return redirect()->route('admin.vehicles.index')
                ->with('error', 'Tidak dapat menghapus kendaraan yang sedang disewa atau dibooking.');
        }

        // Delete photos
        $photoFields = ['photo_front', 'photo_side', 'photo_back'];
        foreach ($photoFields as $field) {
            if ($vehicle->$field) {
                $this->fileUploadService->deleteFile($vehicle->$field, 'public');
            }
        }

        $vehicle->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Kendaraan berhasil dihapus.');
    }

    /**
     * Update vehicle status.
     */
    public function updateStatus(Request $request, Car $car): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in([Car::STATUS_AVAILABLE, Car::STATUS_RENTED, Car::STATUS_MAINTENANCE, Car::STATUS_INACTIVE])],
            'reason' => 'nullable|string|max:255',
        ]);

        $car->updateStatus($validated['status']);

        $message = "Status kendaraan diperbarui menjadi " . ucfirst($validated['status']);
        if (!empty($validated['reason'])) {
            $message .= " - " . $validated['reason'];
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get vehicles needing maintenance.
     */
    public function maintenanceDue(): View
    {
        return view('admin.vehicles.maintenance-due');
    }

    /**
     * Sanitize license plate for filename
     */
    private function sanitizeLicensePlate(string $licensePlate): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '_', $licensePlate);
    }
}