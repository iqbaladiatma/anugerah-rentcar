<div>
    <!-- Filters Section -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Deskripsi</label>
                <input type="text" 
                       wire:model.live.debounce.300ms="search" 
                       id="search"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="Cari pengeluaran...">
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                <select wire:model.live="category" 
                        id="category"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}">{{ $label }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date Range -->
            <div>
                <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai</label>
                <input type="date" 
                       wire:model.live="startDate" 
                       id="start_date"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai</label>
                <input type="date" 
                       wire:model.live="endDate" 
                       id="end_date"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <!-- Amount Range -->
            <div>
                <label for="min_amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Minimum</label>
                <input type="number" 
                       wire:model.live.debounce.300ms="minAmount" 
                       id="min_amount"
                       step="0.01"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="0.00">
            </div>

            <div>
                <label for="max_amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Maksimum</label>
                <input type="number" 
                       wire:model.live.debounce.300ms="maxAmount" 
                       id="max_amount"
                       step="0.01"
                       class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                       placeholder="999999.99">
            </div>

            <div class="flex items-end">
                <button type="button" 
                        wire:click="clearFilters"
                        class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Clear Filters
                </button>
            </div>
        </div>
    </div>

    <!-- Summary -->
    <div class="mb-4 flex justify-between items-center">
        <div class="text-sm text-gray-600">
            Showing {{ $expenses->count() }} of {{ $expenses->total() }} pengeluaran
            @if($totalAmount > 0)
                | Total: <span class="font-semibold">{{ number_format($totalAmount, 0, ',', '.') }} IDR</span>
            @endif
        </div>
        <div class="text-sm text-gray-600">
            {{ $totalCount }} total records
        </div>
    </div>

    <!-- Expenses Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('expense_date')">
                        <div class="flex items-center space-x-1">
                            <span>Tanggal</span>
                            @if($sortField === 'expense_date')
                                @if($sortDirection === 'asc')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('category')">
                        <div class="flex items-center space-x-1">
                            <span>Kategori</span>
                            @if($sortField === 'category')
                                @if($sortDirection === 'asc')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Deskripsi
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('amount')">
                        <div class="flex items-center space-x-1">
                            <span>Jumlah</span>
                            @if($sortField === 'amount')
                                @if($sortDirection === 'asc')
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            @endif
                        </div>
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Dibuat Oleh
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Receipt
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($expenses as $expense)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $expense->expense_date->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @switch($expense->category)
                                    @case('salary') bg-blue-100 text-blue-800 @break
                                    @case('utilities') bg-yellow-100 text-yellow-800 @break
                                    @case('supplies') bg-green-100 text-green-800 @break
                                    @case('marketing') bg-purple-100 text-purple-800 @break
                                    @default bg-gray-100 text-gray-800
                                @endswitch">
                                {{ $expense->category_display_name }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div class="max-w-xs truncate" title="{{ $expense->description }}">
                                {{ $expense->description }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ number_format($expense->amount, 0, ',', '.') }} IDR
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $expense->creator->name ?? 'System' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($expense->receipt_photo)
                                <a href="{{ $expense->receipt_photo_url }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="text-gray-400">No receipt</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.expenses.show', $expense) }}" 
                                   class="text-blue-600 hover:text-blue-900">View</a>
                                <a href="{{ route('admin.expenses.edit', $expense) }}" 
                                   class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                <button wire:click="deleteExpense({{ $expense->id }})" 
                                        wire:confirm="Are you sure you want to delete this expense?"
                                        class="text-red-600 hover:text-red-900">Delete</button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            No expenses found matching your criteria.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $expenses->links() }}
    </div>

    <!-- Flash Messages -->
    @if (session()->has('success'))
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50"
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            {{ session('success') }}
        </div>
    @endif
</div>