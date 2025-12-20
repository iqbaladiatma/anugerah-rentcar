<div class="space-y-6">
    <!-- Hidden Input Fields for Form Submission -->
    <input type="hidden" name="customer_id" value="{{ $customer_id }}">
    <input type="hidden" name="car_id" value="{{ $car_id }}">
    <input type="hidden" name="driver_id" value="{{ $driver_id }}">
    <input type="hidden" name="start_date" value="{{ $start_date }}">
    <input type="hidden" name="end_date" value="{{ $end_date }}">
    <input type="hidden" name="pickup_location" value="{{ $pickup_location }}">
    <input type="hidden" name="return_location" value="{{ $return_location }}">
    <input type="hidden" name="with_driver" value="{{ $with_driver ? '1' : '0' }}">
    <input type="hidden" name="is_out_of_town" value="{{ $is_out_of_town ? '1' : '0' }}">
    <input type="hidden" name="out_of_town_fee" value="{{ $out_of_town_fee }}">
    <input type="hidden" name="notes" value="{{ $notes }}">
    
    <!-- Form Section -->
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Pemesanan</h3>
        
        @if(count($customers) === 0 || count($cars) === 0)
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">Data Tidak Tersedia</h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            @if(count($customers) === 0)
                                <p>Tidak ada pelanggan aktif yang tersedia. <a href="{{ route('admin.customers.create') }}" class="font-medium underline">Tambah pelanggan baru</a></p>
                            @endif
                            @if(count($cars) === 0)
                                <p>Tidak ada kendaraan tersedia. <a href="{{ route('admin.vehicles.create') }}" class="font-medium underline">Tambah kendaraan baru</a></p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Customer Selection -->
            <div>
                <label for="customer_id" class="block text-sm font-medium text-gray-700">Pelanggan <span class="text-red-500">*</span></label>
                <select wire:model.live="customer_id" id="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    <option value="">Pilih Pelanggan</option>
                    @foreach($customers as $customer)
                        <option value="{{ $customer['id'] }}">
                            {{ $customer['name'] }} - {{ $customer['phone'] }}
                            @if($customer['is_member']) (Anggota) @endif
                        </option>
                    @endforeach
                </select>
                @if($customer_id)
                    @php $selectedCustomer = $this->getSelectedCustomer(); @endphp
                    @if($selectedCustomer && $selectedCustomer['is_member'])
                        <p class="mt-1 text-sm text-green-600">
                            Diskon Anggota: {{ $selectedCustomer['member_discount'] ?? 10 }}%
                        </p>
                    @endif
                @endif
            </div>

            <!-- Vehicle Selection -->
            <div>
                <label for="car_id" class="block text-sm font-medium text-gray-700">Kendaraan <span class="text-red-500">*</span></label>
                <select wire:model.live="car_id" id="car_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                    <option value="">Pilih Kendaraan</option>
                    @foreach($cars as $car)
                        <option value="{{ $car['id'] }}">
                            {{ $car['license_plate'] }} - {{ $car['brand'] }} {{ $car['model'] }}
                            (Rp {{ number_format($car['daily_rate'], 0, ',', '.') }}/hari)
                        </option>
                    @endforeach
                </select>
                @if($car_id)
                    @php $selectedCar = $this->getSelectedCar(); @endphp
                    @if($selectedCar)
                        <p class="mt-1 text-sm text-gray-600">
                            Harian: Rp {{ number_format($selectedCar['daily_rate'], 0, ',', '.') }} | 
                            Mingguan: Rp {{ number_format($selectedCar['weekly_rate'], 0, ',', '.') }}
                        </p>
                    @endif
                @endif
            </div>

            <!-- Start Date -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai <span class="text-red-500">*</span></label>
                <input wire:model.live="start_date" type="datetime-local" id="start_date" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <!-- End Date -->
            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai <span class="text-red-500">*</span></label>
                <input wire:model.live="end_date" type="datetime-local" id="end_date" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
            </div>

            <!-- Pickup Location -->
            <div>
                <label for="pickup_location" class="block text-sm font-medium text-gray-700">Lokasi Penjemputan <span class="text-red-500">*</span></label>
                <input wire:model.live="pickup_location" type="text" id="pickup_location" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                       placeholder="Masukkan lokasi penjemputan">
            </div>

            <!-- Return Location -->
            <div>
                <label for="return_location" class="block text-sm font-medium text-gray-700">Lokasi Pengembalian <span class="text-red-500">*</span></label>
                <input wire:model.live="return_location" type="text" id="return_location" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                       placeholder="Masukkan lokasi pengembalian">
                    <label for="driver_id" class="block text-sm font-medium text-gray-700">Pilih Sopir</label>
                    <select wire:model.live="driver_id" id="driver_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500">
                        <option value="">Pilih Sopir</option>
                        @foreach($available_drivers as $driver)
                            <option value="{{ $driver['id'] }}">
                                {{ $driver['name'] }} - {{ $driver['phone'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <!-- Out of Town Option -->
            <div class="flex items-center">
                <input wire:model.live="is_out_of_town" type="checkbox" id="is_out_of_town" 
                       class="h-4 w-4 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                <label for="is_out_of_town" class="ml-2 block text-sm text-gray-900">
                    Perjalanan Luar Kota
                </label>
            </div>

            <!-- Out of Town Fee -->
            @if($is_out_of_town)
                <div x-data="{
                    raw: @entangle('out_of_town_fee'),
                    get formatted() {
                        return this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                    },
                    set formatted(value) {
                        this.raw = value.replace(/\D/g, '');
                    }
                }">
                    <label for="out_of_town_fee" class="block text-sm font-medium text-gray-700">Biaya Luar Kota</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm">Rp</span>
                        </div>
                        <input x-model="formatted" type="text" id="out_of_town_fee" 
                               class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                               placeholder="0">
                    </div>
                </div>
            @endif

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea wire:model.live="notes" id="notes" rows="3" 
                          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-orange-500 focus:ring-orange-500"
                          placeholder="Catatan tambahan atau persyaratan khusus"></textarea>
            </div>
        </div>
    </div>

    <!-- Availability Status -->
    @if(!empty($availability))
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Status Ketersediaan</h3>
            
            <div class="flex items-center space-x-2">
                <div class="flex-shrink-0">
                    @if($availability['is_available'])
                        <div class="h-3 w-3 bg-green-500 rounded-full"></div>
                    @else
                        <div class="h-3 w-3 bg-red-500 rounded-full"></div>
                    @endif
                </div>
                <span class="{{ $this->getAvailabilityStatusClass() }} font-medium">
                    {{ $this->getAvailabilityStatusText() }}
                </span>
            </div>

            @if(!empty($availability['conflicts']) && $availability['conflicts']->isNotEmpty())
                <div class="mt-4">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Pemesanan yang Bertentangan:</h4>
                    <div class="space-y-2">
                        @foreach($availability['conflicts'] as $conflict)
                            <div class="text-sm text-red-600 bg-red-50 p-2 rounded">
                                {{ $conflict->booking_number }} - {{ $conflict->customer->name }} 
                                ({{ $conflict->start_date->format('d M Y H:i') }} - {{ $conflict->end_date->format('d M Y H:i') }})
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(!empty($availability['next_available_date']))
                <div class="mt-2 text-sm text-gray-600">
                    Tersedia berikutnya: {{ $availability['next_available_date']->format('d M Y H:i') }}
                </div>
            @endif
        </div>
    @endif

    <!-- Validation Errors -->
    @if(!empty($validation_errors))
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Kesalahan Validasi</h3>
                    <div class="mt-2 text-sm text-red-700">
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach($validation_errors as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Pricing Calculation -->
    @if($show_pricing && !empty($pricing))
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Perhitungan Harga</h3>
            
            <!-- Duration -->
            <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                <div class="text-sm font-medium text-gray-700">Durasi</div>
                <div class="text-lg font-semibold text-gray-900">{{ $this->getDurationText() }}</div>
            </div>

            <!-- Pricing Breakdown -->
            <div class="space-y-3">
                @if(!empty($pricing['breakdown']))
                    @foreach($pricing['breakdown'] as $item)
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
                                    -Rp {{ number_format($pricing['member_discount'], 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($item['amount'], 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif

                <!-- Subtotal -->
                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                    <div class="text-sm font-medium text-gray-900">Subtotal</div>
                    <div class="text-sm font-medium text-gray-900">
                        Rp {{ number_format($pricing['subtotal'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Member Discount -->
                @if(($pricing['member_discount'] ?? 0) > 0)
                    <div class="flex justify-between items-center py-2 border-b border-gray-200">
                        <div class="text-sm font-medium text-green-600">Diskon Anggota</div>
                        <div class="text-sm font-medium text-green-600">
                            -Rp {{ number_format($pricing['member_discount'], 0, ',', '.') }}
                        </div>
                    </div>
                @endif

                <!-- Total Amount -->
                <div class="flex justify-between items-center py-3 border-t-2 border-gray-300">
                    <div class="text-lg font-bold text-gray-900">Total Biaya</div>
                    <div class="text-lg font-bold text-orange-600">
                        Rp {{ number_format($pricing['total_amount'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>

                <!-- Deposit and Remaining -->
                <div class="bg-orange-50 p-4 rounded-lg space-y-2">
                    <div class="flex justify-between items-center">
                        <div class="text-sm font-medium text-orange-900">Deposit Diperlukan (30%)</div>
                        <div class="text-sm font-bold text-orange-900">
                            Rp {{ number_format($pricing['deposit_amount'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-sm font-medium text-orange-900">Sisa Pembayaran</div>
                        <div class="text-sm font-bold text-orange-900">
                            Rp {{ number_format($pricing['remaining_amount'] ?? 0, 0, ',', '.') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Loading State -->
    @if($is_calculating)
        <div class="bg-white shadow rounded-lg p-6">
            <div class="flex items-center justify-center">
                <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-600"></div>
                <span class="ml-2 text-gray-600">Menghitung harga...</span>
            </div>
        </div>
    @endif

    <!-- Action Buttons -->
    <div class="flex justify-end space-x-3">
        <button type="button" wire:click="resetForm" 
                class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
            Reset Formulir
        </button>
    </div>
</div>