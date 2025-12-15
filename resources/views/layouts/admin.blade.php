<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Anugerah Rentcar') }} - Admin Panel</title>

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
            <!-- Sidebar -->
            <livewire:layout.admin-sidebar />
            
            <!-- Main Content Area -->
            <div class="lg:pl-64">
                <!-- Top Navigation -->
                <livewire:layout.admin-header />
                
                <!-- Page Content -->
                <main class="py-6">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <!-- Page Heading -->
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
        </div>
        
        <!-- Livewire Scripts -->
        @livewireScripts
    </body>
</html>