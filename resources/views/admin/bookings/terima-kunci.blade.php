@extends('layouts.admin')

@section('title', 'Terima Kunci - Booking #' . $booking->booking_number)

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Pengembalian Kunci</h1>
                <p class="mt-1 text-sm text-gray-600">Booking #{{ $booking->booking_number }}</p>
            </div>
            <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Alert -->
    @if(session('error'))
        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-500"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('admin.bookings.terima-kunci.store', $booking) }}" method="POST" enctype="multipart/form-data" id="terimaKunciForm">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Informasi Booking -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Informasi Booking</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Customer</label>
                                <p class="text-gray-900 font-semibold">{{ $booking->customer->name }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->customer->phone }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kendaraan</label>
                                <p class="text-gray-900 font-semibold">{{ $booking->car->brand }} {{ $booking->car->model }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->car->license_plate }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Periode Rental</label>
                                <p class="text-gray-900">{{ $booking->start_date->format('d M Y') }} - {{ $booking->end_date->format('d M Y') }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->getDurationInDays() }} hari</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Serah Kunci</label>
                                <p class="text-gray-900">{{ $booking->tanggal_serah_kunci->format('d M Y, H:i') }}</p>
                                <p class="text-sm text-gray-600">{{ $booking->petugasSerahKunci->name ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kondisi Saat Pickup (Read-only) -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Kondisi Saat Penyerahan</h3>
                        <p class="text-sm text-gray-600 mt-1">Referensi kondisi kendaraan saat diserahkan</p>
                    </div>
                    <div class="card-body">
                        @if($booking->foto_serah_kunci)
                            @php
                                $fotoSerah = json_decode($booking->foto_serah_kunci, true) ?? [];
                            @endphp
                            <div class="grid grid-cols-4 gap-3">
                                @foreach($fotoSerah as $index => $foto)
                                    <div>
                                        <a href="{{ asset('storage/' . $foto) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $foto) }}" 
                                                 alt="Foto {{ $index + 1 }}" 
                                                 class="w-full h-24 object-cover rounded border border-gray-300 hover:opacity-75 transition">
                                        </a>
                                        <p class="text-xs text-gray-600 mt-1 text-center">Foto {{ $index + 1 }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-sm">Tidak ada foto kondisi pickup</p>
                        @endif
                        
                        @if($booking->catatan_serah_kunci)
                            <div class="mt-4 p-3 bg-gray-50 rounded border border-gray-200">
                                <p class="text-sm font-medium text-gray-700 mb-1">Catatan Pickup:</p>
                                <p class="text-sm text-gray-600">{{ $booking->catatan_serah_kunci }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Upload Foto Kondisi Return -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Foto Kondisi Pengembalian</h3>
                        <p class="text-sm text-gray-600 mt-1">Upload foto kondisi kendaraan saat dikembalikan</p>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Depan <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="foto_kondisi[]" 
                                       accept="image/*" 
                                       required
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <p class="mt-1 text-xs text-gray-500">Max 5MB, JPG/PNG</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Belakang <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="foto_kondisi[]" 
                                       accept="image/*" 
                                       required
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <p class="mt-1 text-xs text-gray-500">Max 5MB, JPG/PNG</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Interior <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="foto_kondisi[]" 
                                       accept="image/*" 
                                       required
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <p class="mt-1 text-xs text-gray-500">Max 5MB, JPG/PNG</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Foto Dashboard <span class="text-red-500">*</span>
                                </label>
                                <input type="file" 
                                       name="foto_kondisi[]" 
                                       accept="image/*" 
                                       required
                                       class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                                <p class="mt-1 text-xs text-gray-500">Max 5MB, JPG/PNG</p>
                            </div>
                        </div>

                        <!-- Foto Kerusakan (Optional) -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Kerusakan (Jika Ada)
                            </label>
                            <input type="file" 
                                   name="foto_kerusakan[]" 
                                   accept="image/*" 
                                   multiple
                                   class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            <p class="mt-1 text-xs text-gray-500">Upload jika ada kerusakan. Bisa multiple files.</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Pengembalian -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Detail Pengembalian</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Kilometer Akhir
                                </label>
                                <input type="number" 
                                       name="kilometer_akhir" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Contoh: 15000">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Level Bahan Bakar
                                </label>
                                <select name="bahan_bakar_akhir" 
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Pilih level</option>
                                    <option value="penuh">Penuh (Full)</option>
                                    <option value="3/4">3/4 Tank</option>
                                    <option value="1/2">1/2 Tank</option>
                                    <option value="1/4">1/4 Tank</option>
                                    <option value="kosong">Hampir Kosong</option>
                                </select>
                            </div>
                        </div>

                        <!-- Kerusakan -->
                        <div class="mt-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi Kerusakan (Jika Ada)
                            </label>
                            <textarea name="kerusakan" 
                                      rows="3" 
                                      id="kerusakanInput"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Jelaskan kerusakan yang ditemukan..."></textarea>
                        </div>

                        <!-- Biaya Kerusakan -->
                        <div class="mt-4" id="biayaKerusakanDiv" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Biaya Kerusakan
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">Rp</span>
                                <input type="number" 
                                       name="biaya_kerusakan" 
                                       id="biayaKerusakanInput"
                                       class="w-full pl-12 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="0"
                                       min="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Catatan -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Catatan Pengembalian</h3>
                    </div>
                    <div class="card-body">
                        <textarea name="catatan" 
                                  rows="4" 
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                  placeholder="Catatan kondisi kendaraan, kelengkapan, atau informasi penting lainnya..."></textarea>
                    </div>
                </div>

            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                
                <!-- Perhitungan Biaya -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Perhitungan Biaya</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <!-- Total Rental -->
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-sm text-gray-600">Total Rental</span>
                                <span class="font-semibold">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</span>
                            </div>

                            <!-- Deposit -->
                            <div class="flex justify-between items-center pb-3 border-b">
                                <span class="text-sm text-gray-600">Deposit</span>
                                <span class="font-semibold text-green-600">Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}</span>
                            </div>

                            <!-- Keterlambatan -->
                            @php
                                $isLate = now()->greaterThan($booking->end_date);
                                $lateDays = $isLate ? $booking->end_date->diffInDays(now()) : 0;
                                $lateFee = $lateDays > 0 ? $lateDays * $booking->car->daily_rate * 1.5 : 0;
                            @endphp
                            @if($isLate)
                                <div class="flex justify-between items-center pb-3 border-b">
                                    <div>
                                        <span class="text-sm text-gray-600">Keterlambatan</span>
                                        <p class="text-xs text-red-600">{{ $lateDays }} hari × 150%</p>
                                    </div>
                                    <span class="font-semibold text-red-600">Rp {{ number_format($lateFee, 0, ',', '.') }}</span>
                                </div>
                            @endif

                            <!-- Kerusakan -->
                            <div class="flex justify-between items-center pb-3 border-b" id="biayaKerusakanDisplay" style="display: none;">
                                <span class="text-sm text-gray-600">Biaya Kerusakan</span>
                                <span class="font-semibold text-red-600" id="biayaKerusakanAmount">Rp 0</span>
                            </div>

                            <!-- Total Biaya Tambahan -->
                            @php
                                $totalAdditional = $lateFee;
                            @endphp
                            <div class="flex justify-between items-center pt-3 border-t-2">
                                <span class="font-semibold">Biaya Tambahan</span>
                                <span class="font-bold text-red-600" id="totalAdditional">Rp {{ number_format($totalAdditional, 0, ',', '.') }}</span>
                            </div>

                            <!-- Deposit Dikembalikan -->
                            <div class="flex justify-between items-center pt-3 bg-green-50 p-3 rounded">
                                <span class="font-semibold text-green-800">Deposit Dikembalikan</span>
                                <span class="font-bold text-green-600" id="depositReturn">Rp {{ number_format($booking->deposit_amount - $totalAdditional, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Checklist -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Checklist Pengembalian</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Kondisi kendaraan sudah dicek</span>
                            </label>
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Kelengkapan kendaraan sudah diperiksa</span>
                            </label>
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Foto kondisi sudah diupload</span>
                            </label>
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Biaya tambahan sudah dikonfirmasi</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="w-full btn btn-success btn-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            Terima Kunci & Selesaikan
                        </button>
                        <p class="mt-3 text-xs text-center text-gray-500">
                            Booking akan diselesaikan dan kendaraan menjadi tersedia
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const kerusakanInput = document.getElementById('kerusakanInput');
    const biayaKerusakanDiv = document.getElementById('biayaKerusakanDiv');
    const biayaKerusakanInput = document.getElementById('biayaKerusakanInput');
    const biayaKerusakanDisplay = document.getElementById('biayaKerusakanDisplay');
    const biayaKerusakanAmount = document.getElementById('biayaKerusakanAmount');
    const totalAdditional = document.getElementById('totalAdditional');
    const depositReturn = document.getElementById('depositReturn');

    const depositAmount = {{ $booking->deposit_amount }};
    const lateFee = {{ $lateFee }};

    // Show/hide biaya kerusakan field
    kerusakanInput.addEventListener('input', function() {
        if (this.value.trim() !== '') {
            biayaKerusakanDiv.style.display = 'block';
        } else {
            biayaKerusakanDiv.style.display = 'none';
            biayaKerusakanInput.value = '';
            updateCalculation();
        }
    });

    // Update calculation when biaya kerusakan changes
    biayaKerusakanInput.addEventListener('input', function() {
        updateCalculation();
    });

    function updateCalculation() {
        const damageFee = parseFloat(biayaKerusakanInput.value) || 0;
        const total = lateFee + damageFee;
        const depositReturnAmount = Math.max(0, depositAmount - total);

        // Update display
        if (damageFee > 0) {
            biayaKerusakanDisplay.style.display = 'flex';
            biayaKerusakanAmount.textContent = 'Rp ' + damageFee.toLocaleString('id-ID');
        } else {
            biayaKerusakanDisplay.style.display = 'none';
        }

        totalAdditional.textContent = 'Rp ' + total.toLocaleString('id-ID');
        depositReturn.textContent = 'Rp ' + depositReturnAmount.toLocaleString('id-ID');
    }
});
</script>
@endpush
@endsection
