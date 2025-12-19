<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Detail Pemesanan - {{ $booking->booking_number }}
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Dibuat pada {{ $booking->created_at?->format('F j, Y \a\t g:i A') }}
                </p>
            </div>
            <div class="flex items-center space-x-3">
                @if($booking->canBeModified())
                    <a href="{{ route('admin.bookings.edit', $booking) }}" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:outline-none focus:ring ring-yellow-300 transition ease-in-out duration-150">
                        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Ubah Pemesanan
                    </a>
                @endif
                <a href="{{ route('admin.bookings.index') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring ring-gray-300 transition ease-in-out duration-150">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Pemesanan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- Status and Actions -->
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($booking->booking_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->booking_status === 'confirmed') bg-blue-100 text-blue-800
                                @elseif($booking->booking_status === 'active') bg-green-100 text-green-800
                                @elseif($booking->booking_status === 'completed') bg-gray-100 text-gray-800
                                @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($booking->booking_status) }}
                            </span>
                        </div>
                        <div>
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full 
                                @if($booking->payment_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->payment_status === 'verifying') bg-blue-100 text-blue-800
                                @elseif($booking->payment_status === 'partial') bg-orange-100 text-orange-800
                                @elseif($booking->payment_status === 'paid') bg-green-100 text-green-800
                                @elseif($booking->payment_status === 'refunded') bg-purple-100 text-purple-800
                                @endif">
                                Pembayaran: {{ ucfirst($booking->payment_status) }}
                            </span>
                        </div>
                        @if($booking->isOverdue())
                            <div>
                                <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-800">
                                    TERLAMBAT
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        @if($booking->booking_status === 'pending')
                            <form action="{{ route('admin.bookings.confirm', $booking) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    Konfirmasi Pemesanan
                                </button>
                            </form>
                        @endif

                        @if($booking->booking_status === 'confirmed')
                            @if($booking->bisaSerahKunci())
                                <a href="{{ route('admin.bookings.serah-kunci', $booking) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                                    </svg>
                                    Serah Kunci
                                </a>
                            @else
                                <button disabled class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-400 cursor-not-allowed" title="Pembayaran harus lunas untuk serah kunci">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                    Serah Kunci (Terkunci)
                                </button>
                            @endif
                        @endif

                        @if($booking->booking_status === 'active')
                            @if($booking->bisaTerimaKunci())
                                <a href="{{ route('admin.bookings.terima-kunci', $booking) }}" 
                                   class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Terima Kunci
                                </a>
                            @else
                                <form action="{{ route('admin.bookings.complete', $booking) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="actual_return_date" value="{{ now() }}">
                                    <button type="submit" 
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                                            onclick="return confirm('Booking ini tidak memiliki data serah kunci. Selesaikan secara manual?')">
                                        Selesaikan (Manual)
                                    </button>
                                </form>
                            @endif
                        @endif

                        @if($booking->canBeCancelled())
                            <form action="{{ route('admin.bookings.cancel', $booking) }}" method="POST" class="inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pemesanan ini?')">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Batalkan Pemesanan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Payment Verification -->
            @if($booking->payment_status === 'verifying' || $booking->payment_proof || $booking->deposit_proof)
                <div class="bg-white shadow rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Verifikasi Pembayaran</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-6">
                            @if($booking->payment_proof)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-2">
                                    Bukti Pembayaran {{ $booking->payment_type === 'full' && $booking->deposit_proof ? '(Pelunasan)' : '' }}
                                </h4>
                                <div class="border rounded-lg p-2">
                                    <a href="{{ asset('storage/' . $booking->payment_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $booking->payment_proof) }}" alt="Bukti Pembayaran" class="max-h-64 object-contain mx-auto">
                                    </a>
                                </div>
                            </div>
                            @endif

                            @if($booking->deposit_proof)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500 mb-2">Bukti Deposit (Riwayat)</h4>
                                <div class="border rounded-lg p-2 bg-gray-50">
                                    <a href="{{ asset('storage/' . $booking->deposit_proof) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $booking->deposit_proof) }}" alt="Bukti Deposit" class="max-h-64 object-contain mx-auto opacity-75 hover:opacity-100 transition-opacity">
                                    </a>
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Tipe Pembayaran</h4>
                                <p class="text-gray-900 font-medium">{{ ucfirst($booking->payment_type) }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Jumlah Dibayar</h4>
                                <p class="text-gray-900 font-medium">Rp {{ number_format($booking->paid_amount, 0, ',', '.') }}</p>
                            </div>
                            
                            @if($booking->payment_notes)
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500">Catatan Pembayaran</h4>
                                    <p class="text-gray-900">{{ $booking->payment_notes }}</p>
                                </div>
                            @endif
                            
                            @if($booking->payment_status === 'verifying')
                                <div class="pt-4 border-t border-gray-200 flex space-x-3">
                                    <form action="{{ route('admin.bookings.approve-payment', $booking) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring ring-green-300 transition ease-in-out duration-150">
                                            Setujui
                                        </button>
                                    </form>
                                    
                                    <button type="button" onclick="document.getElementById('reject-payment-form').classList.toggle('hidden')" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring ring-red-300 transition ease-in-out duration-150">
                                        Tolak
                                    </button>
                                </div>
                                
                                <form id="reject-payment-form" action="{{ route('admin.bookings.reject-payment', $booking) }}" method="POST" class="hidden mt-4">
                                    @csrf
                                    @method('PATCH')
                                    <div>
                                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Alasan Penolakan</label>
                                        <textarea name="rejection_reason" id="rejection_reason" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required></textarea>
                                    </div>
                                    <div class="mt-2">
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:outline-none focus:ring ring-red-300 transition ease-in-out duration-150">
                                            Konfirmasi Penolakan
                                        </button>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Booking Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pemesanan</h3>
                    
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nomor Pemesanan</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->booking_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Durasi</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->getDurationInDays() }} hari ({{ $booking->getDurationInHours() }} jam)</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal & Waktu Mulai</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->start_date?->format('F j, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tanggal & Waktu Selesai</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->end_date?->format('F j, Y \a\t g:i A') }}</dd>
                        </div>
                        @if($booking->actual_return_date)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Tanggal Pengembalian Aktual</dt>
                                <dd class="text-sm text-gray-900">{{ $booking->actual_return_date?->format('F j, Y \a\t g:i A') }}</dd>
                            </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lokasi Penjemputan</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->pickup_location }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lokasi Pengembalian</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->return_location }}</dd>
                        </div>
                        @if($booking->with_driver)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Sopir</dt>
                                <dd class="text-sm text-gray-900">
                                    @if($booking->driver)
                                        {{ $booking->driver?->name }} ({{ $booking->driver?->phone }})
                                    @else
                                        Sopir diminta (belum ditugaskan)
                                    @endif
                                </dd>
                            </div>
                        @endif
                        @if($booking->is_out_of_town)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Biaya Luar Kota</dt>
                                <dd class="text-sm text-gray-900">Rp {{ number_format($booking->out_of_town_fee, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                        @if($booking->notes)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Catatan</dt>
                                <dd class="text-sm text-gray-900">{{ $booking->notes }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Customer Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Pelanggan</h3>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex-1">
                            <h4 class="text-base font-medium text-gray-900">
                                {{ $booking->customer?->name ?? 'Customer ID: ' . $booking->customer_id . ' (Data Tidak Ditemukan)' }}
                            </h4>
                            <p class="text-sm text-gray-500">{{ $booking->customer?->phone }}</p>
                            @if($booking->customer?->email)
                                <p class="text-sm text-gray-500">{{ $booking->customer?->email }}</p>
                            @endif
                        </div>
                        @if($booking->customer?->is_member)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Anggota
                            </span>
                        @endif
                    </div>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">NIK</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->customer?->nik }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Alamat</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->customer?->address }}</dd>
                        </div>
                        @if($booking->customer?->is_member)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Diskon Anggota</dt>
                                <dd class="text-sm text-gray-900">{{ $booking->customer?->member_discount ?? 10 }}%</dd>
                            </div>
                        @endif
                    </dl>

                    <div class="mt-4">
                        @if($booking->customer)
                            <a href="{{ route('admin.customers.show', $booking->customer) }}" 
                               class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                Lihat Profil Pelanggan →
                            </a>
                        @else
                            <span class="text-gray-500 text-sm italic">Data pelanggan tidak tersedia</span>
                        @endif
                    </div>
                </div>

                <!-- Vehicle Information -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Informasi Kendaraan</h3>
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <div class="flex-1">
                            <h4 class="text-base font-medium text-gray-900">
                                {{ $booking->car?->license_plate ?? 'Car ID: ' . $booking->car_id . ' (Data Tidak Ditemukan)' }}
                            </h4>
                            <p class="text-sm text-gray-500">{{ $booking->car?->brand }} {{ $booking->car?->model }} ({{ $booking->car?->year }})</p>
                            <p class="text-sm text-gray-500">{{ $booking->car?->color }}</p>
                        </div>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                            @if($booking->car?->status === 'available') bg-green-100 text-green-800
                            @elseif($booking->car?->status === 'rented') bg-blue-100 text-blue-800
                            @elseif($booking->car?->status === 'maintenance') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst($booking->car?->status) }}
                        </span>
                    </div>

                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Nomor STNK</dt>
                            <dd class="text-sm text-gray-900">{{ $booking->car?->stnk_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tarif Harian</dt>
                            <dd class="text-sm text-gray-900">Rp {{ number_format($booking->car?->daily_rate, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tarif Mingguan</dt>
                            <dd class="text-sm text-gray-900">Rp {{ number_format($booking->car?->weekly_rate, 0, ',', '.') }}</dd>
                        </div>
                        @if($booking->with_driver)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Biaya Sopir per Hari</dt>
                                <dd class="text-sm text-gray-900">Rp {{ number_format($booking->car?->driver_fee_per_day, 0, ',', '.') }}</dd>
                            </div>
                        @endif
                    </dl>

                    <div class="mt-4">
                        @if($booking->car)
                            <a href="{{ route('admin.vehicles.show', $booking->car) }}" 
                               class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                Lihat Detail Kendaraan →
                            </a>
                        @else
                            <span class="text-gray-500 text-sm italic">Data kendaraan tidak tersedia</span>
                        @endif
                    </div>
                </div>

                <!-- Pricing Breakdown -->
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Rincian Harga</h3>
                    
                    <div class="space-y-3">
                        @if(!empty($pricingBreakdown))
                            @foreach($pricingBreakdown as $item)
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <div>
                                        <div class="text-sm font-medium text-gray-900">{{ $item['description'] }}</div>
                                        @if($item['quantity'] > 1)
                                            <div class="text-xs text-gray-500">
                                                {{ $item['quantity'] }} × Rp {{ number_format($item['rate'], 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="text-sm font-medium {{ isset($item['is_discount']) ? 'text-green-600' : 'text-gray-900' }}">
                                        @if(isset($item['is_discount']))
                                            -Rp {{ number_format($booking->member_discount, 0, ',', '.') }}
                                        @else
                                            Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif

                        <!-- Base Amount -->
                        <div class="flex justify-between items-center py-2 border-b border-gray-200">
                            <div class="text-sm font-medium text-gray-900">Jumlah Dasar</div>
                            <div class="text-sm font-medium text-gray-900">
                                Rp {{ number_format($booking->base_amount, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Driver Fee -->
                        @if($booking->driver_fee > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-gray-900">Biaya Sopir</div>
                                <div class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Out of Town Fee -->
                        @if($booking->out_of_town_fee > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-gray-900">Biaya Luar Kota</div>
                                <div class="text-sm font-medium text-gray-900">
                                    Rp {{ number_format($booking->out_of_town_fee, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Member Discount -->
                        @if($booking->member_discount > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-green-600">Diskon Anggota</div>
                                <div class="text-sm font-medium text-green-600">
                                    -Rp {{ number_format($booking->member_discount, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Late Penalty -->
                        @if($booking->late_penalty > 0)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="text-sm font-medium text-red-600">Denda Keterlambatan</div>
                                <div class="text-sm font-medium text-red-600">
                                    Rp {{ number_format($booking->late_penalty, 0, ',', '.') }}
                                </div>
                            </div>
                        @endif

                        <!-- Total Amount -->
                        <div class="flex justify-between items-center py-3 border-t-2 border-gray-300">
                            <div class="text-lg font-bold text-gray-900">Total Jumlah</div>
                            <div class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                            </div>
                        </div>

                        <!-- Deposit -->
                        <div class="bg-blue-50 p-4 rounded-lg space-y-2">
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-medium text-blue-900">Jumlah Deposit</div>
                                <div class="text-sm font-bold text-blue-900">
                                    Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="flex justify-between items-center">
                                <div class="text-sm font-medium text-blue-900">Sisa Jumlah</div>
                                <div class="text-sm font-bold text-blue-900">
                                    Rp {{ number_format($booking->total_amount - $booking->deposit_amount, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Car Inspections -->
            @if($booking->carInspections->count() > 0)
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Pemeriksaan Kendaraan</h3>
                    
                    <div class="space-y-4">
                        @foreach($booking->carInspections as $inspection)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="text-base font-medium text-gray-900">
                                        Pemeriksaan {{ ucfirst($inspection->inspection_type) }}
                                    </h4>
                                    <span class="text-sm text-gray-500">
                                        {{ $inspection->created_at?->format('M j, Y \a\t g:i A') }}
                                    </span>
                                </div>
                                
                                <dl class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <dt class="font-medium text-gray-500">Level Bahan Bakar</dt>
                                        <dd class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $inspection->fuel_level)) }}</dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-500">Odometer</dt>
                                        <dd class="text-gray-900">{{ number_format($inspection->odometer_reading) }} km</dd>
                                    </div>
                                    @if($inspection->notes)
                                        <div>
                                            <dt class="font-medium text-gray-500">Catatan</dt>
                                            <dd class="text-gray-900">{{ $inspection->notes }}</dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>