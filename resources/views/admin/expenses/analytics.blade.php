<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Analisis Pengeluaran') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.expenses.create') }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Tambah Pengeluaran
                </a>
                <a href="{{ route('admin.expenses.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Pengeluaran
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @livewire('admin.expense-analytics')
        </div>
    </div>
</x-admin-layout>