<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Expense Management') }}
            </h2>
            <a href="{{ route('admin.expenses.create') }}" 
               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add New Expense
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.currency-dollar class="h-8 w-8 text-green-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">This Month</p>
                                <p class="text-2xl font-semibold text-gray-900" id="monthly-total">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.chart-bar class="h-8 w-8 text-blue-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">This Year</p>
                                <p class="text-2xl font-semibold text-gray-900" id="yearly-total">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.trending-up class="h-8 w-8 text-purple-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Avg Monthly</p>
                                <p class="text-2xl font-semibold text-gray-900" id="average-monthly">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <x-icons.receipt-tax class="h-8 w-8 text-red-500" />
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Expenses</p>
                                <p class="text-2xl font-semibold text-gray-900" id="total-count">Loading...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expense List Component -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    @livewire('admin.expense-list')
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            loadSummaryData();
        });

        function loadSummaryData() {
            const currentDate = new Date();
            const currentYear = currentDate.getFullYear();
            const currentMonth = currentDate.getMonth() + 1;

            // Load monthly summary
            fetch(`{{ route('admin.expenses.monthly-summary') }}?year=${currentYear}&month=${currentMonth}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('monthly-total').textContent = 
                        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.total_amount);
                })
                .catch(error => {
                    document.getElementById('monthly-total').textContent = 'Error loading data';
                });

            // Load yearly summary
            fetch(`{{ route('admin.expenses.yearly-summary') }}?year=${currentYear}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('yearly-total').textContent = 
                        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.total_amount);
                    document.getElementById('average-monthly').textContent = 
                        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(data.average_monthly);
                    document.getElementById('total-count').textContent = data.total_count + ' items';
                })
                .catch(error => {
                    document.getElementById('yearly-total').textContent = 'Error loading data';
                    document.getElementById('average-monthly').textContent = 'Error loading data';
                    document.getElementById('total-count').textContent = 'Error loading data';
                });
        }
    </script>
    @endpush
</x-admin-layout>