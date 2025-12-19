@extends('layouts.admin')

@section('title', 'Serah Kunci - Booking #' . $booking->booking_number)

@section('content')
<div class="container-fluid px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Penyerahan Kunci</h1>
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

    <form action="{{ route('admin.bookings.serah-kunci.store', $booking) }}" method="POST" enctype="multipart/form-data" id="serahKunciForm">
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Total Pembayaran</label>
                                <p class="text-gray-900 font-bold text-lg">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</p>
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Lunas
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Verifikasi Dokumen Customer -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Verifikasi Dokumen Customer</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-3 gap-4">
                            <!-- KTP -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">KTP</label>
                                @if($booking->customer->ktp_photo)
                                    <a href="{{ asset('storage/' . $booking->customer->ktp_photo) }}" target="_blank" class="block">
                                        <img src="{{ asset('storage/' . $booking->customer->ktp_photo) }}" 
                                             alt="KTP" 
                                             class="w-full h-32 object-cover rounded border border-gray-300 hover:opacity-75 transition">
                                    </a>
                                    <span class="inline-flex items-center mt-2 text-xs text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                    </span>
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded border border-gray-300 flex items-center justify-center">
                                        <span class="text-gray-400">Tidak ada</span>
                                    </div>
                                @endif
                            </div>

                            <!-- SIM -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">SIM</label>
                                @if($booking->customer->sim_photo)
                                    <a href="{{ asset('storage/' . $booking->customer->sim_photo) }}" target="_blank" class="block">
                                        <img src="{{ asset('storage/' . $booking->customer->sim_photo) }}" 
                                             alt="SIM" 
                                             class="w-full h-32 object-cover rounded border border-gray-300 hover:opacity-75 transition">
                                    </a>
                                    <span class="inline-flex items-center mt-2 text-xs text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                    </span>
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded border border-gray-300 flex items-center justify-center">
                                        <span class="text-gray-400">Tidak ada</span>
                                    </div>
                                @endif
                            </div>

                            <!-- KK -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kartu Keluarga</label>
                                @if($booking->customer->kk_photo)
                                    <a href="{{ asset('storage/' . $booking->customer->kk_photo) }}" target="_blank" class="block">
                                        <img src="{{ asset('storage/' . $booking->customer->kk_photo) }}" 
                                             alt="KK" 
                                             class="w-full h-32 object-cover rounded border border-gray-300 hover:opacity-75 transition">
                                    </a>
                                    <span class="inline-flex items-center mt-2 text-xs text-green-600">
                                        <i class="fas fa-check-circle mr-1"></i> Terverifikasi
                                    </span>
                                @else
                                    <div class="w-full h-32 bg-gray-100 rounded border border-gray-300 flex items-center justify-center">
                                        <span class="text-gray-400">Tidak ada</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Upload Foto Kondisi Kendaraan -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Foto Kondisi Kendaraan</h3>
                        <p class="text-sm text-gray-600 mt-1">Upload foto kondisi kendaraan sebelum diserahkan</p>
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
                    </div>
                </div>

                <!-- Catatan -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Catatan Tambahan</h3>
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
                
                <!-- Tanda Tangan Customer -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Tanda Tangan Customer</h3>
                        <p class="text-sm text-gray-600 mt-1">Customer menandatangani sebagai bukti penerimaan</p>
                    </div>
                    <div class="card-body">
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                            <canvas id="signaturePad" 
                                    class="w-full h-48 bg-white border border-gray-300 rounded cursor-crosshair"
                                    style="touch-action: none;"></canvas>
                            <input type="hidden" name="tanda_tangan" id="signatureData" required>
                        </div>
                        <div class="mt-3 flex justify-between">
                            <button type="button" 
                                    id="clearSignature" 
                                    class="text-sm text-red-600 hover:text-red-700 font-medium">
                                <i class="fas fa-eraser mr-1"></i> Hapus
                            </button>
                            <span class="text-xs text-gray-500">Tanda tangan di area putih</span>
                        </div>
                    </div>
                </div>

                <!-- Checklist -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold">Checklist Penyerahan</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-3">
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Dokumen customer sudah diverifikasi</span>
                            </label>
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Kondisi kendaraan sudah dicek dan difoto</span>
                            </label>
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Kelengkapan kendaraan sudah diperiksa</span>
                            </label>
                            <label class="flex items-start">
                                <input type="checkbox" required class="mt-1 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <span class="ml-2 text-sm text-gray-700">Customer sudah menandatangani</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="w-full btn btn-primary btn-lg">
                            <i class="fas fa-key mr-2"></i>
                            Serahkan Kunci
                        </button>
                        <p class="mt-3 text-xs text-center text-gray-500">
                            Kendaraan akan berstatus "Disewa" setelah kunci diserahkan
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </form>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Signature Pad
    const canvas = document.getElementById('signaturePad');
    const signaturePad = new SignaturePad(canvas, {
        backgroundColor: 'rgb(255, 255, 255)',
        penColor: 'rgb(0, 0, 0)'
    });

    // Resize canvas
    function resizeCanvas() {
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }
    
    window.addEventListener("resize", resizeCanvas);
    resizeCanvas();

    // Clear button
    document.getElementById('clearSignature').addEventListener('click', function() {
        signaturePad.clear();
        document.getElementById('signatureData').value = '';
    });

    // Form submit
    document.getElementById('serahKunciForm').addEventListener('submit', function(e) {
        if (signaturePad.isEmpty()) {
            e.preventDefault();
            alert('Tanda tangan customer diperlukan!');
            return false;
        }
        
        // Save signature as base64
        const dataURL = signaturePad.toDataURL();
        document.getElementById('signatureData').value = dataURL;
    });
});
</script>
@endpush
@endsection
