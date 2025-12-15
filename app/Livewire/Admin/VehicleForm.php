<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VehicleForm extends Component
{
    use WithFileUploads;

    public ?Car $vehicle = null;
    public bool $isEditing = false;

    // Vehicle properties
    public string $license_plate = '';
    public string $brand = '';
    public string $model = '';
    public ?int $year = null;
    public string $color = '';
    public string $stnk_number = '';
    public string $stnk_expiry = '';
    public string $last_oil_change = '';
    public ?int $oil_change_interval_km = 5000;
    public ?int $current_odometer = 0;
    public ?float $daily_rate = 0;
    public ?float $weekly_rate = 0;
    public ?float $driver_fee_per_day = 0;
    public string $status = Car::STATUS_AVAILABLE;

    // Photo uploads
    public $photo_front;
    public $photo_side;
    public $photo_back;

    // Existing photos (for editing)
    public ?string $existing_photo_front = null;
    public ?string $existing_photo_side = null;
    public ?string $existing_photo_back = null;

    // Photo removal flags
    public bool $remove_photo_front = false;
    public bool $remove_photo_side = false;
    public bool $remove_photo_back = false;

    protected function rules()
    {
        $rules = [
            'license_plate' => [
                'required',
                'string',
                'max:20',
                $this->isEditing 
                    ? Rule::unique('cars')->ignore($this->vehicle->id)
                    : 'unique:cars'
            ],
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
            'status' => ['required', Rule::in([
                Car::STATUS_AVAILABLE, 
                Car::STATUS_MAINTENANCE, 
                Car::STATUS_INACTIVE,
                ...$this->isEditing ? [Car::STATUS_RENTED] : []
            ])],
            'photo_front' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_side' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'photo_back' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];

        return $rules;
    }

    protected $messages = [
        'license_plate.unique' => 'This license plate is already registered.',
        'stnk_expiry.after' => 'STNK expiry date must be in the future.',
        'last_oil_change.before_or_equal' => 'Last oil change date cannot be in the future.',
        'photo_front.image' => 'Front photo must be an image file.',
        'photo_side.image' => 'Side photo must be an image file.',
        'photo_back.image' => 'Back photo must be an image file.',
        '*.max' => 'The file size must not exceed 2MB.',
    ];

    public function mount(?Car $vehicle = null)
    {
        // Initialize all required string properties to avoid null assignment errors
        $this->license_plate = '';
        $this->brand = '';
        $this->model = '';
        $this->color = '';
        $this->stnk_number = '';
        $this->stnk_expiry = '';
        $this->last_oil_change = '';
        
        // Initialize numeric properties
        $this->year = (int) date('Y');
        $this->current_odometer = 0;
        $this->oil_change_interval_km = 5000;
        $this->daily_rate = 0;
        $this->weekly_rate = 0;
        $this->driver_fee_per_day = 0;
        
        if ($vehicle) {
            $this->vehicle = $vehicle;
            $this->isEditing = true;
            $this->fillFromVehicle();
        }
    }

    private function fillFromVehicle()
    {
        $this->license_plate = $this->vehicle->license_plate ?? '';
        $this->brand = $this->vehicle->brand ?? '';
        $this->model = $this->vehicle->model ?? '';
        $this->year = (int) ($this->vehicle->year ?? date('Y'));
        $this->color = $this->vehicle->color ?? '';
        $this->stnk_number = $this->vehicle->stnk_number ?? '';
        $this->stnk_expiry = $this->vehicle->stnk_expiry?->format('Y-m-d') ?? '';
        $this->last_oil_change = $this->vehicle->last_oil_change?->format('Y-m-d') ?? '';
        $this->oil_change_interval_km = (int) ($this->vehicle->oil_change_interval_km ?? 5000);
        $this->current_odometer = (int) ($this->vehicle->current_odometer ?? 0);
        $this->daily_rate = (float) ($this->vehicle->daily_rate ?? 0);
        $this->weekly_rate = (float) ($this->vehicle->weekly_rate ?? 0);
        $this->driver_fee_per_day = (float) ($this->vehicle->driver_fee_per_day ?? 0);
        $this->status = $this->vehicle->status ?? Car::STATUS_AVAILABLE;

        // Store existing photos
        $this->existing_photo_front = $this->vehicle->photo_front;
        $this->existing_photo_side = $this->vehicle->photo_side;
        $this->existing_photo_back = $this->vehicle->photo_back;
    }

    public function removePhoto($position)
    {
        $property = "remove_photo_{$position}";
        $this->$property = true;
        
        // Clear the uploaded file if any
        $photoProperty = "photo_{$position}";
        $this->$photoProperty = null;
    }

    public function restorePhoto($position)
    {
        $property = "remove_photo_{$position}";
        $this->$property = false;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'license_plate' => $this->license_plate,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'color' => $this->color,
            'stnk_number' => $this->stnk_number,
            'stnk_expiry' => $this->stnk_expiry,
            'last_oil_change' => $this->last_oil_change ?: null,
            'oil_change_interval_km' => $this->oil_change_interval_km,
            'current_odometer' => $this->current_odometer,
            'daily_rate' => $this->daily_rate,
            'weekly_rate' => $this->weekly_rate,
            'driver_fee_per_day' => $this->driver_fee_per_day,
            'status' => $this->status,
        ];

        // Handle photo uploads and removals
        $photoFields = ['photo_front', 'photo_side', 'photo_back'];
        foreach ($photoFields as $field) {
            $removeProperty = "remove_{$field}";
            $existingProperty = "existing_{$field}";
            
            if ($this->$removeProperty && $this->$existingProperty) {
                // Remove existing photo
                Storage::disk('public')->delete($this->$existingProperty);
                $data[$field] = null;
            } elseif ($this->$field) {
                // Upload new photo
                if ($this->$existingProperty) {
                    Storage::disk('public')->delete($this->$existingProperty);
                }
                $data[$field] = $this->storeVehiclePhoto($this->$field, $this->license_plate, str_replace('photo_', '', $field));
            } elseif ($this->isEditing && !$this->$removeProperty) {
                // Keep existing photo
                $data[$field] = $this->$existingProperty;
            }
        }

        if ($this->isEditing) {
            $this->vehicle->update($data);
            session()->flash('success', 'Vehicle updated successfully.');
        } else {
            $vehicle = Car::create($data);
            session()->flash('success', 'Vehicle created successfully.');
            return redirect()->route('admin.vehicles.show', $vehicle);
        }
    }

    private function storeVehiclePhoto($file, string $licensePlate, string $position): string
    {
        // Sanitize license plate for filename
        $sanitizedPlate = preg_replace('/[^A-Za-z0-9\-]/', '_', $licensePlate);
        
        // Generate filename with timestamp to avoid conflicts
        $timestamp = now()->format('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $filename = "vehicles/{$sanitizedPlate}_{$position}_{$timestamp}.{$extension}";
        
        return $file->storeAs('', $filename, 'public');
    }

    public function render()
    {
        return view('livewire.admin.vehicle-form', [
            'vehicle' => $this->vehicle,
            'statusOptions' => [
                Car::STATUS_AVAILABLE => 'Available',
                Car::STATUS_MAINTENANCE => 'Maintenance',
                Car::STATUS_INACTIVE => 'Inactive',
                ...$this->isEditing ? [Car::STATUS_RENTED => 'Rented'] : []
            ],
        ]);
    }
}