<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarInspection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'inspection_type',
        'fuel_level',
        'odometer_reading',
        'exterior_condition',
        'interior_condition',
        'photos',
        'inspector_signature',
        'customer_signature',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'odometer_reading' => 'integer',
        'exterior_condition' => 'array',
        'interior_condition' => 'array',
        'photos' => 'array',
    ];

    /**
     * Inspection type constants.
     */
    const TYPE_CHECKOUT = 'checkout';
    const TYPE_CHECKIN = 'checkin';

    /**
     * Fuel level constants.
     */
    const FUEL_EMPTY = 'empty';
    const FUEL_QUARTER = 'quarter';
    const FUEL_HALF = 'half';
    const FUEL_THREE_QUARTER = 'three_quarter';
    const FUEL_FULL = 'full';

    /**
     * Get the booking that owns the inspection.
     */
    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the car through the booking relationship.
     */
    public function car()
    {
        return $this->booking->car;
    }

    /**
     * Get the customer through the booking relationship.
     */
    public function customer()
    {
        return $this->booking->customer;
    }

    /**
     * Check if inspection has damage reports.
     */
    public function hasDamage(): bool
    {
        $exteriorDamage = !empty($this->exterior_condition) && 
                         array_filter($this->exterior_condition, function($item) {
                             return !empty($item['damage']) || !empty($item['description']);
                         });
        
        $interiorDamage = !empty($this->interior_condition) && 
                         array_filter($this->interior_condition, function($item) {
                             return !empty($item['damage']) || !empty($item['description']);
                         });

        return !empty($exteriorDamage) || !empty($interiorDamage);
    }

    /**
     * Get damage summary.
     */
    public function getDamageSummary(): array
    {
        $damages = [];

        if (!empty($this->exterior_condition)) {
            foreach ($this->exterior_condition as $condition) {
                if (!empty($condition['damage']) || !empty($condition['description'])) {
                    $damages[] = [
                        'type' => 'exterior',
                        'area' => $condition['area'] ?? 'Unknown',
                        'damage' => $condition['damage'] ?? '',
                        'description' => $condition['description'] ?? '',
                    ];
                }
            }
        }

        if (!empty($this->interior_condition)) {
            foreach ($this->interior_condition as $condition) {
                if (!empty($condition['damage']) || !empty($condition['description'])) {
                    $damages[] = [
                        'type' => 'interior',
                        'area' => $condition['area'] ?? 'Unknown',
                        'damage' => $condition['damage'] ?? '',
                        'description' => $condition['description'] ?? '',
                    ];
                }
            }
        }

        return $damages;
    }

    /**
     * Get photo URLs.
     */
    public function getPhotoUrlsAttribute(): array
    {
        if (empty($this->photos)) {
            return [];
        }

        return array_map(function($photo) {
            return asset('storage/' . $photo);
        }, $this->photos);
    }

    /**
     * Get inspector signature URL.
     */
    public function getInspectorSignatureUrlAttribute(): ?string
    {
        return $this->inspector_signature ? asset('storage/' . $this->inspector_signature) : null;
    }

    /**
     * Get customer signature URL.
     */
    public function getCustomerSignatureUrlAttribute(): ?string
    {
        return $this->customer_signature ? asset('storage/' . $this->customer_signature) : null;
    }

    /**
     * Add exterior condition entry.
     */
    public function addExteriorCondition(string $area, string $damage = '', string $description = ''): void
    {
        $conditions = $this->exterior_condition ?? [];
        $conditions[] = [
            'area' => $area,
            'damage' => $damage,
            'description' => $description,
            'timestamp' => now()->toISOString(),
        ];
        
        $this->update(['exterior_condition' => $conditions]);
    }

    /**
     * Add interior condition entry.
     */
    public function addInteriorCondition(string $area, string $damage = '', string $description = ''): void
    {
        $conditions = $this->interior_condition ?? [];
        $conditions[] = [
            'area' => $area,
            'damage' => $damage,
            'description' => $description,
            'timestamp' => now()->toISOString(),
        ];
        
        $this->update(['interior_condition' => $conditions]);
    }

    /**
     * Add inspection photo.
     */
    public function addPhoto(string $photoPath): void
    {
        $photos = $this->photos ?? [];
        $photos[] = $photoPath;
        
        $this->update(['photos' => $photos]);
    }

    /**
     * Get fuel level percentage.
     */
    public function getFuelLevelPercentage(): int
    {
        return match($this->fuel_level) {
            self::FUEL_EMPTY => 0,
            self::FUEL_QUARTER => 25,
            self::FUEL_HALF => 50,
            self::FUEL_THREE_QUARTER => 75,
            self::FUEL_FULL => 100,
            default => 0,
        };
    }

    /**
     * Compare with another inspection (for checkout vs checkin).
     */
    public function compareWith(CarInspection $otherInspection): array
    {
        $comparison = [
            'fuel_level_change' => $this->getFuelLevelPercentage() - $otherInspection->getFuelLevelPercentage(),
            'odometer_change' => $this->odometer_reading - $otherInspection->odometer_reading,
            'new_damages' => [],
        ];

        // Compare damages (simplified - would need more complex logic for real comparison)
        $currentDamages = $this->getDamageSummary();
        $previousDamages = $otherInspection->getDamageSummary();
        
        // This is a simplified comparison - in reality, you'd need more sophisticated matching
        if (count($currentDamages) > count($previousDamages)) {
            $comparison['new_damages'] = array_slice($currentDamages, count($previousDamages));
        }

        return $comparison;
    }

    /**
     * Scope to filter by inspection type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('inspection_type', $type);
    }

    /**
     * Scope to filter checkout inspections.
     */
    public function scopeCheckout($query)
    {
        return $query->where('inspection_type', self::TYPE_CHECKOUT);
    }

    /**
     * Scope to filter checkin inspections.
     */
    public function scopeCheckin($query)
    {
        return $query->where('inspection_type', self::TYPE_CHECKIN);
    }
}