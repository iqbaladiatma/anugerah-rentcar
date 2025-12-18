<x-public-layout>
    <div class="bg-white min-h-screen">
        <!-- Header -->
        <div class="bg-gradient-to-r from-accent-500 to-accent-600 text-white">
            <div class="container-custom section-padding-sm">
                <div class="animate-fade-in">
                    <h1 class="heading-lg text-white mb-4">Pesanan Saya</h1>
                    <p class="text-xl text-accent-100">Lihat dan kelola pemesanan sewa Anda</p>
                </div>
            </div>
        </div>

        <div class="container-custom section-padding-sm">
            @if($bookings->count() > 0)
                <div class="space-y-6 animate-fade-in">
                    @foreach($bookings as $booking)
                        <div class="card-hover">
                            <div class="p-6 lg:p-8">
                                <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                                    <div>
                                        <h3 class="heading-sm text-secondary-900 mb-2">
                                            Pemesanan #{{ $booking->booking_number }}
                                        </h3>
                                        <p class="text-secondary-600">
                                            Dipesan pada {{ $booking->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                    <span class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-semibold
                                        @if($booking->booking_status === 'active') badge-success
                                        @elseif($booking->booking_status === 'completed') badge-info
                                        @elseif($booking->booking_status === 'pending') badge-warning
                                        @elseif($booking->booking_status === 'confirmed') badge-success
                                        @else badge-info @endif">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                    <!-- Vehicle Info -->
                                    <div class="flex items-center space-x-4">
                                        @if($booking->car->photo_front)
                                            <img class="h-20 w-20 rounded-xl object-cover shadow-soft" 
                                                 src="{{ asset('storage/' . $booking->car->photo_front) }}" 
                                                 alt="{{ $booking->car->brand }} {{ $booking->car->model }}">
                                        @else
                                            <div class="h-20 w-20 bg-secondary-100 rounded-xl flex items-center justify-center">
                                                <svg class="w-10 h-10 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <h4 class="font-medium text-gray-900">
                                                {{ $booking->car->brand }} {{ $booking->car->model }}
                                            </h4>
                                            <p class="text-sm text-gray-500">{{ $booking->car->year }} • {{ $booking->car->license_plate }}</p>
                                        </div>
                                    </div>

                                    <!-- Booking Details -->
                                    <div class="space-y-2">
                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-gray-600">
                                                {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <div class="flex items-center text-sm">
                                            <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="text-gray-600">{{ $booking->pickup_location }}</span>
                                        </div>
                                        @if($booking->with_driver)
                                            <div class="flex items-center text-sm">
                                                <svg class="w-4 h-4 text-gray-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-gray-600">Dengan Sopir</span>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Pricing -->
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-gray-900">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            Pembayaran: 
                                            <span class="font-medium
                                                @if($booking->payment_status === 'paid') text-green-600
                                                @elseif($booking->payment_status === 'partial') text-yellow-600
                                                @else text-red-600 @endif">
                                                {{ ucfirst($booking->payment_status) }}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                @if($booking->notes)
                                    <div class="mt-4 p-3 bg-gray-50 rounded-md">
                                        <p class="text-sm text-gray-600">
                                            <strong>Catatan:</strong> {{ $booking->notes }}
                                        </p>
                                    </div>
                                @endif

                                <!-- Actions -->
                                <div class="mt-6 flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        Durasi: {{ $booking->start_date->diffInDays($booking->end_date) }} hari
                                    </div>
                                    <div class="flex space-x-3">
                                        @if($booking->canBeCancelled())
                                            <form method="POST" action="{{ route('customer.bookings.cancel', $booking) }}" 
                                                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')" 
                                                  class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="cancellation_reason" value="Cancelled by customer">
                                                <button type="submit" class="text-red-600 hover:text-red-500 text-sm font-medium">
                                                    Batalkan Pemesanan
                                                </button>
                                            </form>
                                        @endif
                                        @if($booking->canBeModified())
                                            <a href="{{ route('customer.bookings.edit', $booking) }}" 
                                               class="text-yellow-600 hover:text-yellow-500 text-sm font-medium">
                                                Ubah
                                            </a>
                                        @endif
                                        @if(in_array($booking->booking_status, ['confirmed', 'active']))
                                            <a href="{{ route('customer.bookings.ticket', $booking) }}" 
                                               class="text-green-600 hover:text-green-500 text-sm font-medium">
                                                E-Tiket
                                            </a>
                                        @endif
                                        <a href="{{ route('customer.bookings.show', $booking) }}" 
                                           class="text-accent-600 hover:text-accent-500 text-sm font-medium">
                                            Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada pesanan</h3>
                    <p class="mt-1 text-sm text-gray-500">Mulai dengan memesan kendaraan pertama Anda.</p>
                    <div class="mt-6">
                        <a href="{{ route('vehicles.catalog') }}" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-accent-500 hover:bg-accent-600">
                            Jelajahi Kendaraan
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>