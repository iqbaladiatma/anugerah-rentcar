<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Anugerah Rentcar') }} - Rental Mobil Terpercaya</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('ini.jpg') }}">
        <link rel="apple-touch-icon" href="{{ asset('ini.jpg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireStyles
    </head>
    <body class="font-sans antialiased bg-white">
        <!-- Navigation -->
        <nav class="bg-white shadow-soft border-b border-secondary-100 sticky top-0 z-50 backdrop-blur-sm bg-white/95">
            <div class="container-custom px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-14 sm:h-16 lg:h-20">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center group">
                            <img 
                                src="{{ asset('ini.jpg') }}" 
                                alt="Anugerah Rentcar Logo" 
                                class="w-10 h-10 lg:w-12 lg:h-12 min-w-[40px] min-h-[40px] lg:min-w-[48px] lg:min-h-[48px] object-contain rounded-xl group-hover:scale-105 transition-transform duration-200 flex-shrink-0"
                            >
                            <span class="ml-3 text-lg lg:text-2xl font-bold text-secondary-900">Anugerah Rentcar</span>
                        </a>
                    </div>

                    <!-- Desktop Navigation Links -->
                    <div class="hidden lg:flex lg:items-center lg:ml-10 lg:space-x-8">
                        @auth('customer')
                            <a href="{{ route('customer.dashboard') }}" class="{{ request()->routeIs('customer.dashboard') ? 'nav-link-active' : 'nav-link' }}">
                                Dashboard
                            </a>
                            <a href="{{ route('customer.bookings') }}" class="{{ request()->routeIs('customer.bookings*') ? 'nav-link-active' : 'nav-link' }}">
                                Pemesanan Saya
                            </a>
                            <a href="{{ route('vehicles.catalog') }}" class="{{ request()->routeIs('vehicles.*') ? 'nav-link-active' : 'nav-link' }}">
                                Kendaraan
                            </a>
                        @else
                            <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'nav-link-active' : 'nav-link' }}">
                                Beranda
                            </a>
                            <a href="{{ route('vehicles.catalog') }}" class="{{ request()->routeIs('vehicles.*') ? 'nav-link-active' : 'nav-link' }}">
                                Kendaraan
                            </a>
                            <a href="{{ route('home') }}#about" class="nav-link">
                                Tentang Kami
                            </a>
                            <a href="{{ route('home') }}#contact" class="nav-link">
                                Kontak
                            </a>
                        @endauth
                    </div>

                    <!-- Right side navigation (Desktop only) -->
                    <div class="hidden lg:flex lg:items-center lg:space-x-4">
                        @auth('customer')
                            <!-- Customer is logged in -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center text-sm font-medium text-secondary-700 hover:text-accent-500 focus:outline-none focus:text-accent-500 transition-colors px-3 py-2 rounded-lg hover:bg-primary-200">
                                    <span class="hidden sm:block">{{ auth('customer')->user()->name }}</span>
                                    <span class="sm:hidden">Menu</span>
                                    <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                    </svg>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-primary-500 rounded-xl shadow-medium py-2 z-50 border border-secondary-100">
                                    <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                        Dashboard
                                    </a>
                                    <a href="{{ route('customer.bookings') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                        Pemesanan Saya
                                    </a>
                                    <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                        Profil
                                    </a>
                                    <div class="border-t border-secondary-100 my-2"></div>
                                    <form method="POST" action="{{ route('customer.logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-secondary-700 hover:bg-primary-200 hover:text-accent-500 transition-colors">
                                            Keluar
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <!-- Customer is not logged in -->
                            <a href="{{ route('login') }}" class="nav-link">
                                Masuk
                            </a>
                            <a href="{{ route('customer.register') }}" class="btn-primary text-sm">
                                Daftar
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>


        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-secondary-900 text-primary-500">
            <div class="container-custom section-padding">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12">
                    <!-- Company Info -->
                    <div class="col-span-1 lg:col-span-2">
                        <div class="flex items-center mb-6">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center">
                                <img 
                                    src="{{ asset('ini.jpg') }}" 
                                    alt="Anugerah Rentcar Logo" 
                                    class="w-10 h-10 lg:w-12 lg:h-12 min-w-[40px] min-h-[40px] lg:min-w-[48px] lg:min-h-[48px] object-contain rounded-xl group-hover:scale-105 transition-transform duration-200 flex-shrink-0"
                                >
                            </div>
                            <span class="ml-4 text-2xl font-bold">Anugerah Rentcar</span>
                        </div>
                        <p class="text-secondary-300 mb-6 text-lg leading-relaxed max-w-md">
                            Partner terpercaya Anda untuk layanan rental mobil yang handal dan terjangkau. 
                            Kami menyediakan kendaraan berkualitas untuk semua kebutuhan transportasi Anda.
                        </p>
                        <div class="flex space-x-4">
                            <a href="#" class="w-10 h-10 bg-secondary-800 hover:bg-accent-500 rounded-lg flex items-center justify-center text-secondary-400 hover:text-white transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-secondary-800 hover:bg-accent-500 rounded-lg flex items-center justify-center text-secondary-400 hover:text-white transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                                </svg>
                            </a>
                            <a href="#" class="w-10 h-10 bg-secondary-800 hover:bg-accent-500 rounded-lg flex items-center justify-center text-secondary-400 hover:text-white transition-all duration-200">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.017 0C5.638 0 .455 5.183.455 11.563c0 5.101 3.301 9.441 7.888 10.98.577-.105 1.135-.235 1.675-.39-.105-.301-.196-.617-.277-.946-.569-.02-1.135-.089-1.69-.207-2.677-1.99-4.411-5.136-4.411-8.68 0-6.116 4.963-11.079 11.079-11.079s11.079 4.963 11.079 11.079c0 3.544-1.734 6.69-4.411 8.68-.555.118-1.121.187-1.69.207-.081.329-.172.645-.277.946.54.155 1.098.285 1.675.39 4.587-1.539 7.888-5.879 7.888-10.98C23.579 5.183 18.396 0 12.017 0z"/>
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6 text-primary-500">Tautan Cepat</h3>
                        <ul class="space-y-3">
                            <li><a href="{{ route('vehicles.catalog') }}" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">Jelajahi Kendaraan</a></li>
                            <li><a href="#" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">Harga</a></li>
                            <li><a href="#" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">Syarat & Ketentuan</a></li>
                            <li><a href="#" class="text-secondary-300 hover:text-accent-500 transition-colors text-base">FAQ</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="text-xl font-semibold mb-6 text-primary-500">Hubungi Kami</h3>
                        <ul class="space-y-4 text-secondary-300">
                            <li class="flex items-start">
                                <div class="w-5 h-5 mt-0.5 mr-3 text-accent-500 flex-shrink-0">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <span class="text-base">Blora, Jawa Tengah</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-5 h-5 mt-0.5 mr-3 text-accent-500 flex-shrink-0">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                                    </svg>
                                </div>
                                <span class="text-base">+62 897-7777-451</span>
                            </li>
                            <li class="flex items-start">
                                <div class="w-5 h-5 mt-0.5 mr-3 text-accent-500 flex-shrink-0">
                                    <svg fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                                    </svg>
                                </div>
                                <span class="text-base">info@anugerahrentcar.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="border-t border-secondary-800 mt-12 pt-8 text-center">
                    <p class="text-secondary-400 text-base">&copy; {{ date('Y') }} Anugerah Rentcar. Semua hak dilindungi.</p>
                </div>
            </div>
        </footer>

        <x-customer-bottom-nav-test />
        
        @guest('customer')
            <x-guest-bottom-nav />
        @endguest

        @livewireScripts
        <script src="//unpkg.com/alpinejs" defer></script>
        @stack('scripts')
    </body>
</html>