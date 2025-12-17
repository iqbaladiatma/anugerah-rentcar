<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Anugerah Rentcar') }} - Rental Mobil Terpercaya</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg fixed w-full z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}" class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-r from-blue-600 to-blue-800 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 text-xl font-bold text-gray-900">Anugerah Rentcar</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden md:ml-10 md:flex md:space-x-8">
                            <a href="#home" class="text-blue-600 hover:text-blue-800 px-3 py-2 text-sm font-medium transition-colors">
                                Beranda
                            </a>
                            <a href="{{ route('vehicles.catalog') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                                Kendaraan
                            </a>
                            <a href="#about" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                                Tentang Kami
                            </a>
                            <a href="#contact" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                                Kontak
                            </a>
                        </div>
                    </div>

                    <!-- Right side navigation -->
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                                    Dasbor
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 text-sm font-medium transition-colors">
                                    Masuk
                                </a>
                                <a href="{{ route('customer.register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    Daftar
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="relative bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900 text-white pt-16">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
                <div class="text-center">
                    <h1 class="text-4xl md:text-6xl font-bold mb-6">
                        Temukan Mobil Rental
                        <span class="text-yellow-400">Terbaik Anda</span>
                    </h1>
                    <p class="text-xl md:text-2xl mb-8 text-blue-100">
                        Layanan rental mobil terpercaya, terjangkau, dan nyaman untuk semua kebutuhan Anda
                    </p>
                    
                    <!-- Quick Search -->
                    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-xl p-6 text-gray-900">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Selesai</label>
                                <input type="date" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Mobil</label>
                                <select class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option>Semua Jenis</option>
                                    <option>Sedan</option>
                                    <option>SUV</option>
                                    <option>MPV</option>
                                    <option>Hatchback</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <a href="{{ route('vehicles.catalog') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-semibold transition-colors text-center">
                                    Cari Mobil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih Anugerah Rentcar?</h2>
                    <p class="text-lg text-gray-600">Kami memberikan pengalaman rental mobil terbaik dengan fitur-fitur unggulan</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Kendaraan Berkualitas</h3>
                        <p class="text-gray-600">Mobil terawat dan rutin diservis untuk keamanan dan kenyamanan Anda</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Harga Kompetitif</h3>
                        <p class="text-gray-600">Harga transparan tanpa biaya tersembunyi. Diskon khusus untuk member</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="text-center p-6 bg-gray-50 rounded-lg">
                        <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Layanan 24/7</h3>
                        <p class="text-gray-600">Dukungan pelanggan sepanjang waktu untuk bantuan yang Anda butuhkan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Vehicles Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Mobil Populer</h2>
                    <p class="text-lg text-gray-600">Pilih dari berbagai koleksi mobil rental berkualitas kami</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Sample Vehicle Cards -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Toyota Avanza</h3>
                            <p class="text-gray-600 mb-4">MPV 7 seater yang nyaman untuk keluarga</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-blue-600">Rp 350K</span>
                                <span class="text-gray-500">/hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Honda Brio</h3>
                            <p class="text-gray-600 mb-4">Hatchback irit dan lincah untuk dalam kota</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-blue-600">Rp 250K</span>
                                <span class="text-gray-500">/hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Toyota Innova</h3>
                            <p class="text-gray-600 mb-4">MPV premium untuk perjalanan jauh</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-blue-600">Rp 450K</span>
                                <span class="text-gray-500">/hari</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('vehicles.catalog') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors">
                        Lihat Semua Kendaraan
                    </a>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="py-16 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                    <p class="text-lg text-gray-600">Langkah mudah untuk mendapatkan mobil rental Anda</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                            1
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Cari & Pilih</h3>
                        <p class="text-gray-600">Jelajahi kendaraan yang tersedia dan pilih mobil yang sesuai kebutuhan</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                            2
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Pesan Online</h3>
                        <p class="text-gray-600">Lengkapi pemesanan dengan sistem reservasi online yang aman</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                            3
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Verifikasi Dokumen</h3>
                        <p class="text-gray-600">Upload KTP dan SIM Anda untuk proses verifikasi</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="w-12 h-12 bg-blue-600 text-white rounded-full flex items-center justify-center mx-auto mb-4 text-xl font-bold">
                            4
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Ambil & Pergi</h3>
                        <p class="text-gray-600">Ambil kendaraan Anda dan nikmati perjalanan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <h2 class="text-3xl font-bold text-gray-900 mb-6">Tentang Anugerah Rentcar</h2>
                        <p class="text-lg text-gray-600 mb-6">
                            Anugerah Rentcar adalah penyedia layanan rental mobil terpercaya yang telah melayani ribuan pelanggan dengan kepuasan tinggi. Kami berkomitmen memberikan pengalaman rental yang mudah, aman, dan nyaman.
                        </p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">500+</div>
                                <div class="text-gray-600">Pelanggan Puas</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">50+</div>
                                <div class="text-gray-600">Armada Kendaraan</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">24/7</div>
                                <div class="text-gray-600">Layanan Support</div>
                            </div>
                            <div class="text-center">
                                <div class="text-3xl font-bold text-blue-600 mb-2">5+</div>
                                <div class="text-gray-600">Tahun Pengalaman</div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-blue-100 to-blue-200 rounded-lg p-8 text-center">
                        <svg class="w-32 h-32 text-blue-600 mx-auto mb-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Misi Kami</h3>
                        <p class="text-gray-600">Memberikan solusi transportasi terbaik dengan layanan yang profesional dan harga yang terjangkau untuk semua kalangan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="py-16 bg-blue-600 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <h2 class="text-3xl font-bold mb-4">Siap Memulai Perjalanan Anda?</h2>
                <p class="text-xl mb-8 text-blue-100">Bergabunglah dengan ribuan pelanggan yang mempercayai kami untuk kebutuhan transportasi mereka</p>
                <div class="space-x-4">
                    <a href="{{ route('vehicles.catalog') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors inline-block">
                        Jelajahi Kendaraan
                    </a>
                    @if (Route::has('customer.register'))
                        <a href="{{ route('customer.register') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition-colors inline-block">
                            Daftar Sekarang
                        </a>
                    @endif
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-16 bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    <!-- Company Info -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center mb-4">
                            <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            </div>
                            <span class="ml-3 text-xl font-bold">Anugerah Rentcar</span>
                        </div>
                        <p class="text-gray-300 mb-4">
                            Partner terpercaya Anda untuk layanan rental mobil yang handal dan terjangkau. 
                            Kami menyediakan kendaraan berkualitas untuk semua kebutuhan transportasi Anda.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C18.396 0 22.025 4.13 22.025 9.281 22.025 14.432 18.396 18.562 12.017 18.562c-6.379 0-10.008-4.13-10.008-9.281C2.009 4.13 5.638.001 12.017.001zM8.5 4.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Tautan Cepat</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('vehicles.catalog') }}" class="text-gray-300 hover:text-white transition-colors">Jelajahi Kendaraan</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Harga</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="text-gray-300 hover:text-white transition-colors">FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4">Hubungi Kami</h3>
                        <ul class="space-y-2 text-gray-300">
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                </svg>
                                Jakarta, Indonesia
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                </svg>
                                +62 123 456 789
                            </li>
                            <li class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                    <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                </svg>
                                info@anugerahrentcar.com
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                    <p>&copy; {{ date('Y') }} Anugerah Rentcar. Semua hak dilindungi.</p>
                </div>
            </div>
        </section>

        @livewireScripts
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>
