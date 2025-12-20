<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ActiveSession;
use Jenssegers\Agent\Agent;

class TrackActiveSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $agent = new Agent();
            $sessionId = session()->getId();
            
            ActiveSession::updateOrCreate(
                [
                    'session_id' => $sessionId,
                ],
                [
                    'user_id' => auth()->id(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'browser' => $agent->browser() . ' ' . $agent->version($agent->browser()),
                    'platform' => $agent->platform() . ' ' . $agent->version($agent->platform()),
                    'device' => $agent->device() ?: ($agent->isDesktop() ? 'Desktop' : 'Unknown'),
                    'current_page' => $request->fullUrl(),
                    'last_activity' => now(),
                ]
            );
            
            // Clean up old sessions periodically (1% chance)
            if (rand(1, 100) === 1) {
                ActiveSession::cleanupOldSessions();
            }
        }
        
        return $next($request);
    }
}

