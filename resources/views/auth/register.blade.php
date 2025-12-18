<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Anugerah Rentcar') }} - Daftar Admin</title>

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
                        <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                    </div>
                </div>
                <h2 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-3">
                    Daftar Admin
                </h2>
                <p class="text-secondary-600 text-lg">
                    Sistem Manajemen Rental Mobil Anugerah Rentcar
                </p>
            </div>

            <!-- Register Form -->
            <div class="card p-8 lg:p-10 animate-slide-up">
                <form class="space-y-6" action="{{ route('register') }}" method="POST">
                    @csrf
                    
                    <!-- Name Field -->
                    <div>
                        <label for="name" class="form-label">Nama Lengkap</label>
                        <input id="name" name="name" type="text" autocomplete="name" required class="form-input" placeholder="Masukkan nama lengkap" value="{{ old('name') }}">
                        @error('name')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div>
                        <label for="email" class="form-label">Alamat Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required class="form-input" placeholder="Masukkan email" value="{{ old('email') }}">
                        @error('email')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label for="phone" class="form-label">Nomor Telepon</label>
                        <input id="phone" name="phone" type="text" autocomplete="tel" required class="form-input" placeholder="Masukkan nomor telepon" value="{{ old('phone') }}">
                        @error('phone')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Role Field -->
                    <div>
                        <label for="role" class="form-label">Peran</label>
                        <select id="role" name="role" required class="form-input">
                            <option value="">Pilih Peran</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                            <option value="driver" {{ old('role') == 'driver' ? 'selected' : '' }}>Driver</option>
                        </select>
                        @error('role')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="form-label">Password</label>
                        <input id="password" name="password" type="password" autocomplete="new-password" required class="form-input" placeholder="Masukkan password">
                        @error('password')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    <!-- Confirm Password Field -->
                    <div>
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required class="form-input" placeholder="Konfirmasi password">
                    </div>

                    <!-- Register Button -->
                    <div>
                        <button type="submit" class="btn-primary w-full text-lg">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <!-- Links -->
                <div class="mt-8 text-center space-y-3">
                    <div class="text-secondary-600">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="font-medium text-accent-600 hover:text-accent-500 transition-colors">
                            Masuk di sini
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