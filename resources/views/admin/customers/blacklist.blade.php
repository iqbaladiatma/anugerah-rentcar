<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pelanggan Daftar Hitam') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.customers.create') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <x-icons.plus class="w-4 h-4 inline mr-1" />
                    Tambah Pelanggan
                </a>
                <a href="{{ route('admin.customers.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    <x-icons.arrow-left class="w-4 h-4 inline mr-1" />
                    Semua Pelanggan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    <!-- Blacklist Warning -->
                    <div class="mb-6 bg-red-50 p-4 rounded-lg">
                        <div class="flex items-center">
                            <x-icons.ban class="w-6 h-6 text-red-600 mr-2" />
                            <h3 class="text-lg font-semibold text-red-800">Pelanggan Daftar Hitam</h3>
                        </div>
                        <p class="mt-2 text-sm text-red-700">
                            Pelanggan ini dibatasi dari melakukan pemesanan baru. Setiap pemesanan yang tertunda telah dibatalkan.
                        </p>
                    </div>

                    <!-- Filter to show only blacklisted customers -->
                    <div wire:init="$set('blacklistStatus', '1')">
                        <livewire:admin.customer-list />
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>