<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pelanggan: ') . $customer->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.customers.edit', $customer) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-icons.cog class="w-4 h-4 inline mr-1" />
                    Edit Pelanggan
                </a>
                <a href="{{ route('admin.customers.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <x-icons.arrow-left class="w-4 h-4 inline mr-1" />
                    Kembali ke Pelanggan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Informasi Pelanggan -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pelanggan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->name }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Telepon</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->phone }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->email ?: 'Tidak disediakan' }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">NIK</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->nik }}</p>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                                    <p class="mt-1 text-sm text-gray-900">{{ $customer->address }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Status Anggota</label>
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
                                    <label class="block text-sm font-medium text-gray-700">Status</label>
                                    <div class="mt-1">
                                        @if($customer->is_blacklisted)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <x-icons.ban class="w-3 h-3 mr-1" />
                                                Daftar Hitam
                                            </span>
                                            <p class="mt-1 text-sm text-red-600">{{ $customer->blacklist_reason }}</p>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Aktif
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tingkat Loyalitas</label>
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
                                    <label class="block text-sm font-medium text-gray-700">Penilaian Risiko</label>
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Dokumen</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto KTP</label>
                            @if($customer->ktp_photo)
                                <img src="{{ $customer->ktp_photo_url }}" alt="Foto KTP" class="w-full h-48 object-cover rounded-lg border">
                            @else
                                <div class="w-full h-48 bg-gray-100 rounded-lg border flex items-center justify-center">
                                    <span class="text-gray-500">Foto KTP tidak diunggah</span>
                                </div>
                            @endif
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Foto SIM</label>
                            @if($customer->sim_photo)
                                <img src="{{ $customer->sim_photo_url }}" alt="Foto SIM" class="w-full h-48 object-cover rounded-lg border">
                            @else
                                <div class="w-full h-48 bg-gray-100 rounded-lg border flex items-center justify-center">
                                    <span class="text-gray-500">Foto SIM tidak diunggah</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistik -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik Pemesanan</h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $statistics['total_bookings'] }}</div>
                            <div class="text-sm text-blue-600">Total Pemesanan</div>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-green-600">{{ $statistics['completed_bookings'] }}</div>
                            <div class="text-sm text-green-600">Selesai</div>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-yellow-600">{{ $statistics['active_bookings'] }}</div>
                            <div class="text-sm text-yellow-600">Aktif</div>
                        </div>
                        
                        <div class="bg-red-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-red-600">{{ $statistics['cancelled_bookings'] }}</div>
                            <div class="text-sm text-red-600">Dibatalkan</div>
                        </div>
                        
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-purple-600">Rp {{ number_format($statistics['total_revenue'], 0, ',', '.') }}</div>
                            <div class="text-sm text-purple-600">Total Pendapatan</div>
                        </div>
                        
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-indigo-600">Rp {{ number_format($statistics['average_booking_value'], 0, ',', '.') }}</div>
                            <div class="text-sm text-indigo-600">Rata-rata Nilai Pemesanan</div>
                        </div>
                        
                        <div class="bg-pink-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-pink-600">{{ number_format($statistics['completion_rate'], 1) }}%</div>
                            <div class="text-sm text-pink-600">Tingkat Penyelesaian</div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-2xl font-bold text-gray-600">
                                {{ $statistics['last_booking_date'] ? $statistics['last_booking_date']->format('M d, Y') : 'Belum pernah' }}
                            </div>
                            <div class="text-sm text-gray-600">Pemesanan Terakhir</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pemesanan Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Pemesanan Terbaru</h3>
                    
                    @if($customer->bookings->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
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
                        <p class="text-gray-500">Tidak ada pemesanan ditemukan untuk pelanggan ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>