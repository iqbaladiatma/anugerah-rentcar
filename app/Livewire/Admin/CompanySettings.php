<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class CompanySettings extends Component
{
    public $company_name;
    public $company_address;
    public $company_phone;

    protected $rules = [
        'company_name' => 'required|string|max:255',
        'company_address' => 'required|string|max:1000',
        'company_phone' => 'required|string|max:20',
    ];

    protected $messages = [
        'company_name.required' => 'Company name is required.',
        'company_address.required' => 'Company address is required.',
        'company_phone.required' => 'Company phone is required.',
    ];

    public function mount()
    {
        $settings = Setting::current();
        $this->company_name = $settings->company_name;
        $this->company_address = $settings->company_address;
        $this->company_phone = $settings->company_phone;
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

            $settings = Setting::updateSettings($data);

            // Log the change
            $this->logSettingChange('company_settings', $oldValues, $settings->toArray());

            session()->flash('success', 'Company settings updated successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update company settings: ' . $e->getMessage());
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