<div>
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-2">Pengaturan Harga</h3>
        <p class="text-sm text-gray-600">Konfigurasikan tarif denda, waktu buffer, dan diskon anggota.</p>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
            {{ session('error') }}
        </div>
    @endif

    <form wire:submit.prevent="save" class="space-y-6">
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
                    Tarif Denda (per jam)
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">Rp</span>
                    </div>
                    <input type="text" 
                           id="late_penalty_per_hour" 
                           x-model="formatted"
                           class="pl-12 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('late_penalty_per_hour') border-red-300 @enderror">
                </div>
                @error('late_penalty_per_hour')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Denda yang dikenakan per jam untuk pengembalian yang terlambat.</p>
            </div>

            <!-- Buffer Time -->
            <div>
                <label for="buffer_time_hours" class="block text-sm font-medium text-gray-700">
                    Waktu Buffer (jam)
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" 
                           id="buffer_time_hours" 
                           wire:model="buffer_time_hours"
                           min="0"
                           max="24"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('buffer_time_hours') border-red-300 @enderror">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">hrs</span>
                    </div>
                </div>
                @error('buffer_time_hours')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Waktu yang disimpan setelah pengembalian untuk membersihkan mobil.</p>
            </div>

            <!-- Member Discount -->
            <div>
                <label for="member_discount_percentage" class="block text-sm font-medium text-gray-700">
                    Member Discount
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="number" 
                           id="member_discount_percentage" 
                           wire:model="member_discount_percentage"
                           step="0.01"
                           min="0"
                           max="100"
                           class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm @error('member_discount_percentage') border-red-300 @enderror">
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <span class="text-gray-500 sm:text-sm">%</span>
                    </div>
                </div>
                @error('member_discount_percentage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-sm text-gray-500">Persentase diskon default untuk pelanggan anggota.</p>
            </div>
        </div>

        <!-- Preview Section -->
        <div class="bg-gray-50 rounded-lg p-4">
            <h4 class="text-sm font-medium text-gray-900 mb-3">Preview Pengaturan</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <span class="text-gray-600">Late Penalty:</span>
                    <span class="font-medium">Rp {{ number_format($late_penalty_per_hour ?? 0, 0, ',', '.') }}/jam</span>
                </div>
                <div>
                    <span class="text-gray-600">Buffer Time:</span>
                    <span class="font-medium">{{ $buffer_time_hours ?? 0 }} jam</span>
                </div>
                <div>
                    <span class="text-gray-600">Member Discount:</span>
                    <span class="font-medium">{{ $member_discount_percentage ?? 0 }}%</span>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between">
            <button type="button" 
                    wire:click="resetToDefaults"
                    wire:confirm="Are you sure you want to reset to default values?"
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reset to Defaults
            </button>

            <button type="submit" 
                    wire:loading.attr="disabled"
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                <span wire:loading.remove wire:target="save">Simpan Pengaturan</span>
                <span wire:loading wire:target="save">Saving...</span>
            </button>
        </div>
    </form>
</div>