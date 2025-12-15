<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <h1 class="text-xl font-semibold text-gray-900">Anugerah Rentcar</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-700">Welcome, {{ auth()->user()->name }}</span>
                        <span class="status-badge bg-primary-100 text-primary-800">{{ ucfirst(auth()->user()->role) }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-secondary text-sm">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="px-4 py-6 sm:px-0">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-lg font-medium text-gray-900">Dashboard</h2>
                    </div>
                    <div class="card-body">
                        <p class="text-gray-600">Welcome to the Anugerah Rentcar Management System!</p>
                        <p class="text-sm text-gray-500 mt-2">You are logged in as: <strong>{{ auth()->user()->role }}</strong></p>
                        
                        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="card bg-primary-50 border-primary-200">
                                <div class="card-body">
                                    <h3 class="text-lg font-medium text-primary-900">Fleet Management</h3>
                                    <p class="text-sm text-primary-700 mt-1">Manage vehicles, maintenance, and availability</p>
                                </div>
                            </div>
                            
                            <div class="card bg-success-50 border-success-200">
                                <div class="card-body">
                                    <h3 class="text-lg font-medium text-success-900">Booking System</h3>
                                    <p class="text-sm text-success-700 mt-1">Handle reservations and customer bookings</p>
                                </div>
                            </div>
                            
                            <div class="card bg-warning-50 border-warning-200">
                                <div class="card-body">
                                    <h3 class="text-lg font-medium text-warning-900">Reports & Analytics</h3>
                                    <p class="text-sm text-warning-700 mt-1">Generate reports and view business insights</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>