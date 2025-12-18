<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}">

        <title>{{ config('app.name', 'Anugerah Rentcar') }} - Panel Admin</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Livewire Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="min-h-screen">
            <!-- Bilah Sisi -->
            <livewire:layout.admin-sidebar />
            
            <!-- Area Konten Utama -->
            <div class="lg:pl-64">
                <!-- Navigasi Atas -->
                <livewire:layout.admin-header />
                
                <!-- Konten Halaman -->
                <main class="py-6 pb-20 lg:pb-6">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <!-- Judul Halaman -->
                        @if (isset($header))
                            <div class="mb-6">
                                {{ $header }}
                            </div>
                        @endif
                        
                        <!-- Page Content -->
                        {{ $slot }}
                    </div>
                </main>
            </div>

            <!-- Navigasi Bawah Seluler -->
            <livewire:layout.mobile-bottom-nav />
        </div>
        
        <!-- Livewire Scripts -->
        <x-notification />
        @livewireScripts
        @stack('scripts')
    </body>
</html>