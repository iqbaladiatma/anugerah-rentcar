<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\OptimizedQueries;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory, OptimizedQueries;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_number',
        'booking_type',
        'admin_id',
        'customer_id',
        'car_id',
        'driver_id',
        'start_date',
        'end_date',
        'actual_return_date',
        'pickup_location',
        'return_location',
        'with_driver',
        'is_out_of_town',
        'out_of_town_fee',
        'base_amount',
        'driver_fee',
        'member_discount',
        'late_penalty',
        'total_amount',
        'deposit_amount',
        'payment_status',
        'payment_type',
        'paid_amount',
        'payment_proof',
        'deposit_proof',
        'payment_notes',
        'booking_status',
        'notes',
        // Walk-in Customer Data
        'walkin_customer_name',
        'walkin_customer_phone',
        'walkin_customer_id_number',
        'walkin_customer_address',
        // Penyerahan Kunci
        'kunci_diserahkan',
        'tanggal_serah_kunci',
        'petugas_serah_kunci_id',
        'foto_serah_kunci',
        'catatan_serah_kunci',
        'tanda_tangan_customer',
        // Pengembalian Kunci
        'kunci_dikembalikan',
        'tanggal_terima_kunci',
        'petugas_terima_kunci_id',
        'foto_terima_kunci',
        'catatan_terima_kunci',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'actual_return_date' => 'datetime',
        'with_driver' => 'boolean',
        'is_out_of_town' => 'boolean',
        'out_of_town_fee' => 'decimal:2',
        'base_amount' => 'decimal:2',
        'driver_fee' => 'decimal:2',
        'member_discount' => 'decimal:2',
        'late_penalty' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
    ];

    /**
     * Payment status constants.
     */
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_VERIFYING = 'verifying';
    const PAYMENT_PARTIAL = 'partial';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_REFUNDED = 'refunded';

    /**
     * Booking status constants.
     */
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_ACTIVE = 'active';
    const STATUS_COMPLETED = 'completed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Booking type constants.
     */
    const TYPE_ONLINE = 'online';
    const TYPE_WALKIN = 'walkin';

    /**
     * Get the admin who created walk-in booking.
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    /**
     * Check if this is a walk-in booking.
     */
    public function isWalkin(): bool
    {
        return $this->booking_type === self::TYPE_WALKIN;
    }

    /**
     * Check if this is an online booking.
     */
    public function isOnline(): bool
    {
        return $this->booking_type === self::TYPE_ONLINE;
    }

    /**
     * Get customer name (works for both online and walk-in).
     */
    public function getCustomerNameAttribute(): string
    {
        if ($this->isWalkin() && $this->walkin_customer_name) {
            return $this->walkin_customer_name;
        }
        return $this->customer?->name ?? 'Unknown';
    }

    /**
     * Get customer phone (works for both online and walk-in).
     */
    public function getCustomerPhoneAttribute(): string
    {
        if ($this->isWalkin() && $this->walkin_customer_phone) {
            return $this->walkin_customer_phone;
        }
        return $this->customer?->phone ?? '-';
    }

    /**
     * Get the customer that owns the booking.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get the car that belongs to the booking.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get the driver assigned to the booking.
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Get the staff who handed over the keys.
     */
    public function petugasSerahKunci(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_serah_kunci_id');
    }

    /**
     * Get the staff who received the keys back.
     */
    public function petugasTerimaKunci(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_terima_kunci_id');
    }

    /**
     * Get the car inspections for the booking.
     */
    public function carInspections(): HasMany
    {
        return $this->hasMany(CarInspection::class);
    }

    /**
     * Get the checkout inspection.
     */
    public function checkoutInspection()
    {
        return $this->carInspections()->where('inspection_type', 'checkout')->first();
    }

    /**
     * Get the checkin inspection.
     */
    public function checkinInspection()
    {
        return $this->carInspections()->where('inspection_type', 'checkin')->first();
    }

    /**
     * Calculate booking duration in days.
     */
    public function getDurationInDays(): int
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Calculate booking duration in hours.
     */
    public function getDurationInHours(): int
    {
        if (!$this->start_date || !$this->end_date) {
            return 0;
        }
        return $this->start_date->diffInHours($this->end_date);
    }

    /**
     * Calculate base rental amount.
     */
    public function calculateBaseAmount(): float
    {
        $days = $this->getDurationInDays();
        return $this->car->calculateRate($days);
    }

    /**
     * Calculate driver fee.
     */
    public function calculateDriverFee(): float
    {
        if (!$this->with_driver) {
            return 0;
        }

        $days = $this->getDurationInDays();
        return $days * $this->car->driver_fee_per_day;
    }

    /**
     * Calculate member discount amount.
     */
    public function calculateMemberDiscount(): float
    {
        if (!$this->customer->is_member) {
            return 0;
        }

        $subtotal = $this->calculateBaseAmount() + $this->calculateDriverFee() + $this->out_of_town_fee;
        return $this->customer->calculateMemberDiscountAmount($subtotal);
    }

    /**
     * Calculate total amount.
     */
    public function calculateTotalAmount(): float
    {
        $baseAmount = $this->calculateBaseAmount();
        $driverFee = $this->calculateDriverFee();
        $outOfTownFee = $this->out_of_town_fee ?? 0;
        $memberDiscount = $this->calculateMemberDiscount();
        $latePenalty = $this->late_penalty ?? 0;

        return $baseAmount + $driverFee + $outOfTownFee - $memberDiscount + $latePenalty;
    }

    /**
     * Calculate late penalty based on actual return time.
     */
    public function calculateLatePenalty(): float
    {
        if (!$this->actual_return_date || $this->actual_return_date <= $this->end_date) {
            return 0;
        }

        $lateHours = $this->end_date->diffInHours($this->actual_return_date);
        $settings = Setting::current();
        
        if ($lateHours <= 24) {
            // Hourly penalty for delays under 24 hours
            return $lateHours * $settings->getLatePenaltyRate();
        } else {
            // Daily extension rate for delays over 24 hours
            $lateDays = ceil($lateHours / 24);
            return $lateDays * $this->car->daily_rate;
        }
    }

    /**
     * Update pricing calculations.
     */
    public function updatePricing(): void
    {
        $this->update([
            'base_amount' => $this->calculateBaseAmount(),
            'driver_fee' => $this->calculateDriverFee(),
            'member_discount' => $this->calculateMemberDiscount(),
            'total_amount' => $this->calculateTotalAmount(),
        ]);
    }

    /**
     * Update late penalty based on actual return.
     */
    public function updateLatePenalty(): void
    {
        $latePenalty = $this->calculateLatePenalty();
        $this->update([
            'late_penalty' => $latePenalty,
            'total_amount' => $this->calculateTotalAmount(),
        ]);
    }

    /**
     * Generate unique booking number.
     */
    public static function generateBookingNumber(): string
    {
        $prefix = 'BK';
        $date = Carbon::now()->format('Ymd');
        $prefixWithDate = $prefix . $date;
        
        // Find the last booking number for this date
        $latestBooking = static::where('booking_number', 'like', $prefixWithDate . '%')
            ->orderBy('booking_number', 'desc')
            ->first();

        if (!$latestBooking) {
            $sequence = 1;
        } else {
            // Extract the sequence number (last 3 digits)
            $lastSequence = (int) substr($latestBooking->booking_number, -3);
            $sequence = $lastSequence + 1;
        }
        
        return $prefixWithDate . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Check if booking is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->booking_status === self::STATUS_ACTIVE && 
               Carbon::now() > $this->end_date;
    }

    /**
     * Check if booking can be cancelled.
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->booking_status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]);
    }

    /**
     * Check if booking can be modified.
     */
    public function canBeModified(): bool
    {
        return in_array($this->booking_status, [self::STATUS_PENDING, self::STATUS_CONFIRMED]) &&
               $this->start_date > Carbon::now()->addHours(24);
    }

    /**
     * Confirm the booking.
     */
    public function confirm(): void
    {
        $this->update(['booking_status' => self::STATUS_CONFIRMED]);
        $this->car->markAsRented();
    }

    /**
     * Activate the booking (vehicle checked out).
     */
    public function activate(): void
    {
        $this->update(['booking_status' => self::STATUS_ACTIVE]);
    }

    /**
     * Complete the booking (vehicle returned).
     */
    public function complete(): void
    {
        $this->update(['booking_status' => self::STATUS_COMPLETED]);
        $this->car->markAsAvailable();
    }

    /**
     * Cancel the booking.
     */
    public function cancel(): void
    {
        $this->update(['booking_status' => self::STATUS_CANCELLED]);
        $this->car->markAsAvailable();
    }

    /**
     * Scope to filter by status.
     */
    public function scopeWithStatus($query, string $status)
    {
        return $query->where('booking_status', $status);
    }

    /**
     * Scope to filter active bookings.
     */
    public function scopeActive($query)
    {
        return $query->where('booking_status', self::STATUS_ACTIVE);
    }

    /**
     * Scope to filter overdue bookings.
     */
    public function scopeOverdue($query)
    {
        return $query->where('booking_status', self::STATUS_ACTIVE)
                    ->where('end_date', '<', Carbon::now());
    }

    /**
     * Scope to filter bookings by date range.
     */
    public function scopeInDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('start_date', [$startDate, $endDate])
                    ->orWhereBetween('end_date', [$startDate, $endDate]);
    }

    /**
     * Boot method to auto-generate booking number.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (!$booking->booking_number) {
                $booking->booking_number = static::generateBookingNumber();
            }
        });
    }

    /**
     * Check if keys can be handed over.
     */
    public function bisaSerahKunci(): bool
    {
        return $this->booking_status === self::STATUS_CONFIRMED
            && $this->payment_status === self::PAYMENT_PAID
            && !$this->kunci_diserahkan;
    }

    /**
     * Check if keys can be received back.
     */
    public function bisaTerimaKunci(): bool
    {
        return $this->booking_status === self::STATUS_ACTIVE
            && $this->kunci_diserahkan
            && !$this->kunci_dikembalikan;
    }

    /**
     * Check if keys have been handed over.
     */
    public function sudahSerahKunci(): bool
    {
        return (bool) $this->kunci_diserahkan;
    }

    /**
     * Check if keys have been returned.
     */
    public function sudahTerimaKunci(): bool
    {
        return (bool) $this->kunci_dikembalikan;
    }
}