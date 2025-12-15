<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Role constants.
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_STAFF = 'staff';
    const ROLE_DRIVER = 'driver';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get the bookings where this user is the driver.
     */
    public function driverBookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }

    /**
     * Get the expenses created by this user.
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class, 'created_by');
    }

    /**
     * Get all available roles.
     */
    public static function getRoles(): array
    {
        return [
            self::ROLE_ADMIN => 'Administrator',
            self::ROLE_STAFF => 'Staff',
            self::ROLE_DRIVER => 'Driver',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is staff.
     */
    public function isStaff(): bool
    {
        return $this->role === self::ROLE_STAFF;
    }

    /**
     * Check if user is driver.
     */
    public function isDriver(): bool
    {
        return $this->role === self::ROLE_DRIVER;
    }

    /**
     * Check if user can manage vehicles.
     */
    public function canManageVehicles(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_STAFF]);
    }

    /**
     * Check if user can manage customers.
     */
    public function canManageCustomers(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_STAFF]);
    }

    /**
     * Check if user can manage bookings.
     */
    public function canManageBookings(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_STAFF]);
    }

    /**
     * Check if user can view reports.
     */
    public function canViewReports(): bool
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_STAFF]);
    }

    /**
     * Check if user can manage system settings.
     */
    public function canManageSettings(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Scope to filter active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to filter by role.
     */
    public function scopeWithRole($query, string $role)
    {
        return $query->where('role', $role);
    }

    /**
     * Scope to filter drivers.
     */
    public function scopeDrivers($query)
    {
        return $query->where('role', self::ROLE_DRIVER);
    }
}
