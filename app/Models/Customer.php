<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'nik',
        'ktp_photo',
        'sim_photo',
        'address',
        'is_member',
        'member_discount',
        'is_blacklisted',
        'blacklist_reason',
        'email_verified_at',
        'profile_completed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_member' => 'boolean',
        'member_discount' => 'decimal:2',
        'is_blacklisted' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'profile_completed' => 'boolean',
    ];

    /**
     * Get the bookings for the customer.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the active bookings for the customer.
     */
    public function activeBookings(): HasMany
    {
        return $this->bookings()->where('booking_status', 'active');
    }

    /**
     * Get the completed bookings for the customer.
     */
    public function completedBookings(): HasMany
    {
        return $this->bookings()->where('booking_status', 'completed');
    }

    /**
     * Check if customer can make new bookings.
     */
    public function canMakeBooking(): bool
    {
        return !$this->is_blacklisted;
    }

    /**
     * Get the member discount percentage.
     */
    public function getMemberDiscountPercentage(): float
    {
        if (!$this->is_member) {
            return 0;
        }

        return $this->member_discount ?? Setting::current()->getMemberDiscountPercentage();
    }

    /**
     * Apply member discount to amount.
     */
    public function applyMemberDiscount(float $amount): float
    {
        if (!$this->is_member) {
            return $amount;
        }

        $discountPercentage = $this->getMemberDiscountPercentage();
        $discountAmount = $amount * ($discountPercentage / 100);
        
        return $amount - $discountAmount;
    }

    /**
     * Calculate member discount amount.
     */
    public function calculateMemberDiscountAmount(float $amount): float
    {
        if (!$this->is_member) {
            return 0;
        }

        $discountPercentage = $this->getMemberDiscountPercentage();
        return $amount * ($discountPercentage / 100);
    }

    /**
     * Mark customer as blacklisted.
     */
    public function blacklist(string $reason): void
    {
        $this->update([
            'is_blacklisted' => true,
            'blacklist_reason' => $reason,
        ]);
    }

    /**
     * Remove customer from blacklist.
     */
    public function removeFromBlacklist(): void
    {
        $this->update([
            'is_blacklisted' => false,
            'blacklist_reason' => null,
        ]);
    }

    /**
     * Get KTP photo URL.
     */
    public function getKtpPhotoUrlAttribute(): ?string
    {
        return $this->ktp_photo ? asset('storage/' . $this->ktp_photo) : null;
    }

    /**
     * Get SIM photo URL.
     */
    public function getSimPhotoUrlAttribute(): ?string
    {
        return $this->sim_photo ? asset('storage/' . $this->sim_photo) : null;
    }

    /**
     * Scope to filter by member status.
     */
    public function scopeMembers($query)
    {
        return $query->where('is_member', true);
    }

    /**
     * Scope to filter by blacklist status.
     */
    public function scopeBlacklisted($query)
    {
        return $query->where('is_blacklisted', true);
    }

    /**
     * Scope to filter by active customers (not blacklisted).
     */
    public function scopeActive($query)
    {
        return $query->where('is_blacklisted', false);
    }
}