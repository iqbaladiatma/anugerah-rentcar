<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Carbon\Carbon;

class Notification extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'type',
        'title',
        'message',
        'details',
        'priority',
        'data',
        'action_url',
        'icon',
        'notifiable_type',
        'notifiable_id',
        'user_id',
        'recipient_type',
        'read_at',
        'email_sent_at',
        'sms_sent_at',
        'delivery_status',
        'is_active',
        'expires_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'data' => 'array',
        'delivery_status' => 'array',
        'read_at' => 'datetime',
        'email_sent_at' => 'datetime',
        'sms_sent_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Notification type constants.
     */
    const TYPE_MAINTENANCE = 'maintenance';
    const TYPE_STNK_EXPIRY = 'stnk_expiry';
    const TYPE_PAYMENT_OVERDUE = 'payment_overdue';
    const TYPE_BOOKING_CONFIRMATION = 'booking_confirmation';
    const TYPE_BOOKING_REMINDER = 'booking_reminder';
    const TYPE_VEHICLE_RETURN = 'vehicle_return';
    const TYPE_SYSTEM_ALERT = 'system_alert';

    /**
     * Priority constants.
     */
    const PRIORITY_LOW = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH = 'high';

    /**
     * Recipient type constants.
     */
    const RECIPIENT_USER = 'user';
    const RECIPIENT_CUSTOMER = 'customer';
    const RECIPIENT_ALL_STAFF = 'all_staff';

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the notifiable model (car, booking, customer, etc.).
     */
    public function notifiable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(): void
    {
        $this->update(['read_at' => Carbon::now()]);
    }

    /**
     * Mark notification as unread.
     */
    public function markAsUnread(): void
    {
        $this->update(['read_at' => null]);
    }

    /**
     * Check if notification is read.
     */
    public function isRead(): bool
    {
        return !is_null($this->read_at);
    }

    /**
     * Check if notification is unread.
     */
    public function isUnread(): bool
    {
        return is_null($this->read_at);
    }

    /**
     * Check if notification is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && Carbon::now()->isAfter($this->expires_at);
    }

    /**
     * Mark email as sent.
     */
    public function markEmailSent(): void
    {
        $this->update(['email_sent_at' => Carbon::now()]);
    }

    /**
     * Mark SMS as sent.
     */
    public function markSmsSent(): void
    {
        $this->update(['sms_sent_at' => Carbon::now()]);
    }

    /**
     * Update delivery status.
     */
    public function updateDeliveryStatus(string $method, string $status, ?string $error = null): void
    {
        $deliveryStatus = $this->delivery_status ?? [];
        $deliveryStatus[$method] = [
            'status' => $status,
            'attempted_at' => Carbon::now()->toISOString(),
            'error' => $error,
        ];
        
        $this->update(['delivery_status' => $deliveryStatus]);
    }

    /**
     * Get formatted time ago.
     */
    public function getTimeAgoAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get priority color class.
     */
    public function getPriorityColorAttribute(): string
    {
        return match ($this->priority) {
            self::PRIORITY_HIGH => 'text-red-600 bg-red-50',
            self::PRIORITY_MEDIUM => 'text-yellow-600 bg-yellow-50',
            self::PRIORITY_LOW => 'text-blue-600 bg-blue-50',
            default => 'text-gray-600 bg-gray-50',
        };
    }

    /**
     * Get icon class based on type.
     */
    public function getIconClassAttribute(): string
    {
        if ($this->icon) {
            return $this->icon;
        }

        return match ($this->type) {
            self::TYPE_MAINTENANCE => 'wrench',
            self::TYPE_STNK_EXPIRY => 'calendar',
            self::TYPE_PAYMENT_OVERDUE => 'currency-dollar',
            self::TYPE_BOOKING_CONFIRMATION => 'clipboard-list',
            self::TYPE_BOOKING_REMINDER => 'clock',
            self::TYPE_VEHICLE_RETURN => 'truck',
            self::TYPE_SYSTEM_ALERT => 'exclamation-triangle',
            default => 'bell',
        };
    }

    /**
     * Scope to filter active notifications.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', Carbon::now());
                    });
    }

    /**
     * Scope to filter unread notifications.
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope to filter by priority.
     */
    public function scopeWithPriority($query, string $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope to filter by type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by user.
     */
    public function scopeForUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope to filter for all staff.
     */
    public function scopeForAllStaff($query)
    {
        return $query->where('recipient_type', self::RECIPIENT_ALL_STAFF);
    }

    /**
     * Create a maintenance notification.
     */
    public static function createMaintenanceNotification(Car $car, string $message, string $details = null): self
    {
        return static::create([
            'type' => self::TYPE_MAINTENANCE,
            'title' => 'Maintenance Due',
            'message' => $message,
            'details' => $details,
            'priority' => self::PRIORITY_MEDIUM,
            'icon' => 'wrench',
            'notifiable_type' => Car::class,
            'notifiable_id' => $car->id,
            'recipient_type' => self::RECIPIENT_ALL_STAFF,
            'action_url' => route('admin.vehicles.show', $car->id),
        ]);
    }

    /**
     * Create a STNK expiry notification.
     */
    public static function createStnkExpiryNotification(Car $car, int $daysLeft): self
    {
        return static::create([
            'type' => self::TYPE_STNK_EXPIRY,
            'title' => 'STNK Renewal',
            'message' => "STNK expires soon for {$car->license_plate}",
            'details' => $daysLeft <= 7 ? "{$daysLeft} days left" : "Expires in {$daysLeft} days",
            'priority' => $daysLeft <= 7 ? self::PRIORITY_HIGH : self::PRIORITY_MEDIUM,
            'icon' => 'calendar',
            'notifiable_type' => Car::class,
            'notifiable_id' => $car->id,
            'recipient_type' => self::RECIPIENT_ALL_STAFF,
            'action_url' => route('admin.vehicles.show', $car->id),
        ]);
    }

    /**
     * Create a payment overdue notification.
     */
    public static function createPaymentOverdueNotification(Booking $booking, int $daysOverdue): self
    {
        return static::create([
            'type' => self::TYPE_PAYMENT_OVERDUE,
            'title' => 'Payment Overdue',
            'message' => "Payment pending from {$booking->customer->name}",
            'details' => "Booking #{$booking->booking_number} - {$daysOverdue} days overdue",
            'priority' => $daysOverdue > 3 ? self::PRIORITY_HIGH : self::PRIORITY_MEDIUM,
            'icon' => 'currency-dollar',
            'notifiable_type' => Booking::class,
            'notifiable_id' => $booking->id,
            'recipient_type' => self::RECIPIENT_ALL_STAFF,
            'action_url' => route('admin.bookings.show', $booking->id),
        ]);
    }

    /**
     * Create a booking confirmation notification.
     */
    public static function createBookingConfirmationNotification(Booking $booking): self
    {
        return static::create([
            'type' => self::TYPE_BOOKING_CONFIRMATION,
            'title' => 'Booking Confirmation',
            'message' => 'Booking confirmation required',
            'details' => "Booking #{$booking->booking_number} from {$booking->customer->name}",
            'priority' => self::PRIORITY_MEDIUM,
            'icon' => 'clipboard-list',
            'notifiable_type' => Booking::class,
            'notifiable_id' => $booking->id,
            'recipient_type' => self::RECIPIENT_ALL_STAFF,
            'action_url' => route('admin.bookings.show', $booking->id),
        ]);
    }
}
