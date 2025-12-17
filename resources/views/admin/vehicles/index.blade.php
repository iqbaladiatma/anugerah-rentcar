<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Armada Kendaraan
                </h1>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola armada kendaraan sewaan Anda, lacak pemeliharaan, dan pantau ketersediaan</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.vehicles.maintenance-due') }}" 
                   class="inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-icons.wrench class="w-4 h-4 mr-2" />
                    Pemeliharaan yang Harus Dilakukan
                </a>
                <a href="{{ route('admin.vehicles.create') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <x-icons.plus class="w-4 h-4 mr-2" />
                    Tambah Kendaraan
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Vehicle List -->
        <livewire:admin.vehicle-list />
    </div>
</x-admin-layout>