<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3">
            <h2 class="font-semibold text-base sm:text-lg lg:text-xl text-gray-800 leading-tight">
                {{ __('Analisis Pengeluaran') }}
            </h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.expenses.create') }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-accent-500 hover:bg-accent-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <span class="hidden sm:inline">Tambah Pengeluaran</span>
                    <span class="sm:hidden">Tambah</span>
                </a>
                <a href="{{ route('admin.expenses.index') }}" 
                   class="inline-flex items-center justify-center px-3 py-1.5 sm:px-4 sm:py-2 bg-gray-500 hover:bg-gray-600 text-white text-xs sm:text-sm font-medium rounded-lg transition-colors">
                    <span class="hidden sm:inline">Kembali ke Pengeluaran</span>
                    <span class="sm:hidden">Kembali</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 lg:py-12">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            @livewire('admin.expense-analytics')
        </div>
    </div>
</x-admin-layout>