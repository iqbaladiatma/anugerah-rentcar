<div>
    <!-- Search and Filters -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       id="search"
                       placeholder="Nama, telepon, email, atau NIK..."
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            
            <div>
                <label for="memberStatus" class="block text-sm font-medium text-gray-700 mb-1">Status Anggota</label>
                <select wire:model.live="memberStatus" 
                        id="memberStatus"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($memberStatusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="blacklistStatus" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select wire:model.live="blacklistStatus" 
                        id="blacklistStatus"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($blacklistStatusOptions as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button wire:click="clearFilters" 
                        class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Hapus Filter
                </button>
            </div>
        </div>
        
        <!-- Quick Filter Buttons -->
        <div class="flex flex-wrap gap-2">
            <button wire:click="toggleMembersOnly" 
                    class="px-3 py-1 text-sm rounded-full {{ $showMembersOnly ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700' }} hover:bg-green-600 hover:text-white">
                <x-icons.star class="w-3 h-3 inline mr-1" />
                Hanya Anggota
            </button>
            
            <button wire:click="toggleBlacklistedOnly" 
                    class="px-3 py-1 text-sm rounded-full {{ $showBlacklistedOnly ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700' }} hover:bg-red-600 hover:text-white">
                <x-icons.ban class="w-3 h-3 inline mr-1" />
                Hanya Daftar Hitam
            </button>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div wire:loading class="mb-4">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
            Memuat pelanggan...
        </div>
    </div>

    <!-- Customer Table -->
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('name')">
                            <div class="flex items-center">
                                Nama
                                @if($sortBy === 'name')
                                    @if($sortDirection === 'asc')
                                        <x-icons.arrow-up class="w-4 h-4 ml-1" />
                                    @else
                                        <x-icons.arrow-down class="w-4 h-4 ml-1" />
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kontak
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pemesanan
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                            wire:click="sortBy('created_at')">
                            <div class="flex items-center">
                                Terdaftar
                                @if($sortBy === 'created_at')
                                    @if($sortDirection === 'asc')
                                        <x-icons.arrow-up class="w-4 h-4 ml-1" />
                                    @else
                                        <x-icons.arrow-down class="w-4 h-4 ml-1" />
                                    @endif
                                @endif
                            </div>
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                                            <x-icons.user class="h-6 w-6 text-gray-600" />
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $customer->name }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            NIK: {{ $customer->nik }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $customer->phone }}</div>
                                @if($customer->email)
                                    <div class="text-sm text-gray-500">{{ $customer->email }}</div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex flex-col space-y-1">
                                    @if($customer->is_member)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <x-icons.star class="w-3 h-3 mr-1" />
                                            Anggota ({{ $customer->getMemberDiscountPercentage() }}%)
                                        </span>
                                    @endif
                                    
                                    @if($customer->is_blacklisted)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <x-icons.ban class="w-3 h-3 mr-1" />
                                            Daftar Hitam
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Aktif
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if(isset($customerStats[$customer->id]))
                                    @php $stats = $customerStats[$customer->id] @endphp
                                    <div class="text-sm">
                                        <div>Total: {{ $stats['total_bookings'] }}</div>
                                        <div class="text-gray-500">Aktif: {{ $stats['active_bookings'] }}</div>
                                    </div>
                                @endif
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $customer->created_at->format('d M Y') }}
                            </td>
                            
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('admin.customers.show', $customer) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Lihat
                                    </a>
                                    
                                    <a href="{{ route('admin.customers.edit', $customer) }}" 
                                       class="text-indigo-600 hover:text-indigo-900">
                                        Edit
                                    </a>
                                    
                                    <!-- Member Status Toggle -->
                                    @if(!$customer->is_blacklisted)
                                        @if($customer->is_member)
                                            <button wire:click="updateMemberStatus({{ $customer->id }}, false)"
                                                    class="text-yellow-600 hover:text-yellow-900"
                                                    wire:confirm="Hapus status anggota dari {{ $customer->name }}?">
                                                Hapus Anggota
                                            </button>
                                        @else
                                            <button wire:click="updateMemberStatus({{ $customer->id }}, true, 10)"
                                                    class="text-green-600 hover:text-green-900">
                                                Jadikan Anggota
                                            </button>
                                        @endif
                                    @endif
                                    
                                    <!-- Blacklist Toggle -->
                                    @if($customer->is_blacklisted)
                                        <button wire:click="updateBlacklistStatus({{ $customer->id }}, false)"
                                                class="text-green-600 hover:text-green-900"
                                                wire:confirm="Hapus {{ $customer->name }} dari daftar hitam?">
                                            Buka Blokir
                                        </button>
                                    @else
                                        <button onclick="blacklistCustomer({{ $customer->id }}, '{{ $customer->name }}')"
                                                class="text-red-600 hover:text-red-900">
                                            Daftar Hitam
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                @if($search || $memberStatus !== '' || $blacklistStatus !== '')
                                    Tidak ada pelanggan yang ditemukan sesuai kriteria Anda.
                                @else
                                    Belum ada pelanggan yang terdaftar.
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        @if($customers->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $customers->links() }}
            </div>
        @endif
    </div>

    <!-- Blacklist Modal -->
    <div x-data="{ showBlacklistModal: false, customerId: null, customerName: '' }" 
         x-on:blacklist-customer.window="showBlacklistModal = true; customerId = $event.detail.id; customerName = $event.detail.name">
        
        <div x-show="showBlacklistModal" 
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-50 overflow-y-auto" 
             style="display: none;">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="updateBlacklistStatus(customerId, true, $refs.blacklistReason.value)">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                    <x-icons.ban class="h-6 w-6 text-red-600" />
                                </div>
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                                        Daftar Hitam Pelanggan
                                    </h3>
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">
                                            Anda akan memasukkan <strong x-text="customerName"></strong> ke daftar hitam. 
                                            Ini akan mencegah mereka melakukan pemesanan baru dan membatalkan pemesanan yang tertunda.
                                        </p>
                                        <div class="mt-4">
                                            <label for="blacklistReason" class="block text-sm font-medium text-gray-700">
                                                Alasan daftar hitam *
                                            </label>
                                            <textarea x-ref="blacklistReason"
                                                      id="blacklistReason"
                                                      rows="3"
                                                      required
                                                      class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                                      placeholder="Masukkan alasan memasukkan pelanggan ini ke daftar hitam..."></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                    class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Daftar Hitam Pelanggan
                            </button>
                            <button type="button"
                                    @click="showBlacklistModal = false"
                                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function blacklistCustomer(customerId, customerName) {
    window.dispatchEvent(new CustomEvent('blacklist-customer', {
        detail: { id: customerId, name: customerName }
    }));
}
</script>