<!-- Payment Pending Alert -->
@if(isset($pendingPayments) && $pendingPayments->count() > 0)
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-red-50 to-orange-50 border-l-4 border-red-500 rounded-lg p-6 shadow-soft">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-red-800 mb-2">
                        ⚠️ Pembayaran Menunggu Konfirmasi
                    </h3>
                    <p class="text-sm text-red-700 mb-4">
                        Anda memiliki <strong>{{ $pendingPayments->count() }}</strong> pemesanan yang menunggu pembayaran. Segera lakukan pembayaran untuk mengkonfirmasi pemesanan Anda.
                    </p>
                    
                    <div class="space-y-3">
                        @foreach($pendingPayments as $pending)
                            <div class="bg-white rounded-lg p-4 border border-red-200">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-3 flex-1">
                                        @if($pending->car && $pending->car->photo_front)
                                            <img class="h-12 w-16 rounded object-cover flex-shrink-0" 
                                                 src="{{ asset('storage/' . $pending->car->photo_front) }}" 
                                                 alt="{{ $pending->car->brand }} {{ $pending->car->model }}">
                                        @else
                                            <div class="h-12 w-16 bg-secondary-100 rounded flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-secondary-900 truncate">
                                                {{ $pending->car ? $pending->car->brand . ' ' . $pending->car->model : 'Kendaraan' }}
                                            </p>
                                            <p class="text-sm text-secondary-600">
                                                Booking #{{ $pending->booking_number }}
                                            </p>
                                            <p class="text-xs text-secondary-500">
                                                {{ $pending->start_date->format('d M Y') }} - {{ $pending->end_date->format('d M Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right flex-shrink-0">
                                        <p class="text-lg font-bold text-red-600">
                                            Rp {{ number_format($pending->deposit_amount, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-secondary-600 mb-2">Deposit</p>
                                        <a href="{{ route('customer.bookings.payment', $pending) }}" 
                                           class="inline-block px-4 py-2 bg-gradient-to-r from-red-500 to-orange-500 text-white text-sm font-semibold rounded-lg hover:from-red-600 hover:to-orange-600 transition-all duration-200 shadow-md">
                                            💳 Bayar Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <p class="font-medium">Informasi Pembayaran:</p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Lakukan pembayaran deposit untuk mengkonfirmasi pemesanan</li>
                                    <li>Upload bukti pembayaran setelah transfer</li>
                                    <li>Admin akan memverifikasi dalam 1x24 jam</li>
                                    <li>Sisa pembayaran dibayar saat pengambilan kendaraan</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

<!-- Partial Payment Alert (Pelunasan) -->
@if(isset($partialPayments) && $partialPayments->count() > 0)
    <div class="mb-8 animate-fade-in">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border-l-4 border-blue-500 rounded-lg p-6 shadow-soft">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-8 w-8 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-blue-800 mb-2">
                        💰 Pelunasan Pembayaran
                    </h3>
                    <p class="text-sm text-blue-700 mb-4">
                        Anda memiliki <strong>{{ $partialPayments->count() }}</strong> pemesanan yang sudah dibayar deposit. Silakan lunasi pembayaran untuk menyelesaikan transaksi.
                    </p>
                    
                    <div class="space-y-3">
                        @foreach($partialPayments as $partial)
                            @php
                                $remainingAmount = $partial->total_amount - $partial->deposit_amount;
                            @endphp
                            <div class="bg-white rounded-lg p-4 border border-blue-200">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-3 flex-1">
                                        @if($partial->car && $partial->car->photo_front)
                                            <img class="h-12 w-16 rounded object-cover flex-shrink-0" 
                                                 src="{{ asset('storage/' . $partial->car->photo_front) }}" 
                                                 alt="{{ $partial->car->brand }} {{ $partial->car->model }}">
                                        @else
                                            <div class="h-12 w-16 bg-secondary-100 rounded flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-secondary-400" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                                                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                                                </svg>
                                            </div>
                                        @endif
                                        <div class="flex-1 min-w-0">
                                            <p class="font-semibold text-secondary-900 truncate">
                                                {{ $partial->car ? $partial->car->brand . ' ' . $partial->car->model : 'Kendaraan' }}
                                            </p>
                                            <p class="text-sm text-secondary-600">
                                                Booking #{{ $partial->booking_number }}
                                            </p>
                                            <p class="text-xs text-secondary-500">
                                                {{ $partial->start_date->format('d M Y') }} - {{ $partial->end_date->format('d M Y') }}
                                            </p>
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    ✓ Deposit Dibayar
                                                </span>
                                                <span class="text-xs text-secondary-600">
                                                    Rp {{ number_format($partial->deposit_amount, 0, ',', '.') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right flex-shrink-0">
                                        <p class="text-xs text-secondary-600 mb-1">Sisa Pembayaran:</p>
                                        <p class="text-lg font-bold text-blue-600">
                                            Rp {{ number_format($remainingAmount, 0, ',', '.') }}
                                        </p>
                                        <p class="text-xs text-secondary-500 mb-2">
                                            dari Rp {{ number_format($partial->total_amount, 0, ',', '.') }}
                                        </p>
                                        <a href="{{ route('customer.bookings.payment', $partial) }}" 
                                           class="inline-block px-4 py-2 bg-gradient-to-r from-blue-500 to-indigo-500 text-white text-sm font-semibold rounded-lg hover:from-blue-600 hover:to-indigo-600 transition-all duration-200 shadow-md">
                                            💵 Lunasi Sekarang
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <div class="text-sm text-green-800">
                                <p class="font-medium">Informasi Pelunasan:</p>
                                <ul class="mt-1 list-disc list-inside space-y-1">
                                    <li>Deposit Anda sudah diterima dan diverifikasi ✓</li>
                                    <li>Lunasi sisa pembayaran sebelum pengambilan kendaraan</li>
                                    <li>Bisa bayar tunai saat pickup atau transfer terlebih dahulu</li>
                                    <li>Upload bukti transfer jika bayar via bank</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
