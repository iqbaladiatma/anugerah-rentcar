<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    @php
        $settings = \App\Models\Setting::current();
    @endphp
    
    @if($settings->company_logo)
        <link rel="icon" type="image/png" href="{{ asset('storage/' . $settings->company_logo) }}">
    @else
        <link rel="icon" type="image/jpeg" href="{{ asset('logo.jpg') }}">
    @endif

    <title>{{ $title ?? ($settings->company_name ?? 'Anugerah Rentcar') . ' - Rental Mobil Terpercaya' }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center overflow-hidden {{ $settings->company_logo ? 'bg-white' : 'bg-blue-600' }}">
                            @if($settings->company_logo)
                                <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="{{ $settings->company_name }} Logo" class="h-full w-full object-contain">
                            @else
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            @endif
                        </div>
                        <span class="text-xl font-bold text-gray-900">{{ $settings->company_name ?? 'Anugerah Rentcar' }}</span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Home</a>
                    <a href="{{ route('vehicles.catalog') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Vehicles</a>
                    <a href="#about" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">About</a>
                    <a href="#contact" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Contact</a>
                </div>

                <!-- Auth Links -->
                <div class="hidden md:flex items-center space-x-4">
                    @auth('customer')
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-blue-600 font-medium">
                                <span>{{ auth('customer')->user()->name }}</span>
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Dashboard</a>
                                <a href="{{ route('customer.bookings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Bookings</a>
                                <a href="{{ route('customer.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">Login</a>
                        <a href="{{ route('customer.register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition-colors">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden">
                    <button x-data @click="$dispatch('toggle-mobile-menu')" class="text-gray-700 hover:text-blue-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-transition class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="{{ route('vehicles.catalog') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Vehicles</a>
                <a href="#about" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">About</a>
                <a href="#contact" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Contact</a>
                
                @auth('customer')
                    <div class="border-t pt-2 mt-2">
                        <a href="{{ route('customer.dashboard') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Dashboard</a>
                        <a href="{{ route('customer.bookings') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">My Bookings</a>
                        <a href="{{ route('customer.profile') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Profile</a>
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Logout</button>
                        </form>
                    </div>
                @else
                    <div class="border-t pt-2 mt-2">
                        <a href="{{ route('login') }}" class="block px-3 py-2 text-gray-700 hover:text-blue-600 font-medium">Login</a>
                        <a href="{{ route('customer.register') }}" class="block px-3 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 mx-3">Daftar</a>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Customer Sidebar (Mobile Only - for authenticated customers) -->
    @auth('customer')
        <livewire:layout.customer-sidebar />
    @endauth

    <!-- Main Content -->
    <main class="pb-20 lg:pb-0">
        {{ $slot }}
    </main>

    <!-- Customer Bottom Navigation (Mobile Only - for authenticated customers) -->
    @auth('customer')
        <livewire:layout.customer-bottom-nav />
    @endauth

    <!-- Footer -->
    <footer class="bg-gray-900 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div class="col-span-1 md:col-span-2">
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center overflow-hidden {{ $settings->company_logo ? 'bg-white' : 'bg-blue-600' }}">
                            @if($settings->company_logo)
                                <img src="{{ asset('storage/' . $settings->company_logo) }}" alt="{{ $settings->company_name }} Logo" class="h-full w-full object-contain">
                            @else
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                </svg>
                            @endif
                        </div>
                        <span class="text-xl font-bold">{{ $settings->company_name ?? 'Anugerah Rentcar' }}</span>
                    </div>
                    <p class="text-gray-300 mb-4">Mitra terpercaya untuk layanan rental mobil yang berkualitas dan terjangkau. Kami menyediakan kendaraan berkualitas dengan pelayanan pelanggan yang prima.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M22.46 6c-.77.35-1.6.58-2.46.69.88-.53 1.56-1.37 1.88-2.38-.83.5-1.75.85-2.72 1.05C18.37 4.5 17.26 4 16 4c-2.35 0-4.27 1.92-4.27 4.29 0 .34.04.67.11.98C8.28 9.09 5.11 7.38 3 4.79c-.37.63-.58 1.37-.58 2.15 0 1.49.75 2.81 1.91 3.56-.71 0-1.37-.2-1.95-.5v.03c0 2.08 1.48 3.82 3.44 4.21a4.22 4.22 0 0 1-1.93.07 4.28 4.28 0 0 0 4 2.98 8.521 8.521 0 0 1-5.33 1.84c-.34 0-.68-.02-1.02-.06C3.44 20.29 5.7 21 8.12 21 16 21 20.33 14.46 20.33 8.79c0-.19 0-.37-.01-.56.84-.6 1.56-1.36 2.14-2.23z"/>
                            </svg>
                        </a>
                        <a href="#" class="text-gray-300 hover:text-white">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="text-gray-300 hover:text-white">Home</a></li>
                        <li><a href="{{ route('vehicles.catalog') }}" class="text-gray-300 hover:text-white">Vehicles</a></li>
                        <li><a href="{{ route('terms') }}" class="text-gray-300 hover:text-white">Syarat & Ketentuan</a></li>
                        <li><a href="#about" class="text-gray-300 hover:text-white">About Us</a></li>
                        <li><a href="#contact" class="text-gray-300 hover:text-white">Contact</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Info</h3>
                    <ul class="space-y-2 text-gray-300">
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                            </svg>
                            <span>{{ $settings->company_address ?? 'Jl. Raya Utama No. 123, Jakarta' }}</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"/>
                            </svg>
                            <span>{{ $settings->company_phone ?? '+62 21 1234 5678' }}</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
                            </svg>
                            <span>info@anugerahrentcar.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-300">
                <p>&copy; {{ date('Y') }} {{ $settings->company_name ?? 'Anugerah Rentcar' }}. All rights reserved.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
    <script src="//unpkg.com/alpinejs" defer></script>
</body>
</html>