<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class CompanySettings extends Component
{
    use WithFileUploads;

    public $company_name;
    public $company_address;
    public $company_phone;
    public $company_logo;
    public $current_logo;
    public $logo_preview;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'company_address' => 'required|string|max:1000',
        'company_phone' => 'required|string|max:20',
        'company_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ];

    protected $messages = [
        'company_name.required' => 'Company name is required.',
        'company_address.required' => 'Company address is required.',
        'company_phone.required' => 'Company phone is required.',
        'company_logo.image' => 'Logo must be an image file.',
        'company_logo.mimes' => 'Logo must be a JPEG, PNG, or JPG file.',
        'company_logo.max' => 'Logo file size must not exceed 2MB.',
    ];

    public function mount()
    {
        $settings = Setting::current();
        $this->company_name = $settings->company_name;
        $this->company_address = $settings->company_address;
        $this->company_phone = $settings->company_phone;
        $this->current_logo = $settings->company_logo;
    }

    public function updatedCompanyLogo()
    {
        $this->validateOnly('company_logo');
        
        if ($this->company_logo) {
            $this->logo_preview = $this->company_logo->temporaryUrl();
        }
    }

    public function save()
    {
        $this->validate();

        try {
            $settings = Setting::current();
            $oldValues = $settings->toArray();

            $data = [
                'company_name' => $this->company_name,
                'company_address' => $this->company_address,
                'company_phone' => $this->company_phone,
            ];

            // Handle logo upload
            if ($this->company_logo) {
                // Delete old logo if exists
                if ($settings->company_logo) {
                    Storage::disk('public')->delete($settings->company_logo);
                }
                
                $logoPath = $this->company_logo->store('company', 'public');
                $data['company_logo'] = $logoPath;
                $this->current_logo = $logoPath;
            }

            $settings = Setting::updateSettings($data);

            // Log the change
            $this->logSettingChange('company_settings', $oldValues, $settings->toArray());

            $this->company_logo = null;
            $this->logo_preview = null;

            session()->flash('success', 'Company settings updated successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update company settings: ' . $e->getMessage());
        }
    }

    public function removeLogo()
    {
        try {
            $settings = Setting::current();
            $oldValues = $settings->toArray();

            if ($settings->company_logo) {
                Storage::disk('public')->delete($settings->company_logo);
                $settings->update(['company_logo' => null]);
                $this->current_logo = null;

                // Log the change
                $this->logSettingChange('company_logo_removed', $oldValues, $settings->fresh()->toArray());

                session()->flash('success', 'Company logo removed successfully.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to remove logo: ' . $e->getMessage());
        }
    }

    private function logSettingChange(string $action, array $oldValues, array $newValues)
    {
        \Log::info('Settings Change', [
            'action' => $action,
            'user_id' => auth()->id(),
            'user_name' => auth()->user()->name,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'timestamp' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.company-settings');
    }
}