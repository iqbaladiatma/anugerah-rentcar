<div class="space-y-6">
    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ $statistics['total'] }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $statistics['total'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ $statistics['pending'] }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Menunggu</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $statistics['pending'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ $statistics['confirmed'] }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Dikonfirmasi</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $statistics['confirmed'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ $statistics['active'] }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Aktif</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $statistics['active'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-gray-400 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ $statistics['completed'] }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Selesai</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $statistics['completed'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <span class="text-white text-sm font-medium">{{ $statistics['overdue'] }}</span>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Terlambat</dt>
                            <dd class="text-lg font-medium text-gray-900">{{ $statistics['overdue'] }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">Cari Pemesanan</h3>
                <button wire:click="toggleFilters" type="button" 
                        class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707v4.586l-4-2v-2.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    {{ $show_filters ? 'Sembunyikan Filter' : 'Tampilkan Filter' }}
                </button>
            </div>
        </div>

        <div class="p-6 space-y-4">
            <!-- Basic Search -->
            <div class="flex space-x-4">
                <div class="flex-1">
                    <input wire:model="search" type="text" placeholder="Cari berdasarkan nomor pemesanan, nama pelanggan, telepon, atau kendaraan..." 
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="flex-shrink-0">
                    <select wire:model="sort_by" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @foreach($this->getSortOptions() as $value => $label)
                            <option value="{{ $value }}">Urutkan berdasarkan {{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex-shrink-0">
                    <button wire:click="sortBy('{{ $sort_by }}')" type="button" 
                            class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        @if($sort_direction === 'asc')
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                            </svg>
                        @else
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        @endif
                    </button>
                </div>
            </div>

            <!-- Advanced Filters -->
            @if($show_filters)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-4 border-t border-gray-200">
                    <!-- Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select wire:model="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($this->getStatusOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Customer Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pelanggan</label>
                        <select wire:model="customer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Pelanggan</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer['id'] }}">{{ $customer['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Vehicle Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Kendaraan</label>
                        <select wire:model="car_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Semua Kendaraan</option>
                            @foreach($cars as $car)
                                <option value="{{ $car['id'] }}">{{ $car['license_plate'] }} - {{ $car['brand'] }} {{ $car['model'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Payment Status Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status Pembayaran</label>
                        <select wire:model="payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @foreach($this->getPaymentStatusOptions() as $value => $label)
                                <option value="{{ $value }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Start Date Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Mulai Dari</label>
                        <input wire:model="start_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- End Date Filter -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tanggal Selesai Sampai</label>
                        <input wire:model="end_date" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Checkboxes -->
                    <div class="space-y-2">
                        <div class="flex items-center">
                            <input wire:model="overdue_only" type="checkbox" id="overdue_only" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="overdue_only" class="ml-2 block text-sm text-gray-900">Hanya yang terlambat</label>
                        </div>
                        <div class="flex items-center">
                            <input wire:model="with_driver_only" type="checkbox" id="with_driver_only" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                            <label for="with_driver_only" class="ml-2 block text-sm text-gray-900">Hanya dengan sopir</label>
                        </div>
                    </div>

                    <!-- Clear Filters -->
                    <div class="flex items-end">
                        <button wire:click="clearFilters" type="button" 
                                class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Hapus Filter
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Results -->
    <div class="bg-white shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900">
                    Hasil Pencarian ({{ $filtered_count }} ditemukan)
                </h3>
                <div class="flex items-center space-x-2">
                    <label class="text-sm text-gray-700">Tampilkan:</label>
                    <select wire:model="per_page" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th wire:click="sortBy('booking_number')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                No. Pemesanan
                                @if($sort_by === 'booking_number')
                                    @if($sort_direction === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kendaraan</th>
                            <th wire:click="sortBy('start_date')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Tanggal
                                @if($sort_by === 'start_date')
                                    @if($sort_direction === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th wire:click="sortBy('total_amount')" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer hover:bg-gray-100">
                                Jumlah
                                @if($sort_by === 'total_amount')
                                    @if($sort_direction === 'asc') ↑ @else ↓ @endif
                                @endif
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pembayaran</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($bookings as $booking)
                            <tr class="hover:bg-gray-50 {{ $this->isOverdue($booking) ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->booking_number }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->created_at->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->customer->phone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $booking->car->license_plate }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->car->brand }} {{ $booking->car->model }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $booking->start_date->format('d M Y H:i') }}</div>
                                    <div class="text-sm text-gray-500">{{ $booking->end_date->format('d M Y H:i') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $this->formatCurrency($booking->total_amount) }}</div>
                                    @if($booking->with_driver)
                                        <div class="text-xs text-blue-600">Dengan Sopir</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getStatusBadgeClass($booking->booking_status) }}">
                                        {{ ucfirst($booking->booking_status) }}
                                    </span>
                                    @if($this->isOverdue($booking))
                                        <div class="text-xs text-red-600 mt-1">Terlambat</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $this->getPaymentStatusBadgeClass($booking->payment_status) }}">
                                        {{ ucfirst($booking->payment_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('admin.bookings.show', $booking) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $bookings->links() }}
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada pemesanan ditemukan</h3>
                <p class="mt-1 text-sm text-gray-500">Coba sesuaikan kriteria pencarian atau filter Anda.</p>
            </div>
        @endif
    </div>
</div>