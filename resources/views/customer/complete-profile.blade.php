<x-public-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-100 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-r from-amber-500 to-amber-600 rounded-full mb-4">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-2">
                    Lengkapi Profil Anda
                </h2>
                <p class="text-gray-600 max-w-lg mx-auto">
                    Untuk dapat menggunakan semua fitur, silakan lengkapi biodata Anda terlebih dahulu.
                </p>
            </div>

            <!-- Alert Warning -->
            <div class="mb-6">
                <div class="rounded-lg bg-amber-50 p-4 border-l-4 border-amber-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-amber-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-amber-700 font-medium">
                                Dashboard dan fitur lainnya dikunci sampai Anda melengkapi profil ini.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-xl shadow-xl p-8">
                <form action="{{ route('customer.complete-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <!-- Current Name (Read Only) -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap (Terdaftar)
                        </label>
                        <p class="text-gray-900 font-semibold">{{ $customer->name }}</p>
                        <p class="text-xs text-gray-500 mt-1">Email: {{ $customer->email }}</p>
                    </div>

                    <!-- Phone Field -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon <span class="text-red-500">*</span>
                        </label>
                        <input id="phone" name="phone" type="tel" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="Contoh: 08123456789" value="{{ old('phone', $customer->phone) }}">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Nomor yang dapat dihubungi</p>
                    </div>

                    <!-- NIK Field -->
                    <div>
                        <label for="nik" class="block text-sm font-medium text-gray-700 mb-2">
                            NIK (Nomor Induk Kependudukan) <span class="text-red-500">*</span>
                        </label>
                        <input id="nik" name="nik" type="text" maxlength="16" required 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                               placeholder="16 digit NIK sesuai KTP" value="{{ old('nik', $customer->nik) }}">
                        @error('nik')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Harus 16 digit sesuai KTP</p>
                    </div>

                    <!-- Address Field -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                            Alamat Lengkap <span class="text-red-500">*</span>
                        </label>
                        <textarea id="address" name="address" rows="3" required 
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" 
                                  placeholder="Masukkan alamat lengkap sesuai KTP">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Alamat domisili saat ini</p>
                    </div>

                    <!-- File Upload Section -->
                    <div class="border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Upload Dokumen Identitas</h3>
                        <p class="text-sm text-gray-600 mb-4">Unggah foto KTP, SIM, dan Kartu Keluarga (KK) untuk verifikasi identitas.</p>
                        
                        <!-- KTP Photo -->
                        <div class="mb-6">
                            <label for="ktp_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto KTP <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="ktp_photo" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                    <input id="ktp_photo" name="ktp_photo" type="file" class="hidden" accept="image/*" required />
                                </label>
                            </div>
                            @error('ktp_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- SIM Photo -->
                        <div class="mb-6">
                            <label for="sim_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto SIM <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="sim_photo" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                    <input id="sim_photo" name="sim_photo" type="file" class="hidden" accept="image/*" required />
                                </label>
                            </div>
                            @error('sim_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- KK Photo (Kartu Keluarga) -->
                        <div>
                            <label for="kk_photo" class="block text-sm font-medium text-gray-700 mb-2">
                                Foto Kartu Keluarga (KK) <span class="text-red-500">*</span>
                            </label>
                            <div class="flex items-center justify-center w-full">
                                <label for="kk_photo" class="flex flex-col items-center justify-center w-full h-48 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                        <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                    <input id="kk_photo" name="kk_photo" type="file" class="hidden" accept="image/*" required />
                                </label>
                            </div>
                            @error('kk_photo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Privacy Notice -->
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Data pribadi Anda akan kami jaga kerahasiaannya dan hanya digunakan untuk keperluan verifikasi dan transaksi.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Error Messages -->
                    @if ($errors->any())
                        <div class="rounded-lg bg-red-50 p-4 border border-red-200">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">
                                        Mohon perbaiki kesalahan pada form
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Submit Button -->
                    <div class="flex gap-4">
                        <button type="submit" 
                                class="flex-1 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            <span class="flex items-center justify-center">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan & Lanjutkan
                            </span>
                        </button>
                    </div>

                    <!-- Required Fields Note -->
                    <p class="text-xs text-gray-500 text-center">
                        <span class="text-red-500">*</span> = Wajib diisi
                    </p>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        function setupPreview(inputId) {
            const input = document.getElementById(inputId);
            if (!input) return;

            input.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        const label = e.target.closest('label');
                        label.style.backgroundImage = `url(${event.target.result})`;
                        label.style.backgroundSize = 'cover';
                        label.style.backgroundPosition = 'center';
                        
                        // Hide the default upload prompt
                        const promptDiv = label.querySelector('div');
                        if (promptDiv) {
                            promptDiv.style.display = 'none';
                        }
                        
                        // Add or update a success indicator
                        let successMsg = label.parentNode.querySelector('.upload-success-msg');
                        if (!successMsg) {
                            successMsg = document.createElement('p');
                            successMsg.className = 'upload-success-msg mt-2 text-sm text-green-600 font-medium text-center absolute -bottom-8 w-full';
                            // Ensure parent is relative for absolute positioning or just append it
                            // Let's just append it to the parent container which is a flex column usually
                            // The parent is <div class="flex items-center justify-center w-full">
                            // We should probably change the parent to flex-col to stack them nicely
                            label.parentNode.classList.add('flex-col');
                            successMsg.className = 'upload-success-msg mt-2 text-sm text-green-600 font-medium';
                            label.parentNode.appendChild(successMsg);
                        }
                        successMsg.textContent = `File terpilih: ${file.name}`;
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            setupPreview('ktp_photo');
            setupPreview('sim_photo');
            setupPreview('kk_photo');
        });
    </script>
    @endpush
</x-public-layout>
