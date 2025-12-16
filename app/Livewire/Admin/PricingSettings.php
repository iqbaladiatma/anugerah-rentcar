<?php

namespace App\Livewire\Admin;

use App\Models\Setting;
use Livewire\Component;

class PricingSettings extends Component
{
    public $late_penalty_per_hour;
    public $buffer_time_hours;
    public $member_discount_percentage;

    protected $rules = [
        'late_penalty_per_hour' => 'required|numeric|min:0|max:999999.99',
        'buffer_time_hours' => 'required|integer|min:0|max:24',
        'member_discount_percentage' => 'required|numeric|min:0|max:100',
    ];

    protected $messages = [
        'late_penalty_per_hour.required' => 'Late penalty rate is required.',
        'late_penalty_per_hour.numeric' => 'Late penalty rate must be a number.',
        'late_penalty_per_hour.min' => 'Late penalty rate cannot be negative.',
        'late_penalty_per_hour.max' => 'Late penalty rate is too high.',
        'buffer_time_hours.required' => 'Buffer time is required.',
        'buffer_time_hours.integer' => 'Buffer time must be a whole number.',
        'buffer_time_hours.min' => 'Buffer time cannot be negative.',
        'buffer_time_hours.max' => 'Buffer time cannot exceed 24 hours.',
        'member_discount_percentage.required' => 'Member discount percentage is required.',
        'member_discount_percentage.numeric' => 'Member discount percentage must be a number.',
        'member_discount_percentage.min' => 'Member discount percentage cannot be negative.',
        'member_discount_percentage.max' => 'Member discount percentage cannot exceed 100%.',
    ];

    public function mount()
    {
        $settings = Setting::current();
        $this->late_penalty_per_hour = $settings->late_penalty_per_hour;
        $this->buffer_time_hours = $settings->buffer_time_hours;
        $this->member_discount_percentage = $settings->member_discount_percentage;
    }

    public function save()
    {
        $this->validate();

        try {
            $settings = Setting::current();
            $oldValues = $settings->toArray();

            $data = [
                'late_penalty_per_hour' => $this->late_penalty_per_hour,
                'buffer_time_hours' => $this->buffer_time_hours,
                'member_discount_percentage' => $this->member_discount_percentage,
            ];

            $settings = Setting::updateSettings($data);

            // Log the change
            $this->logSettingChange('pricing_configuration', $oldValues, $settings->toArray());

            session()->flash('success', 'Pricing configuration updated successfully.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update pricing configuration: ' . $e->getMessage());
        }
    }

    public function resetToDefaults()
    {
        try {
            $settings = Setting::current();
            $oldValues = $settings->toArray();

            $defaultData = [
                'late_penalty_per_hour' => 50000,
                'buffer_time_hours' => 3,
                'member_discount_percentage' => 10,
            ];

            $this->late_penalty_per_hour = $defaultData['late_penalty_per_hour'];
            $this->buffer_time_hours = $defaultData['buffer_time_hours'];
            $this->member_discount_percentage = $defaultData['member_discount_percentage'];

            $settings = Setting::updateSettings($defaultData);

            // Log the change
            $this->logSettingChange('pricing_reset_to_defaults', $oldValues, $settings->toArray());

            session()->flash('success', 'Pricing configuration reset to default values.');
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to reset pricing configuration: ' . $e->getMessage());
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
        return view('livewire.admin.pricing-settings');
    }
}