<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileCompleted
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated customer
        if (auth('customer')->check()) {
            $customer = auth('customer')->user();
            
            // If profile is not completed and not on complete-profile page
            if (!$customer->profile_completed && !$request->routeIs('customer.complete-profile*')) {
                return redirect()->route('customer.complete-profile')
                    ->with('warning', 'Please complete your profile to access all features.');
            }
        }
        
        return $next($request);
    }
}
