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
    <body class="font-sans antialiased bg-white">
        <!-- Navigation -->
        <nav class="bg-white/95 backdrop-blur-sm shadow-soft border-b border-secondary-100 fixed w-full z-50">
            <div class="container-custom">
                <div class="flex justify-between h-16 lg:h-20">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <a href="{{ route('home') }}" class="flex items-center group">
                                <div class="w-10 h-10 lg:w-12 lg:h-12 bg-gradient-to-r from-accent-500 to-accent-600 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform duration-200">
                                    <svg class="w-6 h-6 lg:w-7 lg:h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                    </svg>
                                </div>
                                <span class="ml-3 text-xl lg:text-2xl font-bold text-secondary-900">Anugerah Rentcar</span>
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden lg:ml-10 lg:flex lg:space-x-8">
                            <a href="#home" class="nav-link-active">
                                Beranda
                            </a>
                            <a href="{{ route('vehicles.catalog') }}" class="nav-link">
                                Kendaraan
                            </a>
                            <a href="#about" class="nav-link">
                                Tentang Kami
                            </a>
                            <a href="#contact" class="nav-link">
                                Kontak
                            </a>
                        </div>
                    </div>

                    <!-- Right side navigation -->
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="nav-link">
                                    Dasbor
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="nav-link hidden sm:block">
                                    Masuk
                                </a>
                                <a href="{{ route('customer.register') }}" class="btn-primary text-sm">
                                    Daftar
                                </a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="relative bg-white pt-16 lg:pt-20">
            <div class="container-custom section-padding">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                    <!-- Hero Content -->
                    <div class="text-center lg:text-left animate-fade-in">
                        <h1 class="heading-xl mb-6">
                            <span class="text-white">Temukan Mobil Rental</span>
                            <span class="text-gradient">Terbaik Anda</span>
                        </h1>
                        <p class="text-body mb-8 max-w-lg mx-auto lg:mx-0">
                            Layanan rental mobil terpercaya, terjangkau, dan nyaman untuk semua kebutuhan transportasi Anda
                        </p>
                        
                        <!-- CTA Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start mb-12">
                            <a href="{{ route('vehicles.catalog') }}" class="btn-primary">
                                Jelajahi Kendaraan
                            </a>
                            <a href="#about" class="btn-outline">
                                Pelajari Lebih Lanjut
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="grid grid-cols-3 gap-6 max-w-md mx-auto lg:mx-0">
                            <div class="text-center lg:text-left">
                                <div class="text-2xl lg:text-3xl font-bold text-accent-500 mb-1">500+</div>
                                <div class="text-sm text-secondary-600">Pelanggan Puas</div>
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="text-2xl lg:text-3xl font-bold text-accent-500 mb-1">50+</div>
                                <div class="text-sm text-secondary-600">Armada Kendaraan</div>
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="text-2xl lg:text-3xl font-bold text-accent-500 mb-1">24/7</div>
                                <div class="text-sm text-secondary-600">Layanan Support</div>
                            </div>
                        </div>
                    </div>

                    <!-- Hero Image/Search Card -->
                    <div class="animate-slide-up">
                        <div class="card p-6 lg:p-8">
                            <h3 class="heading-sm mb-6 text-center">Cari Kendaraan</h3>
                            <div class="space-y-4">
                                <div>
                                    <label class="form-label">Tanggal Mulai</label>
                                    <input type="date" class="form-input">
                                </div>
                                <div>
                                    <label class="form-label">Tanggal Selesai</label>
                                    <input type="date" class="form-input">
                                </div>
                                <div>
                                    <label class="form-label">Jenis Mobil</label>
                                    <select class="form-input">
                                        <option>Semua Jenis</option>
                                        <option>Sedan</option>
                                        <option>SUV</option>
                                        <option>MPV</option>
                                        <option>Hatchback</option>
                                    </select>
                                </div>
                                <a href="{{ route('vehicles.catalog') }}" class="btn-primary w-full text-center">
                                    Cari Mobil
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="section-padding bg-white">
            <div class="container-custom">
                <div class="text-center mb-16">
                    <h2 class="heading-lg mb-6">Mengapa Memilih Anugerah Rentcar?</h2>
                    <p class="text-body max-w-2xl mx-auto">Kami memberikan pengalaman rental mobil terbaik dengan fitur-fitur unggulan</p>
                </div>

                <div class="grid-responsive">
                    <!-- Feature 1 -->
                    <div class="card-hover p-8 text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="heading-sm mb-4">Kendaraan Berkualitas</h3>
                        <p class="text-secondary-600 leading-relaxed">Mobil terawat dan rutin diservis untuk keamanan dan kenyamanan Anda</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="card-hover p-8 text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="heading-sm mb-4">Harga Kompetitif</h3>
                        <p class="text-secondary-600 leading-relaxed">Harga transparan tanpa biaya tersembunyi. Diskon khusus untuk member</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="card-hover p-8 text-center">
                        <div class="w-20 h-20 bg-gradient-to-r from-accent-500 to-accent-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <h3 class="heading-sm mb-4">Layanan 24/7</h3>
                        <p class="text-secondary-600 leading-relaxed">Dukungan pelanggan sepanjang waktu untuk bantuan yang Anda butuhkan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Popular Vehicles Section -->
        <section class="section-padding bg-secondary-50">
            <div class="container-custom">
                <div class="text-center mb-16">
                    <h2 class="heading-lg mb-6">Mobil Populer</h2>
                    <p class="text-body max-w-2xl mx-auto">Pilih dari berbagai koleksi mobil rental berkualitas kami</p>
                </div>

                <div class="grid-responsive">
                    <!-- Sample Vehicle Cards -->
                    <div class="card-hover overflow-hidden">
                        <div class="h-48 sm:h-56 bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="heading-sm mb-3">Toyota Avanza</h3>
                            <p class="text-secondary-600 mb-4 leading-relaxed">MPV 7 seater yang nyaman untuk keluarga</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl sm:text-3xl font-bold text-accent-500">Rp 350K</span>
                                <span class="text-secondary-500 text-sm">/hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-hover overflow-hidden">
                        <div class="h-48 sm:h-56 bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="heading-sm mb-3">Honda Brio</h3>
                            <p class="text-secondary-600 mb-4 leading-relaxed">Hatchback irit dan lincah untuk dalam kota</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl sm:text-3xl font-bold text-accent-500">Rp 250K</span>
                                <span class="text-secondary-500 text-sm">/hari</span>
                            </div>
                        </div>
                    </div>

                    <div class="card-hover overflow-hidden">
                        <div class="h-48 sm:h-56 bg-gradient-to-br from-secondary-100 to-secondary-200 flex items-center justify-center">
                            <svg class="w-16 h-16 sm:w-20 sm:h-20 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="heading-sm mb-3">Toyota Innova</h3>
                            <p class="text-secondary-600 mb-4 leading-relaxed">MPV premium untuk perjalanan jauh</p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl sm:text-3xl font-bold text-accent-500">Rp 450K</span>
                                <span class="text-secondary-500 text-sm">/hari</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-8">
                    <a href="{{ route('vehicles.catalog') }}" class="btn-primary">
                        Lihat Semua Kendaraan
                    </a>
                </div>
            </div>
        </section>

        <!-- How It Works Section -->
        <section class="section-padding bg-white">
            <div class="container-custom">
                <div class="text-center mb-16">
                    <h2 class="heading-lg mb-6">Cara Kerja</h2>
                    <p class="text-body max-w-2xl mx-auto">Langkah mudah untuk mendapatkan mobil rental Anda</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-accent-500 to-accent-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-xl font-bold shadow-soft">
                            1
                        </div>
                        <h3 class="heading-sm mb-4">Cari & Pilih</h3>
                        <p class="text-secondary-600 leading-relaxed">Jelajahi kendaraan yang tersedia dan pilih mobil yang sesuai kebutuhan</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-accent-500 to-accent-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-xl font-bold shadow-soft">
                            2
                        </div>
                        <h3 class="heading-sm mb-4">Pesan Online</h3>
                        <p class="text-secondary-600 leading-relaxed">Lengkapi pemesanan dengan sistem reservasi online yang aman</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-accent-500 to-accent-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-xl font-bold shadow-soft">
                            3
                        </div>
                        <h3 class="heading-sm mb-4">Verifikasi Dokumen</h3>
                        <p class="text-secondary-600 leading-relaxed">Upload KTP dan SIM Anda untuk proses verifikasi</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="w-16 h-16 bg-gradient-to-r from-accent-500 to-accent-600 text-white rounded-2xl flex items-center justify-center mx-auto mb-6 text-xl font-bold shadow-soft">
                            4
                        </div>
                        <h3 class="heading-sm mb-4">Ambil & Pergi</h3>
                        <p class="text-secondary-600 leading-relaxed">Ambil kendaraan Anda dan nikmati perjalanan</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="section-padding bg-secondary-50">
            <div class="container-custom">
                <div class="grid-2-col items-center">
                    <div class="animate-fade-in">
                        <h2 class="heading-lg mb-6">Tentang Anugerah Rentcar</h2>
                        <p class="text-body mb-8">
                            Anugerah Rentcar adalah penyedia layanan rental mobil terpercaya yang telah melayani ribuan pelanggan dengan kepuasan tinggi. Kami berkomitmen memberikan pengalaman rental yang mudah, aman, dan nyaman.
                        </p>
                        <div class="grid grid-cols-2 gap-6">
                            <div class="text-center lg:text-left">
                                <div class="text-3xl lg:text-4xl font-bold text-accent-500 mb-2">500+</div>
                                <div class="text-secondary-600">Pelanggan Puas</div>
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="text-3xl lg:text-4xl font-bold text-accent-500 mb-2">50+</div>
                                <div class="text-secondary-600">Armada Kendaraan</div>
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="text-3xl lg:text-4xl font-bold text-accent-500 mb-2">24/7</div>
                                <div class="text-secondary-600">Layanan Support</div>
                            </div>
                            <div class="text-center lg:text-left">
                                <div class="text-3xl lg:text-4xl font-bold text-accent-500 mb-2">5+</div>
                                <div class="text-secondary-600">Tahun Pengalaman</div>
                            </div>
                        </div>
                    </div>
                    <div class="card p-8 lg:p-10 text-center animate-slide-up">
                        <div class="w-24 h-24 lg:w-32 lg:h-32 bg-gradient-to-br from-accent-100 to-accent-200 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-12 h-12 lg:w-16 lg:h-16 text-accent-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                            </svg>
                        </div>
                        <h3 class="heading-sm mb-4">Misi Kami</h3>
                        <p class="text-secondary-600 leading-relaxed">Memberikan solusi transportasi terbaik dengan layanan yang profesional dan harga yang terjangkau untuk semua kalangan.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="section-padding bg-gradient-to-r from-accent-500 to-accent-600 text-white">
            <div class="container-custom text-center">
                <div class="animate-fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-6">Siap Memulai Perjalanan Anda?</h2>
                    <p class="text-xl mb-8 text-accent-100 max-w-2xl mx-auto">Bergabunglah dengan ribuan pelanggan yang mempercayai kami untuk kebutuhan transportasi mereka</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('vehicles.catalog') }}" class="bg-primary-500 text-accent-600 px-8 py-4 rounded-xl font-semibold hover:bg-primary-200 transition-all duration-200 shadow-soft hover:shadow-medium">
                            Jelajahi Kendaraan
                        </a>
                        @if (Route::has('customer.register'))
                            <a href="{{ route('customer.register') }}" class="border-2 border-primary-500 text-primary-500 px-8 py-4 rounded-xl font-semibold hover:bg-primary-500 hover:text-accent-600 transition-all duration-200">
                                Daftar Sekarang
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="section-padding bg-secondary-900 text-white">
            <div class="container-custom">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
                    <!-- Company Info -->
                    <div class="col-span-1 md:col-span-2">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 bg-gradient-to-r from-accent-500 to-accent-600 rounded-xl flex items-center justify-center">
                                <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            </div>
                            <span class="ml-4 text-2xl font-bold">Anugerah Rentcar</span>
                        </div>
                        <p class="text-secondary-300 mb-6 leading-relaxed text-lg">
                            Partner terpercaya Anda untuk layanan rental mobil yang handal dan terjangkau. 
                            Kami menyediakan kendaraan berkualitas untuk semua kebutuhan transportasi Anda.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-secondary-800 hover:bg-accent-500 rounded-xl flex items-center justify-center transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-secondary-800 hover:bg-accent-500 rounded-xl flex items-center justify-center transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-secondary-800 hover:bg-accent-500 rounded-xl flex items-center justify-center transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C18.396 0 22.025 4.13 22.025 9.281 22.025 14.432 18.396 18.562 12.017 18.562c-6.379 0-10.008-4.13-10.008-9.281C2.009 4.13 5.638.001 12.017.001zM8.5 4.5a3.5 3.5 0 11-7 0 3.5 3.5 0 017 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6">Tautan Cepat</h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('vehicles.catalog') }}" class="text-secondary-300 hover:text-accent-400 transition-colors">Jelajahi Kendaraan</a></li>
                            <li><a href="#" class="text-secondary-300 hover:text-accent-400 transition-colors">Harga</a></li>
                            <li><a href="#" class="text-secondary-300 hover:text-accent-400 transition-colors">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="text-secondary-300 hover:text-accent-400 transition-colors">FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6">Hubungi Kami</h3>
                        <ul class="space-y-4 text-secondary-300">
                            <li class="flex items-center">
                                <div class="w-8 h-8 bg-secondary-800 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                Jakarta, Indonesia
                            </li>
                            <li class="flex items-center">
                                <div class="w-8 h-8 bg-secondary-800 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                +62 123 456 789
                            </li>
                            <li class="flex items-center">
                                <div class="w-8 h-8 bg-secondary-800 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                info@anugerahrentcar.com
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-secondary-800 mt-12 pt-8 text-center text-secondary-400">
                    <p>&copy; {{ date('Y') }} Anugerah Rentcar. Semua hak dilindungi.</p>
                </div>
            </div>
        </section>

        @livewireScripts
        <script src="//unpkg.com/alpinejs" defer></script>
    </body>
</html>
