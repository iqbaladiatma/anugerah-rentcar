<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Maintenance extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'car_id',
        'maintenance_type',
        'description',
        'cost',
        'service_date',
        'next_service_date',
        'odometer_at_service',
        'service_provider',
        'receipt_photo',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cost' => 'decimal:2',
        'service_date' => 'date',
        'next_service_date' => 'date',
        'odometer_at_service' => 'integer',
    ];

    /**
     * Maintenance type constants.
     */
    const TYPE_ROUTINE = 'routine';
    const TYPE_REPAIR = 'repair';
    const TYPE_INSPECTION = 'inspection';

    /**
     * Get the car that owns the maintenance record.
     */
    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    /**
     * Get receipt photo URL.
     */
    public function getReceiptPhotoUrlAttribute(): ?string
    {
        return $this->receipt_photo ? asset('storage/' . $this->receipt_photo) : null;
    }

    /**
     * Check if next service is due.
     */
    public function isNextServiceDue(): bool
    {
        if (!$this->next_service_date) {
            return false;
        }

        return Carbon::parse($this->next_service_date) <= Carbon::now();
    }

    /**
     * Check if next service is due soon (within 7 days).
     */
    public function isNextServiceDueSoon(): bool
    {
        if (!$this->next_service_date) {
            return false;
        }

        return Carbon::parse($this->next_service_date) <= Carbon::now()->addDays(7);
    }

    /**
     * Get days until next service.
     */
    public function getDaysUntilNextService(): ?int
    {
        if (!$this->next_service_date) {
            return null;
        }

        $daysUntil = Carbon::now()->diffInDays(Carbon::parse($this->next_service_date), false);
        return $daysUntil >= 0 ? $daysUntil : 0;
    }

    /**
     * Calculate maintenance cost per kilometer.
     */
    public function getCostPerKilometer(): ?float
    {
        if (!$this->odometer_at_service || !$this->car) {
            return null;
        }

        $previousMaintenance = static::where('car_id', $this->car_id)
            ->where('service_date', '<', $this->service_date)
            ->orderBy('service_date', 'desc')
            ->first();

        if (!$previousMaintenance || !$previousMaintenance->odometer_at_service) {
            return null;
        }

        $kilometersDriven = $this->odometer_at_service - $previousMaintenance->odometer_at_service;
        
        if ($kilometersDriven <= 0) {
            return null;
        }

        return $this->cost / $kilometersDriven;
    }

    /**
     * Get maintenance history summary for the car.
     */
    public static function getHistorySummaryForCar(int $carId): array
    {
        $maintenances = static::where('car_id', $carId)
            ->orderBy('service_date', 'desc')
            ->get();

        $totalCost = $maintenances->sum('cost');
        $routineCount = $maintenances->where('maintenance_type', self::TYPE_ROUTINE)->count();
        $repairCount = $maintenances->where('maintenance_type', self::TYPE_REPAIR)->count();
        $inspectionCount = $maintenances->where('maintenance_type', self::TYPE_INSPECTION)->count();

        $lastMaintenance = $maintenances->first();
        $nextDue = $lastMaintenance ? $lastMaintenance->next_service_date : null;

        return [
            'total_cost' => $totalCost,
            'total_count' => $maintenances->count(),
            'routine_count' => $routineCount,
            'repair_count' => $repairCount,
            'inspection_count' => $inspectionCount,
            'last_service_date' => $lastMaintenance?->service_date,
            'next_service_date' => $nextDue,
            'average_cost' => $maintenances->count() > 0 ? $totalCost / $maintenances->count() : 0,
        ];
    }

    /**
     * Schedule next routine maintenance.
     */
    public function scheduleNextMaintenance(int $intervalDays = 90): void
    {
        $nextServiceDate = Carbon::parse($this->service_date)->addDays($intervalDays);
        $this->update(['next_service_date' => $nextServiceDate]);
    }

    /**
     * Create maintenance reminder notification.
     */
    public function createReminderNotification(): array
    {
        $daysUntil = $this->getDaysUntilNextService();
        
        if ($daysUntil === null) {
            return [];
        }

        $priority = match(true) {
            $daysUntil <= 0 => 'high',
            $daysUntil <= 3 => 'medium',
            $daysUntil <= 7 => 'low',
            default => 'info'
        };

        $message = $daysUntil <= 0 
            ? "Maintenance overdue for {$this->car->license_plate}"
            : "Maintenance due in {$daysUntil} days for {$this->car->license_plate}";

        return [
            'type' => 'maintenance_reminder',
            'car_id' => $this->car_id,
            'maintenance_id' => $this->id,
            'message' => $message,
            'priority' => $priority,
            'due_date' => $this->next_service_date,
            'days_until_due' => $daysUntil,
        ];
    }

    /**
     * Scope to filter by maintenance type.
     */
    public function scopeOfType($query, string $type)
    {
        return $query->where('maintenance_type', $type);
    }

    /**
     * Scope to filter routine maintenance.
     */
    public function scopeRoutine($query)
    {
        return $query->where('maintenance_type', self::TYPE_ROUTINE);
    }

    /**
     * Scope to filter repairs.
     */
    public function scopeRepairs($query)
    {
        return $query->where('maintenance_type', self::TYPE_REPAIR);
    }

    /**
     * Scope to filter inspections.
     */
    public function scopeInspections($query)
    {
        return $query->where('maintenance_type', self::TYPE_INSPECTION);
    }

    /**
     * Scope to filter overdue maintenance.
     */
    public function scopeOverdue($query)
    {
        return $query->whereNotNull('next_service_date')
                    ->where('next_service_date', '<', Carbon::now());
    }

    /**
     * Scope to filter maintenance due soon.
     */
    public function scopeDueSoon($query, int $days = 7)
    {
        return $query->whereNotNull('next_service_date')
                    ->where('next_service_date', '<=', Carbon::now()->addDays($days))
                    ->where('next_service_date', '>=', Carbon::now());
    }

    /**
     * Scope to filter by date range.
     */
    public function scopeInDateRange($query, Carbon $startDate, Carbon $endDate)
    {
        return $query->whereBetween('service_date', [$startDate, $endDate]);
    }

    /**
     * Boot method to update car's last oil change date.
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($maintenance) {
            // Update car's last oil change date if this is an oil change
            if (str_contains(strtolower($maintenance->description), 'oil') || 
                $maintenance->maintenance_type === self::TYPE_ROUTINE) {
                $maintenance->car->update([
                    'last_oil_change' => $maintenance->service_date,
                    'current_odometer' => $maintenance->odometer_at_service,
                ]);
            }
        });
    }
}