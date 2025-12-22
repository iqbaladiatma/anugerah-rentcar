<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.customer') }}" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 sm:gap-4">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" id="start_date" 
                                       value="{{ request('start_date', now()->subYear()->format('Y-m-d')) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" id="end_date" 
                                       value="{{ request('end_date', now()->format('Y-m-d')) }}"
                                       class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                            </div>
                            <div>
                                <label for="member_status" class="block text-sm font-medium text-gray-700 mb-1">Status Member</label>
                                <select name="member_status" id="member_status" 
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 text-sm">
                                    <option value="all" {{ request('member_status') === 'all' ? 'selected' : '' }}>Semua</option>
                                    <option value="members" {{ request('member_status') === 'members' ? 'selected' : '' }}>Member</option>
                                    <option value="non_members" {{ request('member_status') === 'non_members' ? 'selected' : '' }}>Non-Member</option>
                                </select>
                            </div>
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="w-full inline-flex justify-center items-center px-4 py-2 bg-accent-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-accent-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 mr-1.5 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    Generate
                                </button>
                            </div>
                            <div class="flex items-end gap-2">
                                <a href="{{ route('admin.reports.customer', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">Excel</span>
                                </a>
                                <a href="{{ route('admin.reports.customer', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                                   class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 transition ease-in-out duration-150">
                                    <svg class="h-4 w-4 sm:mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="hidden sm:inline">PDF</span>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($reportData))
            <!-- Summary Statistics -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">
                        Summary 
                        <span class="block sm:inline text-xs sm:text-sm text-gray-500 font-normal mt-1 sm:mt-0">
                            ({{ $reportData['period']['start_date'] }} - {{ $reportData['period']['end_date'] }})
                        </span>
                    </h3>
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-blue-600">{{ number_format($reportData['summary']['total_customers']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Total Pelanggan</div>
                        </div>
                        <div class="text-center p-3 bg-green-50 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-green-600">{{ number_format($reportData['summary']['active_customers']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Pelanggan Aktif</div>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-purple-600">{{ number_format($reportData['summary']['member_customers']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Member</div>
                        </div>
                        <div class="text-center p-3 bg-red-50 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-red-600">{{ number_format($reportData['summary']['blacklisted_customers']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Diblokir</div>
                        </div>
                        <div class="text-center p-3 bg-indigo-50 rounded-lg">
                            <div class="text-lg sm:text-2xl font-bold text-indigo-600">{{ number_format($reportData['summary']['total_bookings']) }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Peminjaman</div>
                        </div>
                        <div class="text-center p-3 bg-yellow-50 rounded-lg">
                            <div class="text-sm sm:text-xl font-bold text-yellow-600">Rp {{ number_format($reportData['summary']['total_revenue'], 0, ',', '.') }}</div>
                            <div class="text-xs sm:text-sm text-gray-500">Pendapatan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6">
                    <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">Detail Pelanggan</h3>
                    
                    <!-- Mobile Card View -->
                    <div class="block lg:hidden space-y-3">
                        @forelse($reportData['customers'] as $customerData)
                        <div class="border rounded-lg p-4 {{ $loop->iteration % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <div class="font-medium text-gray-900">{{ $customerData['customer']->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $customerData['customer']->phone }}</div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    @if($customerData['customer']->is_member)
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">Member</span>
                                    @endif
                                    @if($customerData['customer']->is_blacklisted)
                                        <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-red-100 text-red-800">Diblokir</span>
                                    @endif
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <div class="text-xs text-gray-500">Peminjaman</div>
                                    <div class="font-medium">{{ $customerData['total_bookings'] }} ({{ $customerData['completed_bookings'] }} selesai)</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Pendapatan</div>
                                    <div class="font-medium">Rp {{ number_format($customerData['total_revenue'], 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Rata-rata</div>
                                    <div class="font-medium">Rp {{ number_format($customerData['average_booking_value'], 0, ',', '.') }}</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-500">Terakhir</div>
                                    <div class="font-medium">{{ $customerData['last_booking_date'] ? \Carbon\Carbon::parse($customerData['last_booking_date'])->format('d M Y') : '-' }}</div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">Tidak ada pelanggan ditemukan.</div>
                        @endforelse
                    </div>
                    
                    <!-- Desktop Table View -->
                    <div class="hidden lg:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjaman</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Rata-rata</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frekuensi</th>
                                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Terakhir</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reportData['customers'] as $customerData)
                                <tr>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $customerData['customer']->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $customerData['customer']->phone }}</div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            @if($customerData['customer']->is_member)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Member</span>
                                            @endif
                                            @if($customerData['customer']->is_blacklisted)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Diblokir</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customerData['total_bookings'] }} total<br>
                                        <span class="text-xs text-gray-500">{{ $customerData['completed_bookings'] }} selesai</span>
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($customerData['total_revenue'], 0, ',', '.') }}<br>
                                        @if($customerData['total_discount_given'] > 0)
                                            <span class="text-xs text-green-600">-Rp {{ number_format($customerData['total_discount_given'], 0, ',', '.') }}</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($customerData['average_booking_value'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customerData['booking_frequency'] }}
                                    </td>
                                    <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customerData['last_booking_date'] ? \Carbon\Carbon::parse($customerData['last_booking_date'])->format('d M Y') : '-' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-sm text-gray-500">
                                        Tidak ada pelanggan ditemukan untuk kriteria yang dipilih.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-admin-layout>