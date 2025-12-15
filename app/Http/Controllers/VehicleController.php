<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
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
            'photo_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_side' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => ['required', Rule::in([Car::STATUS_AVAILABLE, Car::STATUS_MAINTENANCE, Car::STATUS_INACTIVE])],
        ]);

        // Handle photo uploads
        $photoFields = ['photo_front', 'photo_side', 'photo_back'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $this->storeVehiclePhoto($request->file($field), $validated['license_plate'], $field);
            }
        }

        $car = Car::create($validated);

        return redirect()->route('admin.vehicles.show', $car)
            ->with('success', 'Vehicle created successfully.');
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
    public function edit(Car $car): View
    {
        return view('admin.vehicles.edit', compact('car'));
    }

    /**
     * Update the specified vehicle in storage.
     */
    public function update(Request $request, Car $car): RedirectResponse
    {
        $validated = $request->validate([
            'license_plate' => ['required', 'string', 'max:20', Rule::unique('cars')->ignore($car->id)],
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
            'photo_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_side' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => ['required', Rule::in([Car::STATUS_AVAILABLE, Car::STATUS_RENTED, Car::STATUS_MAINTENANCE, Car::STATUS_INACTIVE])],
        ]);

        // Handle photo uploads
        $photoFields = ['photo_front', 'photo_side', 'photo_back'];
        foreach ($photoFields as $field) {
            if ($request->hasFile($field)) {
                // Delete old photo if exists
                if ($car->$field) {
                    Storage::disk('public')->delete($car->$field);
                }
                $validated[$field] = $this->storeVehiclePhoto($request->file($field), $validated['license_plate'], $field);
            }
        }

        $car->update($validated);

        return redirect()->route('admin.vehicles.show', $car)
            ->with('success', 'Vehicle updated successfully.');
    }

    /**
     * Remove the specified vehicle from storage.
     */
    public function destroy(Car $car): RedirectResponse
    {
        // Check if car has active bookings
        if ($car->bookings()->whereIn('booking_status', ['confirmed', 'active'])->exists()) {
            return redirect()->route('admin.vehicles.index')
                ->with('error', 'Cannot delete vehicle with active bookings.');
        }

        // Delete photos
        $photoFields = ['photo_front', 'photo_side', 'photo_back'];
        foreach ($photoFields as $field) {
            if ($car->$field) {
                Storage::disk('public')->delete($car->$field);
            }
        }

        $car->delete();

        return redirect()->route('admin.vehicles.index')
            ->with('success', 'Vehicle deleted successfully.');
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

        $message = "Vehicle status updated to " . ucfirst($validated['status']);
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
     * Store vehicle photo with proper naming and validation.
     */
    private function storeVehiclePhoto($file, string $licensePlate, string $position): string
    {
        // Sanitize license plate for filename
        $sanitizedPlate = preg_replace('/[^A-Za-z0-9\-]/', '_', $licensePlate);
        
        // Generate filename with timestamp to avoid conflicts
        $timestamp = now()->format('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $filename = "vehicles/{$sanitizedPlate}_{$position}_{$timestamp}.{$extension}";
        
        return $file->storeAs('public', $filename);
    }
}