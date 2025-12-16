<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * Cache key for settings.
     */
    const CACHE_KEY = 'anugerah_rentcar:settings:current';
    const CACHE_TTL = 3600; // 1 hour

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone',
        'company_logo',
        'late_penalty_per_hour',
        'buffer_time_hours',
        'member_discount_percentage',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'late_penalty_per_hour' => 'decimal:2',
        'buffer_time_hours' => 'integer',
        'member_discount_percentage' => 'decimal:2',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Clear cache when settings are updated
        static::saved(function ($setting) {
            Cache::forget(self::CACHE_KEY);
        });

        static::deleted(function ($setting) {
            Cache::forget(self::CACHE_KEY);
        });
    }

    /**
     * Get the company logo URL.
     */
    public function getCompanyLogoUrlAttribute(): ?string
    {
        return $this->company_logo ? asset('storage/' . $this->company_logo) : null;
    }

    /**
     * Get the current system settings with caching.
     */
    public static function current(): self
    {
        return Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return static::first() ?? new static([
                'company_name' => 'Anugerah Rentcar',
                'buffer_time_hours' => 3,
                'late_penalty_per_hour' => 50000,
                'member_discount_percentage' => 10,
            ]);
        });
    }

    /**
     * Clear the settings cache.
     */
    public static function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }

    /**
     * Update or create system settings.
     */
    public static function updateSettings(array $data): self
    {
        $settings = static::first();
        
        if ($settings) {
            $settings->update($data);
        } else {
            // Merge with default values when creating new settings
            $defaults = [
                'company_name' => 'Anugerah Rentcar',
                'company_address' => 'Jl. Raya No. 123, Jakarta',
                'company_phone' => '+62-21-1234567',
                'late_penalty_per_hour' => 50000,
                'buffer_time_hours' => 3,
                'member_discount_percentage' => 10,
            ];
            
            $settings = static::create(array_merge($defaults, $data));
        }

        // Clear cache after update
        self::clearCache();
        
        return $settings;
    }

    /**
     * Get the late penalty rate per hour.
     */
    public function getLatePenaltyRate(): float
    {
        return (float) $this->late_penalty_per_hour;
    }

    /**
     * Get the member discount percentage.
     */
    public function getMemberDiscountPercentage(): float
    {
        return (float) $this->member_discount_percentage;
    }

    /**
     * Get the buffer time in hours.
     */
    public function getBufferTimeHours(): int
    {
        return (int) $this->buffer_time_hours;
    }
}