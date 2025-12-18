<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Anugerah Rentcar') }} - Rental Mobil Terpercaya</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-secondary-800 antialiased bg-primary-500">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-primary-500">
            <div class="animate-fade-in">
                <a href="/" wire:navigate>
                    <x-application-logo class="w-20 h-20 fill-current text-accent-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-primary-500 shadow-soft overflow-hidden sm:rounded-2xl border border-secondary-100 animate-slide-up">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
