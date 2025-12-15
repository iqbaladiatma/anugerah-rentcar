<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Expense') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.expenses.show', $expense) }}" 
                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    View Details
                </a>
                <a href="{{ route('admin.expenses.index') }}" 
                   class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Expenses
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

                        <!-- Category -->
                        <div class="mb-4">
                            <x-input-label for="category" :value="__('Category')" />
                            <select id="category" name="category" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    required>
                                <option value="">Select Category</option>
                                @foreach($categories as $key => $label)
                                    <option value="{{ $key }}" {{ (old('category', $expense->category) == $key) ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('category')" class="mt-2" />
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" name="description" type="text" 
                                         class="mt-1 block w-full" :value="old('description', $expense->description)" 
                                         placeholder="Enter expense description" required />
                            <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        </div>

                        <!-- Amount -->
                        <div class="mb-4">
                            <x-input-label for="amount" :value="__('Amount (IDR)')" />
                            <x-text-input id="amount" name="amount" type="number" step="0.01" min="0" max="999999.99"
                                         class="mt-1 block w-full" :value="old('amount', $expense->amount)" 
                                         placeholder="0.00" required />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <!-- Expense Date -->
                        <div class="mb-4">
                            <x-input-label for="expense_date" :value="__('Expense Date')" />
                            <x-text-input id="expense_date" name="expense_date" type="date" 
                                         class="mt-1 block w-full" :value="old('expense_date', $expense->expense_date->format('Y-m-d'))" 
                                         max="{{ date('Y-m-d') }}" required />
                            <x-input-error :messages="$errors->get('expense_date')" class="mt-2" />
                        </div>

                        <!-- Current Receipt Photo -->
                        @if($expense->receipt_photo)
                            <div class="mb-4">
                                <x-input-label :value="__('Current Receipt Photo')" />
                                <div class="mt-2">
                                    <img src="{{ $expense->receipt_photo_url }}" alt="Receipt" class="max-w-xs rounded-lg shadow-md">
                                </div>
                            </div>
                        @endif

                        <!-- Receipt Photo -->
                        <div class="mb-6">
                            <x-input-label for="receipt_photo" :value="__('Receipt Photo (Optional)')" />
                            <input id="receipt_photo" name="receipt_photo" type="file" 
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                   accept="image/jpeg,image/png,image/jpg" />
                            <p class="mt-1 text-sm text-gray-500">
                                Upload new receipt photo to replace current one (JPEG, PNG, JPG, max 2MB)
                            </p>
                            <x-input-error :messages="$errors->get('receipt_photo')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end">
                            <a href="{{ route('admin.expenses.index') }}" 
                               class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Cancel
                            </a>
                            <x-primary-button>
                                {{ __('Update Expense') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>