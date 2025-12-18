<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Anugerah Rentcar') }} - Login Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white min-h-screen">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full animate-fade-in">
            <!-- Logo and Header -->
            <div class="text-center mb-8">
                <div class="flex justify-center mb-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center shadow-medium">
                        <img src="{{ asset('ini.jpg') }}" alt="Logo" class="w-16 h-16">
                    </div>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-3">
                    Login Admin
                </h2>
                <p class="text-secondary-600 text-lg">
                    Sistem Manajemen Rental Mobil Anugerah Rentcar
                </p>
            </div>

            <!-- Login Form -->
            <div class="card p-8 lg:p-10 animate-slide-up">
                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="form-label">
                            Alamat Email
                        </label>
                        <input id="email" name="email" type="email" autocomplete="email" required 
                               class="form-input" 
                               placeholder="Masukkan email Anda" value="{{ old('email') }}">
                        @error('email')
                            <p class="mt-2 text-sm text-accent-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="form-label">
                            Password
                        </label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required 
                               class="form-input" 
                               placeholder="Masukkan password Anda">
                        @error('password')
                            <p class="mt-2 text-sm text-accent-600 flex items-center">
                                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-accent-600 focus:ring-accent-500 border-secondary-300 rounded">
                            <label for="remember" class="ml-2 block text-sm text-secondary-700">
                                Ingat saya
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-accent-600 hover:text-accent-500 transition-colors">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div>
                        <button type="submit" class="btn-primary w-full text-lg">
                            Masuk ke Dashboard
                        </button>
                    </div>
                </form>

                <!-- Links -->
                <div class="mt-8 text-center space-y-3">
                    <div class="text-secondary-600">
                        Belum punya akun admin? 
                        <a href="{{ route('register') }}" class="font-medium text-accent-600 hover:text-accent-500 transition-colors">
                            Daftar di sini
                        </a>
                    </div>
                    <div>
                        <a href="{{ route('home') }}" class="text-secondary-500 hover:text-secondary-700 transition-colors flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>