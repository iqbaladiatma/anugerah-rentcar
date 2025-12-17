<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Tambah Kendaraan Baru
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Tambahkan kendaraan baru ke armada rental Anda dengan informasi lengkap dan foto.
                </p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.vehicles.index') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-icons.arrow-left class="w-4 h-4 mr-2" />
                    Kembali ke Armada Kendaraan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <livewire:admin.vehicle-form />
    </div>
</x-admin-layout>