<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                    Register for Anugerah Rentcar
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Car Rental Management System
                </p>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('register') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="form-label">Full Name</label>
                        <input id="name" name="name" type="text" autocomplete="name" required 
                               class="form-input" 
                               placeholder="Full Name" value="{{ old('name') }}">
                        @error('name')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="form-label">Email Address</label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="form-input" 
                               placeholder="Email address" value="{{ old('email') }}">
                        @error('email')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="phone" class="form-label">Phone Number</label>
                        <input id="phone" name="phone" type="text" autocomplete="tel" required 
                               class="form-input" 
                               placeholder="Phone number" value="{{ old('phone') }}">
                        @error('phone')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" required class="form-input">
                            <option value="">Select Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="driver" {{ old('role') == 'driver' ? 'selected' : '' }}>Driver</option>
                        </select>
                        @error('role')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required 
                               class="form-input" 
                               placeholder="Password">
                        @error('password')
                            <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required 
                               class="form-input" 
                               placeholder="Confirm Password">
                    </div>
                </div>

                <div>
                    <button type="submit" class="btn-primary w-full flex justify-center py-2 px-4">
                        Register
                    </button>
                </div>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                        Already have an account? Sign in here
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>