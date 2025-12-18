<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Anugerah Rentcar') }} - Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white font-sans antialiased">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-soft border-b border-secondary-100">
            <div class="container-custom">
                <div class="flex justify-between h-16 lg:h-20">
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-r from-accent-500 to-accent-600 rounded-xl flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 lg:w-7 lg:h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            </div>
                            <h1 class="text-xl lg:text-2xl font-bold text-secondary-900">Anugerah Rentcar</h1>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="hidden sm:block">
                            <span class="text-secondary-700 mr-2">Selamat datang,</span>
                            <span class="font-semibold text-secondary-900">{{ auth()->user()->name }}</span>
                        </div>
                        <span class="px-3 py-1 bg-accent-100 text-accent-800 rounded-lg text-sm font-medium">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="btn-secondary text-sm">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="container-custom section-padding-sm">
            <div class="animate-fade-in">
                <!-- Welcome Card -->
                <div class="card p-8 lg:p-10 mb-8">
                    <div class="text-center mb-8">
                        <h2 class="text-3xl lg:text-4xl font-bold text-secondary-900 mb-4">Dashboard Admin</h2>
                        <p class="text-lg text-secondary-600">Selamat datang di Sistem Manajemen Anugerah Rentcar!</p>
                        <p class="text-secondary-500 mt-2">Anda masuk sebagai: <span class="font-semibold text-accent-600">{{ auth()->user()->role }}</span></p>
                    </div>
                    
                    <!-- Feature Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                        <div class="card-hover p-6 lg:p-8 bg-gradient-to-br from-accent-50 to-accent-100 border-accent-200">
                            <div class="w-16 h-16 bg-gradient-to-r from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-secondary-900 mb-3">Manajemen Armada</h3>
                            <p class="text-secondary-700 leading-relaxed">Kelola kendaraan, perawatan, dan ketersediaan dengan sistem yang terintegrasi</p>
                        </div>
                        
                        <div class="card-hover p-6 lg:p-8 bg-gradient-to-br from-secondary-50 to-secondary-100 border-secondary-200">
                            <div class="w-16 h-16 bg-gradient-to-r from-secondary-800 to-secondary-900 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-secondary-900 mb-3">Sistem Pemesanan</h3>
                            <p class="text-secondary-700 leading-relaxed">Tangani reservasi dan pemesanan pelanggan dengan efisien dan akurat</p>
                        </div>
                        
                        <div class="card-hover p-6 lg:p-8 bg-gradient-to-br from-accent-50 to-accent-100 border-accent-200 md:col-span-2 lg:col-span-1">
                            <div class="w-16 h-16 bg-gradient-to-r from-accent-400 to-accent-500 rounded-2xl flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-semibold text-secondary-900 mb-3">Laporan & Analitik</h3>
                            <p class="text-secondary-700 leading-relaxed">Buat laporan komprehensif dan lihat wawasan bisnis untuk pengambilan keputusan</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                    <div class="card p-6 text-center">
                        <div class="text-3xl font-bold text-accent-500 mb-2">24</div>
                        <div class="text-secondary-600 text-sm">Kendaraan Aktif</div>
                    </div>
                    <div class="card p-6 text-center">
                        <div class="text-3xl font-bold text-accent-500 mb-2">12</div>
                        <div class="text-secondary-600 text-sm">Pemesanan Hari Ini</div>
                    </div>
                    <div class="card p-6 text-center">
                        <div class="text-3xl font-bold text-accent-500 mb-2">156</div>
                        <div class="text-secondary-600 text-sm">Total Pelanggan</div>
                    </div>
                    <div class="card p-6 text-center">
                        <div class="text-3xl font-bold text-accent-500 mb-2">98%</div>
                        <div class="text-secondary-600 text-sm">Tingkat Kepuasan</div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>