<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NotificationPreference;
use App\Models\Notification;
use Illuminate\Support\Collection;

class NotificationPreferences extends Component
{
    public $preferences = [];
    public $globalPreferredTime = '09:00';

    public function mount()
    {
        $this->loadPreferences();
    }

    public function loadPreferences()
    {
        $user = auth()->user();
        $defaultPreferences = NotificationPreference::getDefaultPreferences();
        
        foreach ($defaultPreferences as $type => $defaults) {
            $preference = NotificationPreference::where('user_id', $user->id)
                ->where('notification_type', $type)
                ->first();

            if ($preference) {
                $this->preferences[$type] = [
                    'email_enabled' => $preference->email_enabled,
                    'sms_enabled' => $preference->sms_enabled,
                    'browser_enabled' => $preference->browser_enabled,
                    'instant_notifications' => $preference->instant_notifications,
                    'daily_digest' => $preference->daily_digest,
                    'priority_filter' => $preference->priority_filter ?? ['high', 'medium', 'low'],
                ];
                
                if ($preference->preferred_time) {
                    $this->globalPreferredTime = $preference->preferred_time->format('H:i');
                }
            } else {
                $this->preferences[$type] = $defaults;
            }
        }
    }

    public function getNotificationTypesProperty(): array
    {
        return [
            Notification::TYPE_MAINTENANCE => [
                'label' => 'Maintenance Alerts',
                'description' => 'Vehicle maintenance due dates and service reminders',
            ],
            Notification::TYPE_STNK_EXPIRY => [
                'label' => 'STNK Expiry',
                'description' => 'Vehicle registration renewal reminders',
            ],
            Notification::TYPE_PAYMENT_OVERDUE => [
                'label' => 'Payment Overdue',
                'description' => 'Customer payment reminders and overdue notices',
            ],
            Notification::TYPE_BOOKING_CONFIRMATION => [
                'label' => 'Booking Confirmations',
                'description' => 'New bookings requiring confirmation',
            ],
            Notification::TYPE_BOOKING_REMINDER => [
                'label' => 'Booking Reminders',
                'description' => 'Upcoming booking start and end reminders',
            ],
            Notification::TYPE_VEHICLE_RETURN => [
                'label' => 'Vehicle Returns',
                'description' => 'Vehicle return processing notifications',
            ],
            Notification::TYPE_SYSTEM_ALERT => [
                'label' => 'System Alerts',
                'description' => 'Critical system notifications and alerts',
            ],
        ];
    }

    public function updatePreference($type, $field, $value)
    {
        if (!isset($this->preferences[$type])) {
            $this->preferences[$type] = [];
        }
        
        $this->preferences[$type][$field] = $value;
    }

    public function togglePriority($type, $priority)
    {
        if (!isset($this->preferences[$type]['priority_filter'])) {
            $this->preferences[$type]['priority_filter'] = [];
        }

        $priorities = $this->preferences[$type]['priority_filter'];
        
        if (in_array($priority, $priorities)) {
            $this->preferences[$type]['priority_filter'] = array_values(array_diff($priorities, [$priority]));
        } else {
            $this->preferences[$type]['priority_filter'][] = $priority;
        }
    }

    public function savePreferences()
    {
        $user = auth()->user();
        
        foreach ($this->preferences as $type => $settings) {
            NotificationPreference::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'notification_type' => $type,
                ],
                array_merge($settings, [
                    'preferred_time' => $this->globalPreferredTime,
                ])
            );
        }

        session()->flash('message', 'Notification preferences saved successfully.');
        $this->dispatch('preferences-saved');
    }

    public function resetToDefaults()
    {
        $this->preferences = NotificationPreference::getDefaultPreferences();
        $this->globalPreferredTime = '09:00';
        session()->flash('message', 'Preferences reset to defaults.');
    }

    public function render()
    {
        return view('livewire.admin.notification-preferences');
    }
}
