<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Laporan Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.customer') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                        <div>
                            <label for="start_date" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" 
                                   value="{{ request('start_date', now()->subYear()->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="end_date" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="end_date" id="end_date" 
                                   value="{{ request('end_date', now()->format('Y-m-d')) }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                        </div>
                        <div>
                            <label for="member_status" class="block text-sm font-medium text-gray-700">Status Member</label>
                            <select name="member_status" id="member_status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="all" {{ request('member_status') === 'all' ? 'selected' : '' }}>Semua Pelanggan</option>
                                <option value="members" {{ request('member_status') === 'members' ? 'selected' : '' }}>Member Hanya</option>
                                <option value="non_members" {{ request('member_status') === 'non_members' ? 'selected' : '' }}>Non-Member Hanya</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Generate Laporan
                            </button>
                        </div>
                        <div class="flex items-end space-x-2">
                            <a href="{{ route('admin.reports.customer', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Excel
                            </a>
                            <a href="{{ route('admin.reports.customer', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                               class="flex-1 inline-flex justify-center items-center px-3 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            @if(isset($reportData))
            <!-- Summary Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">
                        Summary ({{ $reportData['period']['start_date'] }} to {{ $reportData['period']['end_date'] }})
                    </h3>
                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ number_format($reportData['summary']['total_customers']) }}</div>
                            <div class="text-sm text-gray-500">Total Pelanggan</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ number_format($reportData['summary']['active_customers']) }}</div>
                            <div class="text-sm text-gray-500">Pelanggan Aktif</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ number_format($reportData['summary']['member_customers']) }}</div>
                            <div class="text-sm text-gray-500">Member Hanya</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-red-600">{{ number_format($reportData['summary']['blacklisted_customers']) }}</div>
                            <div class="text-sm text-gray-500">Pelanggan Diblokir</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-indigo-600">{{ number_format($reportData['summary']['total_bookings']) }}</div>
                            <div class="text-sm text-gray-500">Total Peminjaman</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-yellow-600">Rp {{ number_format($reportData['summary']['total_revenue'], 0, ',', '.') }}</div>
                            <div class="text-sm text-gray-500">Total Pendapatan</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detail Pelanggan</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pelanggan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjaman</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pendapatan</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nilai Rata-rata</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frekuensi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjaman Terakhir</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($reportData['customers'] as $customerData)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $customerData['customer']->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $customerData['customer']->phone }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex flex-col space-y-1">
                                            @if($customerData['customer']->is_member)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Member</span>
                                            @endif
                                            @if($customerData['customer']->is_blacklisted)
                                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Pelanggan Diblokir</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customerData['total_bookings'] }} total<br>
                                        <span class="text-xs text-gray-500">{{ $customerData['completed_bookings'] }} completed</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($customerData['total_revenue'], 0, ',', '.') }}<br>
                                        @if($customerData['total_discount_given'] > 0)
                                            <span class="text-xs text-green-600">-Rp {{ number_format($customerData['total_discount_given'], 0, ',', '.') }} discount</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        Rp {{ number_format($customerData['average_booking_value'], 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customerData['booking_frequency'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $customerData['last_booking_date'] ? \Carbon\Carbon::parse($customerData['last_booking_date'])->format('M d, Y') : 'Never' }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
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