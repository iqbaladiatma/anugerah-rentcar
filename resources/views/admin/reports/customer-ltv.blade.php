<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Laporan Nilai Hidup Pelanggan') }}</h2>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Filters -->
            <div class="bg-white shadow-sm rounded-lg mb-4 sm:mb-6">
                <div class="p-4 sm:p-6">
                    <h3 class="text-base sm:text-lg font-medium text-gray-900 mb-4">Filter Laporan</h3>
                    <form method="GET" action="{{ route('admin.reports.customer-ltv') }}">
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                            <div class="flex items-end">
                                <button type="submit" class="w-full px-4 py-2 bg-accent-600 rounded-md text-xs text-white uppercase font-semibold hover:bg-accent-700">
                                    Hasilkan Laporan
                                </button>
                            </div>
                            <div class="flex items-end gap-2 sm:col-span-2">
                                <a href="{{ route('admin.reports.customer-ltv', array_merge(request()->all(), ['format' => 'excel'])) }}" 
                                   class="flex-1 px-3 py-2 bg-green-600 rounded-md text-xs text-white text-center uppercase font-semibold hover:bg-green-700">Excel</a>
                                <a href="{{ route('admin.reports.customer-ltv', array_merge(request()->all(), ['format' => 'pdf'])) }}" 
                                   class="flex-1 px-3 py-2 bg-red-600 rounded-md text-xs text-white text-center uppercase font-semibold hover:bg-red-700">PDF</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-4 sm:mb-6">
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="flex items-center">
                        <div class="hidden sm:flex h-10 w-10 rounded-full bg-blue-100 items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs sm:text-sm text-gray-500">Total Pelanggan</div>
                            <div class="text-lg font-bold">{{ number_format($reportData['summary']['total_customers']) }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="flex items-center">
                        <div class="hidden sm:flex h-10 w-10 rounded-full bg-green-100 items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs sm:text-sm text-gray-500">Total LTV</div>
                            <div class="text-sm sm:text-lg font-bold">Rp {{ number_format($reportData['summary']['total_lifetime_value'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="flex items-center">
                        <div class="hidden sm:flex h-10 w-10 rounded-full bg-purple-100 items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs sm:text-sm text-gray-500">Rata-rata LTV</div>
                            <div class="text-sm sm:text-lg font-bold">Rp {{ number_format($reportData['summary']['average_lifetime_value'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
                <div class="bg-white shadow-sm rounded-lg p-3 sm:p-4">
                    <div class="flex items-center">
                        <div class="hidden sm:flex h-10 w-10 rounded-full bg-yellow-100 items-center justify-center mr-3">
                            <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                        </div>
                        <div>
                            <div class="text-xs sm:text-sm text-gray-500">Top 10%</div>
                            <div class="text-sm sm:text-lg font-bold">Rp {{ number_format($reportData['summary']['top_10_percent_value'], 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Customer LTV Table -->
            <div class="bg-white shadow-sm rounded-lg p-4 sm:p-6">
                <h3 class="text-sm sm:text-lg font-medium text-gray-900 mb-4">Detail Nilai Hidup Pelanggan</h3>
                
                <!-- Mobile Card View -->
                <div class="block lg:hidden space-y-3">
                    @forelse($reportData['customers'] as $customerData)
                    @php
                        $customer = $customerData['customer'];
                        $ltv = $customerData['lifetime_value'] ?? 0;
                        $segmentClass = $ltv >= 10000000 ? 'bg-yellow-100 text-yellow-800' : 
                                       ($ltv >= 5000000 ? 'bg-green-100 text-green-800' : 
                                       ($ltv >= 2000000 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'));
                        $segment = $ltv >= 10000000 ? 'VIP' : 
                                  ($ltv >= 5000000 ? 'Premium' : 
                                  ($ltv >= 2000000 ? 'Regular' : 'Basic'));
                    @endphp
                    <div class="border rounded-lg p-4">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $customer->email }}</div>
                            </div>
                            <div class="flex gap-1">
                                @if($customer->is_member)
                                    <span class="px-2 py-0.5 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Member</span>
                                @endif
                                <span class="px-2 py-0.5 text-xs font-semibold rounded-full {{ $segmentClass }}">{{ $segment }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-2 text-sm">
                            <div>
                                <div class="text-xs text-gray-500">Nilai Hidup</div>
                                <div class="font-medium">Rp {{ number_format($ltv, 0, ',', '.') }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Bookings</div>
                                <div class="font-medium">{{ number_format($customerData['total_bookings'] ?? 0) }}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500">Avg Value</div>
                                <div class="font-medium">Rp {{ number_format($customerData['average_booking_value'] ?? 0, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8 text-gray-500">Tidak ada data pelanggan</div>
                    @endforelse
                </div>
                
                <!-- Desktop Table View -->
                <div class="hidden lg:block overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pelanggan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nilai Hidup</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bookings</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Avg Value</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Segment</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($reportData['customers'] as $customerData)
                            @php
                                $customer = $customerData['customer'];
                                $ltv = $customerData['lifetime_value'] ?? 0;
                                $segmentClass = $ltv >= 10000000 ? 'bg-yellow-100 text-yellow-800' : 
                                               ($ltv >= 5000000 ? 'bg-green-100 text-green-800' : 
                                               ($ltv >= 2000000 ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'));
                                $segment = $ltv >= 10000000 ? 'VIP' : 
                                          ($ltv >= 5000000 ? 'Premium' : 
                                          ($ltv >= 2000000 ? 'Regular' : 'Basic'));
                            @endphp
                            <tr>
                                <td class="px-4 py-4">
                                    <div class="font-medium text-gray-900">{{ $customer->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                </td>
                                <td class="px-4 py-4">
                                    @if($customer->is_member)
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">Member</span>
                                    @else
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Regular</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4 font-medium">Rp {{ number_format($ltv, 0, ',', '.') }}</td>
                                <td class="px-4 py-4">{{ number_format($customerData['total_bookings'] ?? 0) }}</td>
                                <td class="px-4 py-4">Rp {{ number_format($customerData['average_booking_value'] ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $segmentClass }}">{{ $segment }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada data pelanggan</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Segment Legend -->
            <div class="bg-gray-50 shadow-sm rounded-lg mt-4 sm:mt-6 p-4 sm:p-6">
                <h4 class="font-semibold text-gray-900 mb-3">Segmen Pelanggan:</h4>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs sm:text-sm text-gray-600">
                    <div><span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-semibold">VIP</span> ≥ Rp 10jt</div>
                    <div><span class="px-2 py-1 rounded-full bg-green-100 text-green-800 text-xs font-semibold">Premium</span> Rp 5-10jt</div>
                    <div><span class="px-2 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-semibold">Regular</span> Rp 2-5jt</div>
                    <div><span class="px-2 py-1 rounded-full bg-gray-100 text-gray-800 text-xs font-semibold">Basic</span> < Rp 2jt</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
