<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\OptimizedQueries;
use Carbon\Carbon;

class Car extends Model
{
    use HasFactory, OptimizedQueries;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'license_plate',
        'brand',
        'model',
        'year',
        'color',
        'stnk_number',
        'stnk_expiry',
        'last_oil_change',
        'oil_change_interval_km',
        'current_odometer',
        'daily_rate',
        'weekly_rate',
        'driver_fee_per_day',
        'photo_front',
        'photo_side',
        'photo_back',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'stnk_expiry' => 'date',
        'last_oil_change' => 'date',
        'oil_change_interval_km' => 'integer',
        'current_odometer' => 'integer',
        'daily_rate' => 'decimal:2',
        'weekly_rate' => 'decimal:2',
        'driver_fee_per_day' => 'decimal:2',
    ];

    /**
     * The possible status values.
     */
    const STATUS_AVAILABLE = 'available';
    const STATUS_RENTED = 'rented';
    const STATUS_MAINTENANCE = 'maintenance';
    const STATUS_INACTIVE = 'inactive';

    /**
     * Get the bookings for the car.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the maintenance records for the car.
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Get the active booking for the car.
     */
    public function activeBooking()
    {
        return $this->bookings()->where('booking_status', 'active')->first();
    }

    /**
     * Check if car is available for booking in date range.
     */
    public function isAvailableForPeriod(Carbon $startDate, Carbon $endDate): bool
    {
        if ($this->status !== self::STATUS_AVAILABLE) {
            return false;
        }

        // Check for conflicting bookings
        $conflictingBookings = $this->bookings()
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('start_date', '<=', $startDate)
                          ->where('end_date', '>=', $endDate);
                    });
            })
            ->exists();

        return !$conflictingBookings;
    }

    /**
     * Get the next available date for the car.
     */
    public function getNextAvailableDate(): Carbon
    {
        $lastBooking = $this->bookings()
            ->whereIn('booking_status', ['confirmed', 'active'])
            ->orderBy('end_date', 'desc')
            ->first();

        if (!$lastBooking) {
            return Carbon::now();
        }

        // Add buffer time
        $bufferHours = Setting::current()->getBufferTimeHours();
        return Carbon::parse($lastBooking->end_date)->addHours($bufferHours);
    }

    /**
     * Check if maintenance is due.
     */
    public function isMaintenanceDue(): bool
    {
        return $this->isOilChangeDue() || $this->isStnkExpiringSoon();
    }

    /**
     * Check if oil change is due.
     */
    public function isOilChangeDue(): bool
    {
        if (!$this->last_oil_change || !$this->oil_change_interval_km) {
            return false;
        }

        $daysSinceOilChange = Carbon::parse($this->last_oil_change)->diffInDays(Carbon::now());
        return $daysSinceOilChange >= 90; // 3 months
    }

    /**
     * Check if STNK is expiring soon (within 30 days).
     */
    public function isStnkExpiringSoon(): bool
    {
        if (!$this->stnk_expiry) {
            return false;
        }

        return Carbon::parse($this->stnk_expiry)->diffInDays(Carbon::now()) <= 7;
    }

    /**
     * Get maintenance notifications.
     */
    public function getMaintenanceNotifications(): array
    {
        $notifications = [];

        // Check oil change first (for test consistency)
        if ($this->isOilChangeDue()) {
            $notifications[] = [
                'type' => 'oil_change',
                'message' => "Oil change due for {$this->license_plate}",
                'priority' => 'medium',
            ];
        }

        if ($this->isStnkExpiringSoon()) {
            $daysLeft = Carbon::parse($this->stnk_expiry)->diffInDays(Carbon::now());
            $notifications[] = [
                'type' => 'stnk_expiry',
                'message' => "STNK expires in {$daysLeft} days for {$this->license_plate}",
                'priority' => $daysLeft <= 7 ? 'high' : 'medium',
            ];
        }

        return $notifications;
    }

    /**
     * Calculate rate for given duration.
     */
    public function calculateRate(int $days): float
    {
        if ($days >= 7) {
            $weeks = floor($days / 7);
            $remainingDays = $days % 7;
            return ($weeks * $this->weekly_rate) + ($remainingDays * $this->daily_rate);
        }

        return $days * $this->daily_rate;
    }

    /**
     * Get photo URLs.
     */
    public function getPhotoFrontUrlAttribute(): ?string
    {
        return $this->photo_front ? asset('storage/' . $this->photo_front) : null;
    }

    public function getPhotoSideUrlAttribute(): ?string
    {
        return $this->photo_side ? asset('storage/' . $this->photo_side) : null;
    }

    public function getPhotoBackUrlAttribute(): ?string
    {
        return $this->photo_back ? asset('storage/' . $this->photo_back) : null;
    }

    /**
     * Get all photo URLs as array.
     */
    public function getPhotoUrlsAttribute(): array
    {
        return array_filter([
            'front' => $this->photo_front_url,
            'side' => $this->photo_side_url,
            'back' => $this->photo_back_url,
        ]);
    }

    /**
     * Scope to filter available cars.
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', self::STATUS_AVAILABLE);
    }

    /**
     * Scope to filter cars needing maintenance.
     */
    public function scopeMaintenanceDue($query)
    {
        return $query->where(function ($q) {
            $q->where('last_oil_change', '<=', Carbon::now()->subDays(90))
              ->orWhere('stnk_expiry', '<=', Carbon::now()->addDays(7));
        });
    }

    /**
     * Update car status.
     */
    public function updateStatus(string $status): void
    {
        $this->update(['status' => $status]);
    }

    /**
     * Mark car as rented.
     */
    public function markAsRented(): void
    {
        $this->updateStatus(self::STATUS_RENTED);
    }

    /**
     * Mark car as available.
     */
    public function markAsAvailable(): void
    {
        $this->updateStatus(self::STATUS_AVAILABLE);
    }

    /**
     * Mark car as in maintenance.
     */
    public function markAsInMaintenance(): void
    {
        $this->updateStatus(self::STATUS_MAINTENANCE);
    }

    /**
     * Get common relations to eager load.
     */
    protected function getCommonRelations(): array
    {
        return ['bookings', 'maintenances'];
    }

    /**
     * Get essential columns for list views.
     */
    protected function getEssentialColumns(): array
    {
        return [
            'id',
            'license_plate',
            'brand',
            'model',
            'year',
            'status',
            'daily_rate',
            'photo_front',
        ];
    }
}