<div>
    <form wire:submit.prevent="save">
        <div class="space-y-6">
            <!-- Personal Information -->
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Informasi Pribadi</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Informasi dasar pelanggan dan detail kontak.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">
                                    Nama Lengkap *
                                </label>
                                <input type="text" 
                                       wire:model="name" 
                                       id="name"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('name') border-red-300 @enderror">
                                @error('name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="phone" class="block text-sm font-medium text-gray-700">
                                    Nomor Telepon *
                                </label>
                                <input type="tel" 
                                       wire:model="phone" 
                                       id="phone"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('phone') border-red-300 @enderror">
                                @error('phone')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-gray-700">
                                    Alamat Email
                                </label>
                                <input type="email" 
                                       wire:model="email" 
                                       id="email"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('email') border-red-300 @enderror">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label for="nik" class="block text-sm font-medium text-gray-700">
                                    NIK (16 digit) *
                                </label>
                                <input type="text" 
                                       wire:model="nik" 
                                       id="nik"
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('nik') border-red-300 @enderror">
                                @error('nik')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-6">
                                <label for="address" class="block text-sm font-medium text-gray-700">
                                    Alamat *
                                </label>
                                <textarea wire:model="address" 
                                          id="address"
                                          rows="3"
                                          class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('address') border-red-300 @enderror"></textarea>
                                @error('address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Document Upload -->
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Dokumen Identitas</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Unggah foto dokumen KTP, SIM, dan Kartu Keluarga (KK) yang jelas.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                            <!-- KTP Photo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Foto KTP *
                                </label>
                                
                                @if($existing_ktp_photo && !$remove_ktp_photo && !$ktp_photo)
                                    <div class="mt-1">
                                        <img src="{{ asset('storage/' . $existing_ktp_photo) }}" 
                                             alt="KTP Saat Ini" 
                                             class="h-32 w-full object-cover rounded-md border">
                                        <div class="mt-2 flex space-x-2">
                                            <button type="button" 
                                                    wire:click="removeDocument('ktp')"
                                                    class="text-sm text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @elseif($ktp_photo)
                                    <div class="mt-1">
                                        <img src="{{ $ktp_photo->temporaryUrl() }}" 
                                             alt="KTP Baru" 
                                             class="h-32 w-full object-cover rounded-md border">
                                        <div class="mt-2">
                                            <button type="button" 
                                                    wire:click="$set('ktp_photo', null)"
                                                    class="text-sm text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @elseif($remove_ktp_photo)
                                    <div class="mt-1 p-4 border-2 border-dashed border-red-300 rounded-md">
                                        <p class="text-sm text-red-600">Foto KTP akan dihapus</p>
                                        <button type="button" 
                                                wire:click="restoreDocument('ktp')"
                                                class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                            Pulihkan
                                        </button>
                                    </div>
                                @else
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="ktp_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Unggah foto KTP</span>
                                                    <input id="ktp_photo" 
                                                           wire:model="ktp_photo" 
                                                           type="file" 
                                                           accept="image/*"
                                                           class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG hingga 2MB</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @error('ktp_photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- SIM Photo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Foto SIM *
                                </label>
                                
                                @if($existing_sim_photo && !$remove_sim_photo && !$sim_photo)
                                    <div class="mt-1">
                                        <img src="{{ asset('storage/' . $existing_sim_photo) }}" 
                                             alt="SIM Saat Ini" 
                                             class="h-32 w-full object-cover rounded-md border">
                                        <div class="mt-2 flex space-x-2">
                                            <button type="button" 
                                                    wire:click="removeDocument('sim')"
                                                    class="text-sm text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @elseif($sim_photo)
                                    <div class="mt-1">
                                        <img src="{{ $sim_photo->temporaryUrl() }}" 
                                             alt="SIM Baru" 
                                             class="h-32 w-full object-cover rounded-md border">
                                        <div class="mt-2">
                                            <button type="button" 
                                                    wire:click="$set('sim_photo', null)"
                                                    class="text-sm text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @elseif($remove_sim_photo)
                                    <div class="mt-1 p-4 border-2 border-dashed border-red-300 rounded-md">
                                        <p class="text-sm text-red-600">Foto SIM akan dihapus</p>
                                        <button type="button" 
                                                wire:click="restoreDocument('sim')"
                                                class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                            Pulihkan
                                        </button>
                                    </div>
                                @else
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="sim_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Unggah foto SIM</span>
                                                    <input id="sim_photo" 
                                                           wire:model="sim_photo" 
                                                           type="file" 
                                                           accept="image/*"
                                                           class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG hingga 2MB</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @error('sim_photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- KK Photo (Kartu Keluarga) -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">
                                    Foto Kartu Keluarga *
                                </label>
                                
                                @if($existing_kk_photo && !$remove_kk_photo && !$kk_photo)
                                    <div class="mt-1">
                                        <img src="{{ asset('storage/' . $existing_kk_photo) }}" 
                                             alt="KK Saat Ini" 
                                             class="h-32 w-full object-cover rounded-md border">
                                        <div class="mt-2 flex space-x-2">
                                            <button type="button" 
                                                    wire:click="removeDocument('kk')"
                                                    class="text-sm text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @elseif($kk_photo)
                                    <div class="mt-1">
                                        <img src="{{ $kk_photo->temporaryUrl() }}" 
                                             alt="KK Baru" 
                                             class="h-32 w-full object-cover rounded-md border">
                                        <div class="mt-2">
                                            <button type="button" 
                                                    wire:click="$set('kk_photo', null)"
                                                    class="text-sm text-red-600 hover:text-red-800">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @elseif($remove_kk_photo)
                                    <div class="mt-1 p-4 border-2 border-dashed border-red-300 rounded-md">
                                        <p class="text-sm text-red-600">Foto KK akan dihapus</p>
                                        <button type="button" 
                                                wire:click="restoreDocument('kk')"
                                                class="mt-1 text-sm text-blue-600 hover:text-blue-800">
                                            Pulihkan
                                        </button>
                                    </div>
                                @else
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="kk_photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                                    <span>Unggah foto KK</span>
                                                    <input id="kk_photo" 
                                                           wire:model="kk_photo" 
                                                           type="file" 
                                                           accept="image/*"
                                                           class="sr-only">
                                                </label>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG hingga 2MB</p>
                                        </div>
                                    </div>
                                @endif
                                
                                @error('kk_photo')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Member Status -->
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Status Anggota</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Konfigurasi manfaat anggota dan pengaturan diskon.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_member" 
                                           wire:model.live="is_member" 
                                           type="checkbox" 
                                           class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_member" class="font-medium text-gray-700">Status Anggota</label>
                                    <p class="text-gray-500">Berikan hak istimewa anggota dan manfaat diskon</p>
                                </div>
                            </div>

                            @if($is_member)
                                <div class="ml-7">
                                    <label for="member_discount" class="block text-sm font-medium text-gray-700">
                                        Persentase Diskon Anggota
                                    </label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <input type="number" 
                                               wire:model="member_discount" 
                                               id="member_discount"
                                               min="0" 
                                               max="100" 
                                               step="0.01"
                                               class="focus:ring-blue-500 focus:border-blue-500 block w-full pr-12 sm:text-sm border-gray-300 rounded-md @error('member_discount') border-red-300 @enderror">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">%</span>
                                        </div>
                                    </div>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Default sistem: {{ $systemDefaultDiscount }}%. Biarkan kosong untuk menggunakan default sistem.
                                    </p>
                                    @error('member_discount')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blacklist Status -->
            <div class="bg-white shadow px-4 py-5 sm:rounded-lg sm:p-6">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Status Akun</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Kelola akses dan pembatasan pelanggan.
                        </p>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input id="is_blacklisted" 
                                           wire:model.live="is_blacklisted" 
                                           type="checkbox" 
                                           class="focus:ring-red-500 h-4 w-4 text-red-600 border-gray-300 rounded">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="is_blacklisted" class="font-medium text-gray-700">Daftar Hitam Pelanggan</label>
                                    <p class="text-gray-500">Cegah pelanggan melakukan pemesanan baru</p>
                                </div>
                            </div>

                            @if($is_blacklisted)
                                <div class="ml-7">
                                    <label for="blacklist_reason" class="block text-sm font-medium text-gray-700">
                                        Alasan Daftar Hitam *
                                    </label>
                                    <textarea wire:model="blacklist_reason" 
                                              id="blacklist_reason"
                                              rows="3"
                                              placeholder="Masukkan alasan memasukkan pelanggan ini ke daftar hitam..."
                                              class="mt-1 focus:ring-red-500 focus:border-red-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md @error('blacklist_reason') border-red-300 @enderror"></textarea>
                                    @error('blacklist_reason')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex justify-end space-x-3 pt-6">
            <a href="{{ $isEditing && $customer && $customer->exists ? route('admin.customers.show', $customer) : route('admin.customers.index') }}" 
               class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Batal
            </a>
            
            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50">
                <span wire:loading.remove>
                    {{ $isEditing ? 'Perbarui Pelanggan' : 'Buat Pelanggan' }}
                </span>
                <span wire:loading>
                    {{ $isEditing ? 'Memperbarui...' : 'Membuat...' }}
                </span>
            </button>
        </div>
    </form>
</div>