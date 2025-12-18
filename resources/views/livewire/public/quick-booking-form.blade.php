<div class="space-y-4">
    <!-- Quick Availability Check -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pick Up</label>
            <input type="date" wire:model.live="startDate" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                   min="{{ date('Y-m-d') }}">
            @error('startDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Drop Off</label>
            <input type="date" wire:model.live="endDate" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
            @error('endDate') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
        </div>
    </div>

    <!-- Options -->
    <div class="flex flex-wrap gap-4">
        @if($car->driver_fee_per_day > 0)
            <label class="flex items-center space-x-2">
                <input type="checkbox" wire:model.live="withDriver" class="w-4 h-4 text-accent-600 border-gray-300 rounded focus:ring-accent-500">
                <span class="text-sm text-gray-700">Dengan Driver (+Rp {{ number_format($car->driver_fee_per_day, 0, ',', '.') }}/hari)</span>
            </label>
        @endif
        
        <label class="flex items-center space-x-2">
            <input type="checkbox" wire:model.live="outOfTown" class="w-4 h-4 text-accent-600 border-gray-300 rounded focus:ring-accent-500">
            <span class="text-sm text-gray-700">Luar Kota (+Rp 100,000)</span>
        </label>
    </div>

    <!-- Loading State -->
    <div wire:loading wire:target="startDate,endDate,withDriver,outOfTown" class="flex items-center justify-center py-4">
        <div class="flex items-center space-x-2 text-accent-600">
            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-sm">Mencari Ketersediaan...</span>
        </div>
    </div>

    <!-- Availability Result -->
    @if($availability && !$isChecking)
        @if($availability['is_available'])
            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <h4 class="text-lg font-semibold text-green-800">Tersedia!</h4>
                </div>
                
                @if($pricing)
                    <div class="space-y-2 text-sm text-green-700 mb-4">
                        <p><strong>Duration:</strong> {{ $pricing['duration'] }} day{{ $pricing['duration'] > 1 ? 's' : '' }}</p>
                        <p><strong>Harga Dasar:</strong> Rp {{ number_format($pricing['base_amount'], 0, ',', '.') }}</p>
                        @if($pricing['driver_fee'] > 0)
                            <p><strong>Biaya Driver:</strong> Rp {{ number_format($pricing['driver_fee'], 0, ',', '.') }}</p>
                        @endif
                        @if($pricing['out_of_town_fee'] > 0)
                            <p><strong>Biaya Luar Kota:</strong> Rp {{ number_format($pricing['out_of_town_fee'], 0, ',', '.') }}</p>
                        @endif
                        @if($pricing['member_discount'] > 0)
                            <p><strong>Diskon Member:</strong> -Rp {{ number_format($pricing['member_discount'], 0, ',', '.') }}</p>
                        @endif
                        <div class="border-t border-green-200 pt-2 mt-2">
                            <p class="text-lg font-bold text-green-800">
                                <strong>Total Harga: Rp {{ number_format($pricing['total_amount'], 0, ',', '.') }}</strong>
                            </p>
                        </div>
                    </div>
                @endif
                
                <button wire:click="toggleBookingForm" 
                        class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition-colors font-medium">
                    {{ $showBookingForm ? 'Hide Booking Form' : 'Book This Vehicle' }}
                </button>
            </div>
        @else
            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-center mb-3">
                    <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    <h4 class="text-lg font-semibold text-red-800">Tidak Tersedia</h4>
                </div>
                <p class="text-sm text-red-700 mb-4">
                    Kendaraan ini tidak tersedia untuk tanggal yang dipilih. 
                    @if(isset($availability['next_available_date']))
                        Tersedia lagi: {{ \Carbon\Carbon::parse($availability['next_available_date'])->format('M d, Y') }}
                    @endif
                </p>
                <a href="{{ route('vehicles.catalog') }}?start_date={{ $startDate }}&end_date={{ $endDate }}" 
                   class="inline-flex items-center px-4 py-2 bg-accent-500 text-white rounded-lg hover:bg-accent-600 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"/>
                    </svg>
                    Temukan Kendaraan Alternatif
                </a>
            </div>
        @endif
    @endif

    <!-- Booking Form -->
    @if($showBookingForm && $availability && $availability['is_available'])
        <div class="bg-accent-50 border border-accent-200 rounded-lg p-6 mt-4">
            <h4 class="text-lg font-semibold text-accent-900 mb-4">Lengkapi Pemesanan Anda</h4>
            
            <form wire:submit="submitBooking" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Pick Up</label>
                        <input type="text" wire:model="pickupLocation" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                               placeholder="Masukkan Lokasi Pick Up">
                        @error('pickupLocation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Drop Off</label>
                        <input type="text" wire:model="returnLocation" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                               placeholder="Masukkan Lokasi Drop Off">
                        @error('returnLocation') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan Khusus (Opsional)</label>
                    <textarea wire:model="notes" rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-accent-500 focus:border-transparent"
                              placeholder="Catatan Khusus (Opsional)"></textarea>
                    @error('notes') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                
                <div class="flex space-x-3">
                    <button type="submit" 
                            class="flex-1 bg-accent-500 text-white py-3 px-4 rounded-lg hover:bg-accent-600 transition-colors font-medium">
                        <span wire:loading.remove wire:target="submitBooking">Lanjutkan ke Pemesanan</span>
                        <span wire:loading wire:target="submitBooking" class="flex items-center justify-center">
                            <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                    <button type="button" wire:click="toggleBookingForm"
                            class="px-4 py-3 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    @endif

    <!-- Flash Messages -->
    @if (session()->has('error'))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <p class="text-sm text-red-800">{{ session('error') }}</p>
            </div>
        </div>
    @endif
</div>