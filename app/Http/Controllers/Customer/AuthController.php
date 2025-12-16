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
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:customers'],
            'phone' => ['required', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nik' => ['required', 'string', 'size:16', 'unique:customers'],
            'address' => ['required', 'string'],
        ]);

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'nik' => $request->nik,
            'address' => $request->address,
        ]);

        event(new Registered($customer));

        Auth::guard('customer')->login($customer);

        return redirect(route('customer.dashboard'));
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