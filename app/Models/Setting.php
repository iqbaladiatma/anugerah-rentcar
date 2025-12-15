<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

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
     * Get the company logo URL.
     */
    public function getCompanyLogoUrlAttribute(): ?string
    {
        return $this->company_logo ? asset('storage/' . $this->company_logo) : null;
    }

    /**
     * Get the current system settings.
     */
    public static function current(): self
    {
        return static::first() ?? new static([
            'company_name' => 'Anugerah Rentcar',
            'buffer_time_hours' => 3,
            'late_penalty_per_hour' => 50000,
            'member_discount_percentage' => 10,
        ]);
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
            $settings = static::create($data);
        }
        
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