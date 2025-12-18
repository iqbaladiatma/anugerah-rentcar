<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Handle the homepage request.
     * Redirect authenticated users to their dashboard, or show public home.
     */
    public function index()
    {
        // Check if user is logged in as admin/staff
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard');
        }
        
        // Check if user is logged in as customer
        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
            
            // Check if profile is complete
            if ($customer && $customer->profile_completed) {
                return redirect()->route('customer.dashboard');
            } else {
                return redirect()->route('customer.complete-profile');
            }
        }
        
        // Not authenticated, show public homepage
        return view('public.home');
    }
}
