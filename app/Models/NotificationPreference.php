<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NotificationPreference extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'notification_type',
        'email_enabled',
        'sms_enabled',
        'browser_enabled',
        'preferred_time',
        'instant_notifications',
        'daily_digest',
        'priority_filter',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_enabled' => 'boolean',
        'sms_enabled' => 'boolean',
        'browser_enabled' => 'boolean',
        'preferred_time' => 'datetime:H:i',
        'instant_notifications' => 'boolean',
        'daily_digest' => 'boolean',
        'priority_filter' => 'array',
    ];

    /**
     * Get the user that owns the preference.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get default preferences for a user.
     */
    public static function getDefaultPreferences(): array
    {
        return [
            Notification::TYPE_MAINTENANCE => [
                'email_enabled' => true,
                'sms_enabled' => false,
                'browser_enabled' => true,
                'instant_notifications' => true,
                'daily_digest' => false,
                'priority_filter' => ['high', 'medium', 'low'],
            ],
            Notification::TYPE_STNK_EXPIRY => [
                'email_enabled' => true,
                'sms_enabled' => false,
                'browser_enabled' => true,
                'instant_notifications' => true,
                'daily_digest' => false,
                'priority_filter' => ['high', 'medium'],
            ],
            Notification::TYPE_PAYMENT_OVERDUE => [
                'email_enabled' => true,
                'sms_enabled' => false,
                'browser_enabled' => true,
                'instant_notifications' => true,
                'daily_digest' => false,
                'priority_filter' => ['high', 'medium'],
            ],
            Notification::TYPE_BOOKING_CONFIRMATION => [
                'email_enabled' => true,
                'sms_enabled' => false,
                'browser_enabled' => true,
                'instant_notifications' => true,
                'daily_digest' => false,
                'priority_filter' => ['high', 'medium', 'low'],
            ],
            Notification::TYPE_BOOKING_REMINDER => [
                'email_enabled' => true,
                'sms_enabled' => true,
                'browser_enabled' => true,
                'instant_notifications' => true,
                'daily_digest' => false,
                'priority_filter' => ['high', 'medium'],
            ],
            Notification::TYPE_VEHICLE_RETURN => [
                'email_enabled' => false,
                'sms_enabled' => false,
                'browser_enabled' => true,
                'instant_notifications' => true,
                'daily_digest' => false,
                'priority_filter' => ['high', 'medium'],
            ],
            Notification::TYPE_SYSTEM_ALERT => [
                'email_enabled' => true,
                'sms_enabled' => false,
                'browser_enabled' => true,
                'instant_notifications' => true,
                'daily_digest' => false,
                'priority_filter' => ['high'],
            ],
        ];
    }

    /**
     * Create default preferences for a user.
     */
    public static function createDefaultsForUser(User $user): void
    {
        $defaults = static::getDefaultPreferences();
        
        foreach ($defaults as $type => $preferences) {
            static::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'notification_type' => $type,
                ],
                $preferences
            );
        }
    }

    /**
     * Check if user should receive notification via email.
     */
    public function shouldReceiveEmail(string $priority): bool
    {
        if (!$this->email_enabled) {
            return false;
        }

        $priorityFilter = $this->priority_filter ?? ['high', 'medium', 'low'];
        return in_array($priority, $priorityFilter);
    }

    /**
     * Check if user should receive notification via SMS.
     */
    public function shouldReceiveSms(string $priority): bool
    {
        if (!$this->sms_enabled) {
            return false;
        }

        $priorityFilter = $this->priority_filter ?? ['high', 'medium', 'low'];
        return in_array($priority, $priorityFilter);
    }

    /**
     * Check if user should receive browser notification.
     */
    public function shouldReceiveBrowser(string $priority): bool
    {
        if (!$this->browser_enabled) {
            return false;
        }

        $priorityFilter = $this->priority_filter ?? ['high', 'medium', 'low'];
        return in_array($priority, $priorityFilter);
    }
}
