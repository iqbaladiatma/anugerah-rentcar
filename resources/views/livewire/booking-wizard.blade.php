<div class="max-w-4xl mx-auto">
    <!-- Progress Indicator -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            @for ($i = 1; $i <= $totalSteps; $i++)
                <div class="flex items-center {{ $i < $totalSteps ? 'flex-1' : '' }}">
                    <div class="flex items-center justify-center w-10 h-10 rounded-full border-2 
                        {{ $currentStep >= $i ? 'bg-accent-500 border-accent-500 text-white' : 'border-gray-300 text-gray-500' }}">
                        @if ($currentStep > $i)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @else
                            {{ $i }}
                        @endif
                    </div>
                    <div class="ml-3 text-sm font-medium {{ $currentStep >= $i ? 'text-accent-600' : 'text-gray-500' }}">
                        @switch($i)
                            @case(1) Booking Details @break
                            @case(2) Customer Info @break
                            @case(3) Documents @break
                            @case(4) Payment @break
                        @endswitch
                    </div>
                    @if ($i < $totalSteps)
                        <div class="flex-1 h-0.5 mx-4 {{ $currentStep > $i ? 'bg-accent-500' : 'bg-gray-300' }}"></div>
                    @endif
                </div>
            @endfor
        </div>
    </div>

    <!-- Vehicle Summary Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-8 border border-gray-100">
        <div class="flex items-center space-x-6">
            @if($car->photo_front)
                <img src="{{ asset('storage/' . $car->photo_front) }}" 
                     alt="{{ $car->brand }} {{ $car->model }}"
                     class="w-24 h-16 object-cover rounded-lg">
            @else
                <div class="w-24 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                    </svg>
                </div>
            @endif
            <div class="flex-1">
                <h3 class="text-lg font-bold text-gray-900">{{ $car->brand }} {{ $car->model }}</h3>
                <p class="text-sm text-gray-600">{{ $car->year }} • {{ $car->color }} • {{ $car->license_plate }}</p>
                <p class="text-sm text-accent-600 font-medium">
                    {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }} ({{ $duration }} days)
                </p>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-accent-600">
                    Rp {{ number_format($pricing['total_amount'] ?? 0, 0, ',', '.') }}
                </div>
                <p class="text-sm text-gray-500">Total Biaya</p>
            </div>
        </div>
    </div>

    <!-- Step Content -->
    <div class="bg-white rounded-xl shadow-lg p-8 border border-gray-100">
        @if ($currentStep === 1)
            <!-- Step 1: Booking Details -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Pemesanan</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pengambilan *</label>
                        <input type="text" wire:model="pickupLocation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                               placeholder="Enter pickup address">
                        @error('pickupLocation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pengembalian *</label>
                        <input type="text" wire:model="returnLocation" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                               placeholder="Enter return address">
                        @error('returnLocation') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6 space-y-4">
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="withDriver" id="withDriver"
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="withDriver" class="ml-3 text-sm font-medium text-gray-700">
                            Termasuk Driver (+Rp {{ number_format($car->driver_fee_per_day, 0, ',', '.') }}/day)
                        </label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" wire:model="isOutOfTown" id="isOutOfTown"
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        <label for="isOutOfTown" class="ml-3 text-sm font-medium text-gray-700">
                            Perjalanan Luar Kota (Biaya tambahan mungkin berlaku)
                        </label>
                    </div>
                </div>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Khusus (Opsional)</label>
                    <textarea wire:model="notes" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                              placeholder="Catatan khusus..."></textarea>
                </div>

                <!-- Pricing Breakdown -->
                <div class="mt-8 bg-gray-50 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Penjelasan Biaya</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Biaya Dasar ({{ $duration }} hari)</span>
                            <span class="font-medium">Rp {{ number_format($pricing['base_amount'] ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if($withDriver && ($pricing['driver_fee'] ?? 0) > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Driver</span>
                                <span class="font-medium">Rp {{ number_format($pricing['driver_fee'], 0, ',', '.') }}</span>
                            </div>
                        @endif
                        @if($isOutOfTown && ($pricing['out_of_town_fee'] ?? 0) > 0)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Biaya Luar Kota</span>
                                <span class="font-medium">Rp {{ number_format($pricing['out_of_town_fee'], 0, ',', '.') }}</span>
                            </div>
                        @endif
                        <div class="border-t pt-2">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total Biaya</span>
                                <span class="text-accent-600">Rp {{ number_format($pricing['total_amount'] ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Verifikasi Identitas</h2>
                <p class="text-gray-600 mb-8">Silahkan unggah foto dokumen identitas Anda untuk verifikasi.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- KTP Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">KTP (Kartu Tanda Penduduk) *</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            @if ($ktpPhoto)
                                <div class="space-y-4">
                                    <img src="{{ $ktpPhoto->temporaryUrl() }}" class="mx-auto max-h-40 rounded-lg shadow-md">
                                    <button type="button" wire:click="$set('ktpPhoto', null)" 
                                            class="text-sm text-red-600 hover:text-red-800">
                                        Hapus Foto
                                    </button>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div>
                                        <label for="ktpPhoto" class="cursor-pointer">
                                            <span class="text-blue-600 hover:text-blue-800 font-medium">Unggah Foto KTP</span>
                                            <input id="ktpPhoto" type="file" wire:model="ktpPhoto" accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('ktpPhoto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- SIM Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">SIM (Driving License) *</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            @if ($simPhoto)
                                <div class="space-y-4">
                                    <img src="{{ $simPhoto->temporaryUrl() }}" class="mx-auto max-h-40 rounded-lg shadow-md">
                                    <button type="button" wire:click="$set('simPhoto', null)" 
                                            class="text-sm text-red-600 hover:text-red-800">
                                        Hapus Foto
                                    </button>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div>
                                        <label for="simPhoto" class="cursor-pointer">
                                            <span class="text-blue-600 hover:text-blue-800 font-medium">Unggah Foto SIM</span>
                                            <input id="simPhoto" type="file" wire:model="simPhoto" accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('simPhoto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Persyaratan Dokumen</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Foto harus jelas dan mudah dibaca</li>
                                    <li>Dokumen harus valid dan tidak habis masa berlaku</li>
                                    <li>File harus berformat JPG atau PNG, maksimum 2MB</li>
                                    <li>Your information will be kept secure and confidential</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif ($currentStep === 3)
            <!-- Step 3: Document Upload -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Verifikasi Identitas</h2>
                <p class="text-gray-600 mb-8">Silahkan unggah foto dokumen identitas Anda untuk verifikasi.</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- KTP Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">KTP (Kartu Tanda Penduduk) *</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            @if ($ktpPhoto)
                                <div class="space-y-4">
                                    <img src="{{ $ktpPhoto->temporaryUrl() }}" class="mx-auto max-h-40 rounded-lg shadow-md">
                                    <button type="button" wire:click="$set('ktpPhoto', null)" 
                                            class="text-sm text-red-600 hover:text-red-800">
                                        Hapus Foto
                                    </button>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div>
                                        <label for="ktpPhoto" class="cursor-pointer">
                                            <span class="text-blue-600 hover:text-blue-800 font-medium">Unggah Foto KTP</span>
                                            <input id="ktpPhoto" type="file" wire:model="ktpPhoto" accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('ktpPhoto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <!-- SIM Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-4">SIM (Driving License) *</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-blue-400 transition-colors">
                            @if ($simPhoto)
                                <div class="space-y-4">
                                    <img src="{{ $simPhoto->temporaryUrl() }}" class="mx-auto max-h-40 rounded-lg shadow-md">
                                    <button type="button" wire:click="$set('simPhoto', null)" 
                                            class="text-sm text-red-600 hover:text-red-800">
                                        Hapus Foto
                                    </button>
                                </div>
                            @else
                                <div class="space-y-4">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    <div>
                                        <label for="simPhoto" class="cursor-pointer">
                                            <span class="text-blue-600 hover:text-blue-800 font-medium">Unggah Foto SIM</span>
                                            <input id="simPhoto" type="file" wire:model="simPhoto" accept="image/*" class="hidden">
                                        </label>
                                        <p class="text-xs text-gray-500 mt-1">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @error('simPhoto') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex">
                        <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Persyaratan Dokumen</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Foto harus jelas dan mudah dibaca</li>
                                    <li>Dokumen harus valid dan tidak habis masa berlaku</li>
                                    <li>File harus berformat JPG atau PNG, maksimum 2MB</li>
                                    <li>Your information will be kept secure and confidential</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @elseif ($currentStep === 4)
            <!-- Step 4: Payment Method -->
            <div>
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Informasi Pembayaran</h2>
                
                <div class="space-y-6">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Pilih Metode Pembayaran</h3>
                        <div class="space-y-3">
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" wire:model="paymentMethod" value="bank_transfer" 
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Transfer Bank</div>
                                    <div class="text-sm text-gray-600">Transfer ke rekening bank kami</div>
                                </div>
                            </label>
                            
                            <label class="flex items-center p-4 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                                <input type="radio" wire:model="paymentMethod" value="cash" 
                                       class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Cash</div>
                                    <div class="text-sm text-gray-600">Bayar tunai saat pengambilan</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    @if($paymentMethod === 'bank_transfer')
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Instruksi Transfer Bank</h4>
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Bank:</span>
                                    <span class="ml-2 text-sm text-gray-900">Bank BCA</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Nomor Rekening:</span>
                                    <span class="ml-2 text-sm text-gray-900 font-mono">1234567890</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Nama Rekening:</span>
                                    <span class="ml-2 text-sm text-gray-900">PT Anugerah Rentcar</span>
                                </div>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Jumlah:</span>
                                    <span class="ml-2 text-sm text-gray-900 font-semibold">Rp {{ number_format($pricing['deposit_amount'] ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                                <p class="text-sm text-yellow-800">
                                    <strong>Perhatian:</strong> Transfer deposit untuk konfirmasi pemesanan. 
                                    Sisa pembayaran dapat dibayar saat pengambilan.
                                </p>
                            </div>
                        </div>
                    @elseif($paymentMethod === 'cash')
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Instruksi Cash</h4>
                            <div class="space-y-3">
                                <p class="text-sm text-gray-700">
                                    Anda dapat membayar total harga dengan uang tunai saat mengambil mobil. 
                                    Bawa uang yang tepat atau siapkan kembalian.
                                </p>
                                <div>
                                    <span class="text-sm font-medium text-gray-700">Total:</span>
                                    <span class="ml-2 text-sm text-gray-900 font-semibold">Rp {{ number_format($pricing['total_amount'] ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                            <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                <p class="text-sm text-blue-800">
                                    <strong>Perhatian:</strong> Pemesanan Anda akan segera dikonfirmasi. 
                                    Silakan hadir tepat waktu saat mengambil mobil.
                                </p>
                            </div>
                        </div>
                    @endif

                    <!-- Final Summary -->
                    <div class="bg-white border border-gray-200 rounded-lg p-6">
                        <h4 class="font-semibold text-gray-900 mb-4">Ringkasan Pemesanan</h4>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Mobil:</span>
                                <span class="font-medium">{{ $car->brand }} {{ $car->model }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Durasi:</span>
                                <span class="font-medium">{{ $duration }} hari</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pengambilan:</span>
                                <span class="font-medium">{{ $pickupLocation }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Pengembalian:</span>
                                <span class="font-medium">{{ $returnLocation }}</span>
                            </div>
                            @if($withDriver)
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Driver:</span>
                                    <span class="font-medium text-green-600">Termasuk</span>
                                </div>
                            @endif
                            <div class="border-t pt-2 mt-4">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Total:</span>
                                    <span class="text-blue-600">Rp {{ number_format($pricing['total_amount'] ?? 0, 0, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Navigation Buttons -->
        <div class="flex justify-between mt-8 pt-6 border-t border-gray-200">
            <button type="button" wire:click="previousStep" 
                    class="px-6 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium
                           {{ $currentStep === 1 ? 'invisible' : '' }}">
                <svg class="w-4 h-4 inline mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
                Sebelumnya
            </button>

            @if ($currentStep < $totalSteps)
                <button type="button" wire:click="nextStep" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium shadow-md hover:shadow-lg">
                    Selanjutnya
                    <svg class="w-4 h-4 inline ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            @else
                <button type="button" wire:click="completeBooking" 
                        class="px-8 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-medium shadow-md hover:shadow-lg">
                    Selesaikan Pemesanan
                    <svg class="w-4 h-4 inline ml-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </button>
            @endif
        </div>
    </div>
</div>