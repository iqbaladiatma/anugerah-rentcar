<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Pengeluaran') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.expenses.show', $expense) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Lihat Detail
                </a>
                <a href="{{ route('admin.expenses.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Kembali ke Pengeluaran
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.expenses.update', $expense) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Hidden Category (Required by Controller) -->
                        <input type="hidden" name="category" value="{{ $expense->category }}">

                        <!-- TANGGAL PENGELUARAN -->
                        <div class="mb-4">
                            <x-input-label for="expense_date" :value="__('TANGGAL PENGELUARAN *')" />
                            <x-text-input id="expense_date" name="expense_date" type="date" 
                                         class="mt-1 block w-full" :value="old('expense_date', $expense->expense_date->format('Y-m-d'))" 
                                         max="{{ date('Y-m-d') }}" required />
                            <x-input-error :messages="$errors->get('expense_date')" class="mt-2" />
                        </div>

                        <!-- NAMA PENGELUARAN -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('NAMA PENGELUARAN *')" />
                            <x-text-input id="description" name="description" type="text" 
                                         class="mt-1 block w-full" :value="old('description', $expense->description)" 
                                         placeholder="Nama Pengeluaran wajib di isi." required />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- NOMINAL -->
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('NOMINAL *')" />
                            <div x-data="currency('{{ old('amount', $expense->amount) }}')">
                                <x-text-input id="amount_display" type="text" x-model="formatted"
                                             class="mt-1 block w-full" 
                                             placeholder="0" required />
                                <input type="hidden" id="amount" name="amount" x-model="raw">
                            </div>
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('admin.expenses.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Pengeluaran') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>