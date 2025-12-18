<x-public-layout>
    <div class="bg-white min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-r from-accent-500 to-accent-600 text-white">
            <div class="container-custom section-padding-sm">
                <div class="animate-fade-in">
                    <h1 class="heading-lg text-white mb-4">Selamat datang kembali, {{ auth('customer')->user()->name }}!</h1>
                    <p class="text-xl text-accent-100">Kelola pemesanan dan informasi akun Anda</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="container-custom section-padding-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12 animate-fade-in">
                <!-- Total Bookings -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-accent-500 to-accent-600 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Pemesanan</p>
                            <p class="text-3xl font-bold text-secondary-900">{{ $stats['total_bookings'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Active Bookings -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-secondary-700 to-secondary-800 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Pemesanan Aktif</p>
                            <p class="text-3xl font-bold text-secondary-900">{{ $stats['active_bookings'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Completed Bookings -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-accent-400 to-accent-500 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Selesai</p>
                            <p class="text-3xl font-bold text-secondary-900">{{ $stats['completed_bookings'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Total Spent -->
                <div class="card p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-gradient-to-r from-secondary-600 to-secondary-700 rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-secondary-600">Total Pengeluaran</p>
                            <p class="text-3xl font-bold text-secondary-900">Rp {{ number_format($stats['total_spent'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Recent Bookings -->
                <div class="lg:col-span-2">
                    <div class="card">
                        <div class="px-6 py-5 border-b border-secondary-100">
                            <h3 class="heading-sm">Pemesanan Terbaru</h3>
                        </div>
                        <div class="p-6">
                            @if($recentBookings->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recentBookings as $booking)
                                        <div class="flex items-center justify-between p-4 border border-secondary-200 rounded-xl hover:shadow-soft transition-all duration-200">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    @if($booking->car->photo_front)
                                                        <img class="h-14 w-14 rounded-xl object-cover" src="{{ asset('storage/' . $booking->car->photo_front) }}" alt="{{ $booking->car->brand }} {{ $booking->car->model }}">
                                                    @else
                                                        <div class="h-14 w-14 bg-secondary-100 rounded-xl flex items-center justify-center">
                                                            <svg class="w-7 h-7 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                                                <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                                <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-semibold text-secondary-900">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                                    <p class="text-sm text-secondary-600">{{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}</p>
                                                </div>
                                            </div>
                                            <div class="text-right">
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                                    @if($booking->booking_status === 'active') bg-accent-100 text-accent-800
                                                    @elseif($booking->booking_status === 'completed') bg-secondary-100 text-secondary-800
                                                    @elseif($booking->booking_status === 'pending') bg-accent-50 text-accent-700
                                                    @else bg-secondary-100 text-secondary-700 @endif">
                                                    {{ ucfirst($booking->booking_status) }}
                                                </span>
                                                <p class="font-bold text-secondary-900 mt-2">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-6">
                                    <a href="{{ route('customer.bookings') }}" class="text-accent-600 hover:text-accent-500 font-semibold transition-colors">
                                        Lihat semua pemesanan →
                                    </a>
                                </div>
                            @else
                                <div class="text-center py-16">
                                    <div class="w-20 h-20 bg-secondary-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-10 h-10 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                    </div>
                                    <h3 class="heading-sm mb-3">Belum ada pemesanan</h3>
                                    <p class="text-secondary-600 mb-8">Mulai dengan memesan kendaraan pertama Anda.</p>
                                    <a href="{{ route('vehicles.catalog') }}" class="btn-primary">
                                        Lihat Kendaraan
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="lg:col-span-1">
                    <div class="card p-6">
                        <h3 class="heading-sm mb-6">Aksi Cepat</h3>
                        <div class="space-y-4">
                            <a href="{{ route('vehicles.catalog') }}" class="btn-primary w-full text-center">
                                Pesan Kendaraan Baru
                            </a>
                            <a href="{{ route('customer.bookings') }}" class="btn-outline w-full text-center">
                                Lihat Pemesanan Saya
                            </a>
                            <a href="{{ route('customer.profile') }}" class="btn-outline w-full text-center">
                                Edit Profil
                            </a>
                            <a href="{{ route('customer.support') }}" class="btn-outline w-full text-center">
                                Hubungi Dukungan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>