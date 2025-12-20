<div x-data="{ activeTab: 'general' }">
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Konfigurasi Harga</h3>
        <p class="text-sm text-gray-600">Kelola denda, paket sewa, dan pengaturan harga umum.</p>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button @click="activeTab = 'general'"
                :class="activeTab === 'general' ? 'border-accent-500 text-accent-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-150">
                Pengaturan Umum
            </button>
            <button @click="activeTab = 'penalties'"
                :class="activeTab === 'penalties' ? 'border-accent-500 text-accent-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-150">
                Denda
            </button>
            <button @click="activeTab = 'packages'"
                :class="activeTab === 'packages' ? 'border-accent-500 text-accent-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm transition-colors duration-150">
                Paket Sewa
            </button>
        </nav>
    </div>

    <!-- General Settings Tab -->
    <div x-show="activeTab === 'general'" x-cloak>
        <div class="bg-white shadow sm:rounded-lg p-6">
            <form wire:submit.prevent="saveSettings" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Late Penalty Rate -->
                    <div x-data="{
                        raw: @entangle('late_penalty_per_hour'),
                        get formatted() {
                            return this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                        },
                        set formatted(value) {
                            this.raw = value.replace(/\D/g, '');
                        }
                    }">
                        <label for="late_penalty_per_hour" class="block text-sm font-medium text-gray-700">
                            Tarif Denda Keterlambatan (per jam)
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="text" 
                                   id="late_penalty_per_hour" 
                                   x-model="formatted"
                                   class="pl-10 block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 sm:text-sm @error('late_penalty_per_hour') border-red-300 @enderror">
                        </div>
                        @error('late_penalty_per_hour')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Denda yang dikenakan per jam untuk pengembalian yang terlambat.</p>
                    </div>

                    <!-- Buffer Time -->
                    <div>
                        <label for="buffer_time_hours" class="block text-sm font-medium text-gray-700">
                            Waktu Jeda (jam)
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" 
                                   id="buffer_time_hours" 
                                   wire:model="buffer_time_hours"
                                   min="0"
                                   max="24"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 sm:text-sm @error('buffer_time_hours') border-red-300 @enderror">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">jam</span>
                            </div>
                        </div>
                        @error('buffer_time_hours')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Waktu yang dicadangkan setelah pengembalian untuk pembersihan/pemeliharaan.</p>
                    </div>

                    <!-- Member Discount -->
                    <div>
                        <label for="member_discount_percentage" class="block text-sm font-medium text-gray-700">
                            Diskon Member
                        </label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <input type="number" 
                                   id="member_discount_percentage" 
                                   wire:model="member_discount_percentage"
                                   step="0.01"
                                   min="0"
                                   max="100"
                                   class="block w-full rounded-md border-gray-300 shadow-sm focus:border-accent-500 focus:ring-accent-500 sm:text-sm @error('member_discount_percentage') border-red-300 @enderror">
                            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">%</span>
                            </div>
                        </div>
                        @error('member_discount_percentage')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500">Persentase diskon default untuk member.</p>
                    </div>
                </div>

                <div class="flex justify-end pt-4 border-t border-gray-200">
                    <button type="button" 
                            wire:click="resetToDefaults"
                            wire:confirm="Apakah Anda yakin ingin mereset ke nilai default?"
                            class="mr-3 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                        Reset ke Default
                    </button>

                    <button type="submit" 
                            wire:loading.attr="disabled"
                            class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-accent-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500 disabled:opacity-50">
                        <span wire:loading.remove wire:target="saveSettings">Simpan Pengaturan</span>
                        <span wire:loading wire:target="saveSettings">Menyimpan...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Penalties Tab -->
    <div x-show="activeTab === 'penalties'" x-cloak>
        <div>
            <div class="flex justify-end mb-4">
                <button wire:click="createPenalty" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-accent-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                    Tambah Denda
                </button>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($penalties as $penalty)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $penalty->name }}
                                    @if($penalty->description)
                                        <p class="text-xs text-gray-500 font-normal">{{ Str::limit($penalty->description, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($penalty->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="capitalize">
                                        @if($penalty->type === 'fixed') Tetap @elseif($penalty->type === 'hourly') Per Jam @elseif($penalty->type === 'daily') Per Hari @else {{ $penalty->type }} @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $penalty->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $penalty->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="editPenalty({{ $penalty->id }})" class="text-accent-600 hover:text-accent-900 mr-3">Ubah</button>
                                    <button wire:click="deletePenalty({{ $penalty->id }})" wire:confirm="Apakah Anda yakin ingin menghapus denda ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada denda yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Rental Packages Tab -->
    <div x-show="activeTab === 'packages'" x-cloak>
        <div>
            <div class="flex justify-end mb-4">
                <button wire:click="createPackage" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-accent-600 hover:bg-accent-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-accent-500">
                    Tambah Paket
                </button>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Aksi</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($rentalPackages as $package)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ $package->name }}
                                    @if($package->description)
                                        <p class="text-xs text-gray-500 font-normal">{{ Str::limit($package->description, 50) }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $package->duration_hours }} Jam
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Rp {{ number_format($package->price, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $package->is_active ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="editPackage({{ $package->id }})" class="text-indigo-600 hover:text-indigo-900 mr-3">Ubah</button>
                                    <button wire:click="deletePackage({{ $package->id }})" wire:confirm="Apakah Anda yakin ingin menghapus paket ini?" class="text-red-600 hover:text-red-900">Hapus</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada paket sewa yang ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Penalty Modal -->
    @if($showPenaltyModal)
        @teleport('body')
        <div class="fixed z-[100] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showPenaltyModal', false)"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="savePenalty">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $penaltyId ? 'Ubah Denda' : 'Tambah Denda' }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" wire:model="penaltyForm.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('penaltyForm.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div x-data="{
                                    raw: @entangle('penaltyForm.amount'),
                                    get formatted() {
                                        return this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                                    },
                                    set formatted(value) {
                                        this.raw = value.replace(/\D/g, '');
                                    }
                                }">
                                    <label class="block text-sm font-medium text-gray-700">Jumlah</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="text" x-model="formatted" class="pl-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    @error('penaltyForm.amount') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tipe</label>
                                    <select wire:model="penaltyForm.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                        <option value="fixed">Tetap</option>
                                        <option value="hourly">Per Jam</option>
                                        <option value="daily">Per Hari</option>
                                    </select>
                                    @error('penaltyForm.type') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea wire:model="penaltyForm.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    @error('penaltyForm.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="penaltyForm.is_active" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label class="ml-2 block text-sm text-gray-900">Aktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan
                            </button>
                            <button type="button" wire:click="$set('showPenaltyModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endteleport
    @endif

    <!-- Package Modal -->
    @if($showPackageModal)
        @teleport('body')
        <div class="fixed z-[100] inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="$set('showPackageModal', false)"></div>
                
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-middle bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full">
                    <form wire:submit.prevent="savePackage">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                {{ $packageId ? 'Ubah Paket' : 'Tambah Paket' }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nama</label>
                                    <input type="text" wire:model="packageForm.name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('packageForm.name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Durasi (Jam)</label>
                                    <input type="number" wire:model="packageForm.duration_hours" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @error('packageForm.duration_hours') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div x-data="{
                                    raw: @entangle('packageForm.price'),
                                    get formatted() {
                                        return this.raw ? new Intl.NumberFormat('id-ID').format(this.raw) : '';
                                    },
                                    set formatted(value) {
                                        this.raw = value.replace(/\D/g, '');
                                    }
                                }">
                                    <label class="block text-sm font-medium text-gray-700">Harga</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <input type="text" x-model="formatted" class="pl-10 mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    @error('packageForm.price') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                    <textarea wire:model="packageForm.description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                                    @error('packageForm.description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" wire:model="packageForm.is_active" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label class="ml-2 block text-sm text-gray-900">Aktif</label>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan
                            </button>
                            <button type="button" wire:click="$set('showPackageModal', false)" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endteleport
    @endif
</div>