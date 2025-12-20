<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActiveSession extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'browser',
        'platform',
        'device',
        'current_page',
        'last_activity',
    ];

    protected $casts = [
        'last_activity' => 'datetime',
    ];

    /**
     * Get the user that owns the session.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if session is still active (within last 5 minutes).
     */
    public function isActive(): bool
    {
        return $this->last_activity->diffInMinutes(now()) < 5;
    }

    /**
     * Get all active sessions (within last 5 minutes).
     */
    public static function getActiveSessions()
    {
        return self::where('last_activity', '>=', now()->subMinutes(5))
            ->with('user')
            ->orderBy('last_activity', 'desc')
            ->get();
    }

    /**
     * Clean up old sessions (older than 1 hour).
     */
    public static function cleanupOldSessions()
    {
        return self::where('last_activity', '<', now()->subHour())->delete();
    }
}
