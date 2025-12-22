<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-base sm:text-lg lg:text-xl text-gray-800 leading-tight">
                {{ __('Pelanggan Anggota') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.customers.create') }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <x-icons.plus class="w-3 h-3 sm:w-4 sm:h-4 mr-1" />
                    <span class="hidden sm:inline">Tambah Pelanggan</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
                <a href="{{ route('admin.customers.index') }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <x-icons.arrow-left class="w-3 h-3 sm:w-4 sm:h-4 mr-1" />
                    <span class="hidden sm:inline">Semua Pelanggan</span>
                    <span class="sm:hidden">Semua</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-4 sm:p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded mb-4 text-sm">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Member Statistics -->
                    <div class="mb-4 sm:mb-6 bg-green-50 p-3 sm:p-4 rounded-lg">
                        <div class="flex items-center">
                            <x-icons.star class="w-5 h-5 sm:w-6 sm:h-6 text-green-600 mr-2" />
                            <h3 class="text-sm sm:text-base lg:text-lg font-semibold text-green-800">Ringkasan Manfaat Anggota</h3>
                        </div>
                        <p class="mt-2 text-xs sm:text-sm text-green-700">
                            Anggota menikmati diskon eksklusif untuk semua pemesanan dan layanan pelanggan prioritas.
                        </p>
                    </div>

                    <!-- Filter to show only members -->
                    <div wire:init="$set('memberStatus', '1')">
                        <livewire:admin.customer-list />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>