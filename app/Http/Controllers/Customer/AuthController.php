<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Events\CustomerCreated;

class AuthController extends Controller
{
    /**
     * Display the customer login view.
     */
    public function showLoginForm(): View
    {
        return view('customer.auth.login');
    }

    /**
     * Handle an incoming customer authentication request.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('customer')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('customer.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Display the customer registration view.
     */
    public function showRegistrationForm(): View
    {
        return view('customer.auth.register');
    }

    /**
     * Handle an incoming customer registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        // Stage 1: Only validate name, email, password
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:customers'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Create customer with minimal info
        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_completed' => false, // Mark as incomplete
        ]);

        event(new Registered($customer));

        // Dispatch event for new customer notification
        CustomerCreated::dispatch($customer);

        Auth::guard('customer')->login($customer);

        // Redirect to complete profile instead of dashboard
        return redirect()->route('customer.complete-profile')
            ->with('success', 'Account created! Please complete your profile to continue.');
    }

    /**
     * Destroy an authenticated customer session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}