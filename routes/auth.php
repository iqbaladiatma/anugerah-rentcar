<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    // NOTE: Login route is handled by UnifiedLoginController in web.php
    // This allows both admin and customer login through single endpoint /masuk

    Volt::route('daftar', 'pages.auth.register')
        ->name('register.admin');

    Volt::route('lupa-password', 'pages.auth.forgot-password')
        ->name('password.request');

    Volt::route('reset-password/{token}', 'pages.auth.reset-password')
        ->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verifikasi-email', 'pages.auth.verify-email')
        ->middleware('throttle:6,1')
        ->name('verification.notice');

    Route::get('verifikasi-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('konfirmasi-password', 'pages.auth.confirm-password')
        ->name('password.confirm');

    Route::post('keluar', [LoginController::class, 'logout'])
        ->name('logout');
});
