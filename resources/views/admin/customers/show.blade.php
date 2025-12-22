<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-base sm:text-lg lg:text-xl text-gray-800 leading-tight truncate">
                {{ __('Detail: ') . $customer->name }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.customers.edit', $customer) }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <x-icons.cog class="w-3 h-3 sm:w-4 sm:h-4 mr-1" />
                    <span class="hidden sm:inline">Edit Pelanggan</span>
                    <span class="sm:hidden">Edit</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <x-icons.arrow-left class="w-3 h-3 sm:w-4 sm:h-4 mr-1" />
                    <span class="hidden sm:inline">Kembali</span>
                    <span class="sm:hidden">Kembali</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Informasi Pelanggan -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Informasi Pelanggan</h3>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <div class="space-y-3 sm:space-y-4">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Nama</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Telepon</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->phone }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900 break-all">{{ $customer->email ?: 'Tidak disediakan' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">NIK</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->nik }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Alamat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->address }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="space-y-3 sm:space-y-4">
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Status Anggota</label>
                                    <div class="mt-1 flex items-center">
                                        @if($customer->is_member)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <x-icons.star class="w-3 h-3 mr-1" />
                                                Anggota (Diskon {{ $discountInfo['discount_percentage'] }}%)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Pelanggan Biasa
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-1">
                                        @if($customer->is_blacklisted)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <x-icons.ban class="w-3 h-3 mr-1" />
                                                Daftar Hitam
                                            </span>
                                            <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $customer->blacklist_reason }}</p>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Tingkat Loyalitas</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($loyaltyTier === 'platinum') bg-purple-100 text-purple-800
                                            @elseif($loyaltyTier === 'gold') bg-yellow-100 text-yellow-800
                                            @elseif($loyaltyTier === 'silver') bg-gray-100 text-gray-800
                                            @else bg-orange-100 text-orange-800 @endif">
                                            {{ ucfirst($loyaltyTier) }}
                                        </span>
                                    </p>
                                </div>
                                
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium text-gray-700">Penilaian Risiko</label>
                                    <p class="mt-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                            @if($riskAssessment['risk_level'] === 'high') bg-red-100 text-red-800
                                            @elseif($riskAssessment['risk_level'] === 'medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            Risiko {{ ucfirst($riskAssessment['risk_level']) }}
                                        </span>
                                    </p>
                                    @if(!empty($riskAssessment['risk_factors']))
                                        <ul class="mt-1 text-xs text-gray-600">
                                            @foreach($riskAssessment['risk_factors'] as $factor)
                                                <li>• {{ $factor }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Dokumen</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Foto KTP</label>
                            @if($customer->ktp_photo)
                                <img src="{{ $customer->ktp_photo_url }}" alt="Foto KTP" class="w-full h-32 sm:h-48 object-cover rounded-lg border">
                            @else
                                <div class="w-full h-32 sm:h-48 bg-gray-100 rounded-lg border flex items-center justify-center">
                                    <span class="text-xs sm:text-sm text-gray-500">Foto KTP tidak diunggah</span>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Foto SIM</label>
                            @if($customer->sim_photo)
                                <img src="{{ $customer->sim_photo_url }}" alt="Foto SIM" class="w-full h-32 sm:h-48 object-cover rounded-lg border">
                            @else
                                <div class="w-full h-32 sm:h-48 bg-gray-100 rounded-lg border flex items-center justify-center">
                                    <span class="text-xs sm:text-sm text-gray-500">Foto SIM tidak diunggah</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Statistik Pemesanan</h3>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                        <div class="bg-blue-50 p-3 sm:p-4 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-blue-600">{{ $statistics['total_bookings'] }}</div>
                            <div class="text-xs sm:text-sm text-blue-600">Total Pemesanan</div>
                        </div>
                        
                        <div class="bg-green-50 p-3 sm:p-4 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-green-600">{{ $statistics['completed_bookings'] }}</div>
                            <div class="text-xs sm:text-sm text-green-600">Selesai</div>
                        </div>
                        
                        <div class="bg-yellow-50 p-3 sm:p-4 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-yellow-600">{{ $statistics['active_bookings'] }}</div>
                            <div class="text-xs sm:text-sm text-yellow-600">Aktif</div>
                        </div>
                        
                        <div class="bg-red-50 p-3 sm:p-4 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-red-600">{{ $statistics['cancelled_bookings'] }}</div>
                            <div class="text-xs sm:text-sm text-red-600">Dibatalkan</div>
                        </div>
                        
                        <div class="bg-purple-50 p-3 sm:p-4 rounded-lg sm:col-span-2">
                            <div class="text-base sm:text-xl lg:text-2xl font-bold text-purple-600 truncate">Rp {{ number_format($statistics['total_revenue'] / 1000, 0) }}K</div>
                            <div class="text-xs sm:text-sm text-purple-600">Total Pendapatan</div>
                        </div>
                        
                        <div class="bg-indigo-50 p-3 sm:p-4 rounded-lg sm:col-span-2">
                            <div class="text-base sm:text-xl lg:text-2xl font-bold text-indigo-600 truncate">Rp {{ number_format($statistics['average_booking_value'] / 1000, 0) }}K</div>
                            <div class="text-xs sm:text-sm text-indigo-600">Rata-rata Nilai</div>
                        </div>
                        
                        <div class="bg-pink-50 p-3 sm:p-4 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-pink-600">{{ number_format($statistics['completion_rate'], 1) }}%</div>
                            <div class="text-xs sm:text-sm text-pink-600">Tingkat Selesai</div>
                        </div>
                        
                        <div class="bg-gray-50 p-3 sm:p-4 rounded-lg">
                            <div class="text-xs sm:text-sm lg:text-base font-bold text-gray-600 truncate">
                                {{ $statistics['last_booking_date'] ? $statistics['last_booking_date']->format('M d, Y') : 'Belum pernah' }}
                            </div>
                            <div class="text-xs sm:text-sm text-gray-600">Terakhir</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemesanan Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 mb-3 sm:mb-4">Pemesanan Terbaru</h3>
                    
                    @if($customer->bookings->count() > 0)
                        <!-- Mobile Card View -->
                        <div class="lg:hidden space-y-3">
                            @foreach($customer->bookings as $booking)
                                <div class="border border-gray-200 rounded-lg p-3">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="font-medium text-sm text-gray-900">{{ $booking->booking_number }}</div>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                            @if($booking->booking_status === 'completed') bg-green-100 text-green-800
                                            @elseif($booking->booking_status === 'active') bg-blue-100 text-blue-800
                                            @elseif($booking->booking_status === 'confirmed') bg-yellow-100 text-yellow-800
                                            @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($booking->booking_status) }}
                                        </span>
                                    </div>
                                    <div class="space-y-1 text-xs text-gray-600">
                                        <div><span class="font-medium">Kendaraan:</span> {{ $booking->car->license_plate ?? 'N/A' }}</div>
                                        <div><span class="font-medium">Periode:</span> {{ $booking->start_date->format('d M') }} - {{ $booking->end_date->format('d M Y') }}</div>
                                        <div><span class="font-medium">Jumlah:</span> Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Desktop Table View -->
                        <div class="hidden lg:block overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Pemesanan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($customer->bookings as $booking)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $booking->booking_number }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->car->license_plate ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $booking->start_date->format('M d, Y') }} - {{ $booking->end_date->format('M d, Y') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    @if($booking->booking_status === 'completed') bg-green-100 text-green-800
                                                    @elseif($booking->booking_status === 'active') bg-blue-100 text-blue-800
                                                    @elseif($booking->booking_status === 'confirmed') bg-yellow-100 text-yellow-800
                                                    @elseif($booking->booking_status === 'cancelled') bg-red-100 text-red-800
                                                    @else bg-gray-100 text-gray-800 @endif">
                                                    {{ ucfirst($booking->booking_status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Tidak ada pemesanan ditemukan untuk pelanggan ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>