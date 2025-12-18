<?php

namespace App\Livewire\Admin;

use App\Models\Customer;
use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CustomerForm extends Component
{
    use WithFileUploads;

    public ?Customer $customer = null;
    public bool $isEditing = false;

    // Customer properties
    public string $name = '';
    public string $phone = '';
    public string $email = '';
    public string $nik = '';
    public string $address = '';
    public bool $is_member = false;
    public ?float $member_discount = null;
    public bool $is_blacklisted = false;
    public string $blacklist_reason = '';

    // Document uploads
    public $ktp_photo;
    public $sim_photo;
    public $kk_photo;

    // Existing documents (for editing)
    public ?string $existing_ktp_photo = null;
    public ?string $existing_sim_photo = null;
    public ?string $existing_kk_photo = null;

    // Document removal flags
    public bool $remove_ktp_photo = false;
    public bool $remove_sim_photo = false;
    public bool $remove_kk_photo = false;

    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'string',
                'max:20',
                $this->isEditing 
                    ? Rule::unique('customers')->ignore($this->customer->id)
                    : 'unique:customers'
            ],
            'email' => [
                'nullable',
                'email',
                'max:255',
                $this->isEditing 
                    ? Rule::unique('customers')->ignore($this->customer->id)
                    : 'unique:customers'
            ],
            'nik' => [
                'required',
                'string',
                'size:16',
                $this->isEditing 
                    ? Rule::unique('customers')->ignore($this->customer->id)
                    : 'unique:customers'
            ],
            'address' => 'required|string|max:500',
            'is_member' => 'boolean',
            'member_discount' => 'nullable|numeric|min:0|max:100',
            'is_blacklisted' => 'boolean',
            'blacklist_reason' => 'required_if:is_blacklisted,true|nullable|string|max:500',
        ];

        // Document validation rules
        if (!$this->isEditing || $this->ktp_photo) {
            $rules['ktp_photo'] = $this->isEditing && $this->existing_ktp_photo && !$this->remove_ktp_photo 
                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                : 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        if (!$this->isEditing || $this->sim_photo) {
            $rules['sim_photo'] = $this->isEditing && $this->existing_sim_photo && !$this->remove_sim_photo
                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                : 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        if (!$this->isEditing || $this->kk_photo) {
            $rules['kk_photo'] = $this->isEditing && $this->existing_kk_photo && !$this->remove_kk_photo
                ? 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                : 'required|image|mimes:jpeg,png,jpg|max:2048';
        }

        return $rules;
    }

    protected $messages = [
        'phone.unique' => 'This phone number is already registered.',
        'email.unique' => 'This email address is already registered.',
        'nik.unique' => 'This NIK is already registered.',
        'nik.size' => 'NIK must be exactly 16 digits.',
        'ktp_photo.required' => 'KTP photo is required.',
        'sim_photo.required' => 'SIM photo is required.',
        'kk_photo.required' => 'Foto Kartu Keluarga wajib diunggah.',
        'ktp_photo.image' => 'KTP photo must be an image file.',
        'sim_photo.image' => 'SIM photo must be an image file.',
        'kk_photo.image' => 'Foto Kartu Keluarga must be an image file.',
        'blacklist_reason.required_if' => 'Blacklist reason is required when blacklisting a customer.',
        '*.max' => 'The file size must not exceed 2MB.',
    ];

    public function mount(?Customer $customer = null)
    {
        if ($customer && $customer->exists) {
            $this->customer = $customer;
            $this->isEditing = true;
            $this->fillFromCustomer();
        } else {
            $this->customer = null;
            $this->isEditing = false;
            // Set default member discount from system settings
            $this->member_discount = Setting::current()->getMemberDiscountPercentage();
        }
    }

    private function fillFromCustomer()
    {
        $this->name = $this->customer->name ?? '';
        $this->phone = $this->customer->phone ?? '';
        $this->email = $this->customer->email ?? '';
        $this->nik = $this->customer->nik ?? '';
        $this->address = $this->customer->address ?? '';
        $this->is_member = $this->customer->is_member ?? false;
        $this->member_discount = $this->customer->member_discount;
        $this->is_blacklisted = $this->customer->is_blacklisted ?? false;
        $this->blacklist_reason = $this->customer->blacklist_reason ?? '';

        // Store existing documents
        $this->existing_ktp_photo = $this->customer->ktp_photo;
        $this->existing_sim_photo = $this->customer->sim_photo;
        $this->existing_kk_photo = $this->customer->kk_photo;
    }

    public function updatedIsMember()
    {
        if (!$this->is_member) {
            $this->member_discount = null;
        } elseif ($this->member_discount === null) {
            $this->member_discount = Setting::current()->getMemberDiscountPercentage();
        }
    }

    public function updatedIsBlacklisted()
    {
        if (!$this->is_blacklisted) {
            $this->blacklist_reason = '';
        }
    }

    public function removeDocument($documentType)
    {
        $property = "remove_{$documentType}_photo";
        $this->$property = true;
        
        // Clear the uploaded file if any
        $photoProperty = "{$documentType}_photo";
        $this->$photoProperty = null;
    }

    public function restoreDocument($documentType)
    {
        $property = "remove_{$documentType}_photo";
        $this->$property = false;
    }

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email ?: null,
            'nik' => $this->nik,
            'address' => $this->address,
            'is_member' => $this->is_member,
            'member_discount' => $this->is_member ? $this->member_discount : null,
            'is_blacklisted' => $this->is_blacklisted,
            'blacklist_reason' => $this->is_blacklisted ? $this->blacklist_reason : null,
        ];

        // Handle document uploads and removals
        $documentFields = ['ktp_photo', 'sim_photo', 'kk_photo'];
        foreach ($documentFields as $field) {
            $removeProperty = "remove_{$field}";
            $existingProperty = "existing_{$field}";
            
            if ($this->$removeProperty && $this->$existingProperty) {
                // Remove existing document
                Storage::disk('public')->delete($this->$existingProperty);
                $data[$field] = null;
            } elseif ($this->$field) {
                // Upload new document
                if ($this->$existingProperty) {
                    Storage::disk('public')->delete($this->$existingProperty);
                }
                $documentType = str_replace('_photo', '', $field);
                $data[$field] = $this->storeCustomerDocument($this->$field, $this->nik, $documentType);
            } elseif ($this->isEditing && !$this->$removeProperty) {
                // Keep existing document
                $data[$field] = $this->$existingProperty;
            }
        }

        if ($this->isEditing) {
            $this->customer->update($data);
            session()->flash('success', 'Customer updated successfully.');
        } else {
            $customer = Customer::create($data);
            session()->flash('success', 'Customer created successfully.');
            return redirect()->route('admin.customers.show', $customer->id);
        }
    }

    private function storeCustomerDocument($file, string $nik, string $documentType): string
    {
        // Sanitize NIK for filename
        $sanitizedNik = preg_replace('/[^A-Za-z0-9]/', '_', $nik);
        
        // Generate filename with timestamp to avoid conflicts
        $timestamp = now()->format('YmdHis');
        $extension = $file->getClientOriginalExtension();
        $filename = "customers/{$sanitizedNik}_{$documentType}_{$timestamp}.{$extension}";
        
        return $file->storeAs('', $filename, 'public');
    }

    public function render()
    {
        return view('livewire.admin.customer-form', [
            'systemDefaultDiscount' => Setting::current()->getMemberDiscountPercentage(),
        ]);
    }
}