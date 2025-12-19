<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ $car->brand }} {{ $car->model }}
                </h2>
                <p class="text-sm text-gray-500">{{ $car->license_plate }} • {{ $car->year }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.vehicles.edit', $car) }}" 
                   class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                
                <form action="{{ route('admin.vehicles.destroy', $car) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <!-- Alerts -->
    @if(\Carbon\Carbon::parse($car->stnk_expiry)->isPast())
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">STNK Kadaluarsa!</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <p>Masa berlaku STNK kendaraan ini telah habis pada <strong>{{ \Carbon\Carbon::parse($car->stnk_expiry)->format('d F Y') }}</strong>. Segera lakukan perpanjangan.</p>
                    </div>
                </div>
            </div>
        </div>
    @elseif(\Carbon\Carbon::parse($car->stnk_expiry)->diffInDays(now()) <= 7)
        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-r-lg shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">STNK Segera Kadaluarsa</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p>Masa berlaku STNK akan habis dalam {{ \Carbon\Carbon::parse($car->stnk_expiry)->diffInDays(now()) }} hari ({{ \Carbon\Carbon::parse($car->stnk_expiry)->format('d F Y') }}).</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status & Photos -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Status & Foto</h3>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($car->status === 'available') bg-green-100 text-green-800
                        @elseif($car->status === 'rented') bg-blue-100 text-blue-800
                        @elseif($car->status === 'maintenance') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($car->status) }}
                    </span>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        @foreach(['photo_front' => 'Depan', 'photo_side' => 'Samping', 'photo_back' => 'Belakang'] as $field => $label)
                            <div class="relative aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200 group">
                                @if($car->$field)
                                    <img src="{{ Storage::url($car->$field) }}" alt="Foto {{ $label }}" class="w-full h-full object-cover">
                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                        <a href="{{ Storage::url($car->$field) }}" target="_blank" class="text-white opacity-0 group-hover:opacity-100 font-medium text-sm bg-black bg-opacity-50 px-3 py-1 rounded-full">Lihat Full</a>
                                    </div>
                                @else
                                    <div class="flex flex-col items-center justify-center h-full text-gray-400">
                                        <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="text-xs">Foto {{ $label }} Kosong</span>
                                    </div>
                                @endif
                                <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                                    <span class="text-white text-xs font-medium">{{ $label }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Detail Spesifikasi -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Spesifikasi Detail</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Merek</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $car->brand }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Model</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $car->model }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tahun Pembuatan</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $car->year }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Warna</dt>
                            <dd class="mt-1 text-sm text-gray-900 flex items-center gap-2">
                                <span class="w-4 h-4 rounded-full border border-gray-200 shadow-sm" style="background-color: {{ $car->color }}"></span>
                                {{ $car->color }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Plat Nomor</dt>
                            <dd class="mt-1 text-sm font-mono bg-gray-100 px-2 py-1 rounded inline-block text-gray-900">{{ $car->license_plate }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Odometer Saat Ini</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ number_format($car->current_odometer, 0, ',', '.') }} km</dd>
                        </div>
                    </dl>
                </div>
            </div>
            
            <!-- Informasi Harga -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Informasi Harga Sewa</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Harian</dt>
                            <dd class="mt-2 text-xl font-bold text-accent-600">Rp {{ number_format($car->daily_rate, 0, ',', '.') }}</dd>
                            <span class="text-xs text-gray-400">per 24 jam</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Mingguan</dt>
                            <dd class="mt-2 text-xl font-bold text-accent-600">Rp {{ number_format($car->weekly_rate, 0, ',', '.') }}</dd>
                            <span class="text-xs text-gray-400">per 7 hari</span>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-100 text-center">
                            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wider">Jasa Sopir</dt>
                            <dd class="mt-2 text-xl font-bold text-accent-600">Rp {{ number_format($car->driver_fee_per_day, 0, ',', '.') }}</dd>
                            <span class="text-xs text-gray-400">per hari</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-6">
            <!-- Dokumen & Legalitas -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Dokumen & Legalitas</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Nomor STNK</dt>
                        <dd class="mt-1 text-sm font-mono text-gray-900">{{ $car->stnk_number }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Masa Berlaku STNK</dt>
                        <dd class="mt-1 text-sm font-medium {{ \Carbon\Carbon::parse($car->stnk_expiry)->isPast() ? 'text-red-600' : 'text-gray-900' }}">
                            {{ \Carbon\Carbon::parse($car->stnk_expiry)->format('d F Y') }}
                        </dd>
                        @if(\Carbon\Carbon::parse($car->stnk_expiry)->isPast())
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                Kadaluarsa
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Perawatan Terakhir -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Perawatan</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Ganti Oli Terakhir</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $car->last_oil_change ? \Carbon\Carbon::parse($car->last_oil_change)->format('d F Y') : '-' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-medium text-gray-500">Interval Ganti Oli</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            {{ $car->oil_change_interval_km ? number_format($car->oil_change_interval_km, 0, ',', '.') . ' km' : '-' }}
                        </dd>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.vehicles.maintenance-due') }}" class="text-sm text-accent-600 hover:text-accent-700 font-medium flex items-center">
                            Lihat Jadwal Perawatan
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Riwayat Pemesanan Singkat -->
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Riwayat Pemesanan</h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($car->bookings as $booking)
                        <div class="px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $booking->customer->name ?? 'Pelanggan Dihapus' }}</p>
                                    <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($booking->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($booking->end_date)->format('d M Y') }}</p>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                    @if($booking->booking_status === 'completed') bg-green-100 text-green-800
                                    @elseif($booking->booking_status === 'active') bg-blue-100 text-blue-800
                                    @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($booking->booking_status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="px-6 py-4 text-center text-gray-500 text-sm">
                            Belum ada riwayat pemesanan
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>