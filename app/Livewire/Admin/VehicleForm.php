<?php

namespace App\Livewire\Admin;

use App\Models\Car;
use App\Rules\SecureFileUpload;
use App\Rules\EnhancedFileUpload;
use App\Traits\HandlesSecureFileUploads;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class VehicleForm extends Component
{
    use WithFileUploads, HandlesSecureFileUploads;

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
            'photo_front' => ['nullable', EnhancedFileUpload::vehiclePhoto()],
            'photo_side' => ['nullable', EnhancedFileUpload::vehiclePhoto()],
            'photo_back' => ['nullable', EnhancedFileUpload::vehiclePhoto()],
        ];

        return $rules;
    }

    protected $messages = [
        'license_plate.unique' => 'Plat nomor ini sudah terdaftar.',
        'stnk_expiry.after' => 'Tanggal kadaluarsa STNK harus di masa depan.',
        'last_oil_change.before_or_equal' => 'Tanggal ganti oli terakhir tidak boleh di masa depan.',
        'photo_front.image' => 'Foto depan harus berupa file gambar.',
        'photo_side.image' => 'Foto samping harus berupa file gambar.',
        'photo_back.image' => 'Foto belakang harus berupa file gambar.',
        '*.max' => 'Ukuran file tidak boleh melebihi 2MB.',
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
        
        if ($vehicle && $vehicle->exists) {
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
                $this->deleteFileSecurely($this->$existingProperty, 'public');
                $data[$field] = null;
            } elseif ($this->$field) {
                // Upload new photo
                if ($this->$existingProperty) {
                    $this->deleteFileSecurely($this->$existingProperty, 'public');
                }
                $result = $this->uploadVehiclePhoto($this->$field, $this->license_plate, str_replace('photo_', '', $field));
                if ($result['success']) {
                    $data[$field] = $result['path'];
                } else {
                    // Handle upload error
                    foreach ($result['errors'] as $error) {
                        $this->addError($field, $error);
                    }
                    return;
                }
            } elseif ($this->isEditing && !$this->$removeProperty) {
                // Keep existing photo
                $data[$field] = $this->$existingProperty;
            }
        }

        if ($this->isEditing) {
            $this->vehicle->update($data);
            session()->flash('success', 'Kendaraan berhasil diperbarui.');
        } else {
            $vehicle = Car::create($data);
            session()->flash('success', 'Kendaraan berhasil dibuat.');
            return redirect()->route('admin.vehicles.show', $vehicle);
        }
    }

    public function render()
    {
        return view('livewire.admin.vehicle-form', [
            'vehicle' => $this->vehicle,
            'statusOptions' => [
                Car::STATUS_AVAILABLE => 'Tersedia',
                Car::STATUS_MAINTENANCE => 'Perawatan',
                Car::STATUS_INACTIVE => 'Tidak Aktif',
                ...$this->isEditing ? [Car::STATUS_RENTED => 'Disewa'] : []
            ],
        ]);
    }
}