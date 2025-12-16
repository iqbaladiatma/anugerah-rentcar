<div>
    <!-- Controls -->
    <div class="mb-6 bg-white p-6 rounded-lg shadow">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="year" class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select wire:model.live="selectedYear" 
                        id="year"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="month" class="block text-sm font-medium text-gray-700 mb-1">Month (Optional)</label>
                <select wire:model.live="selectedMonth" 
                        id="month"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">All Months</option>
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="comparison" class="block text-sm font-medium text-gray-700 mb-1">Compare With</label>
                <select wire:model.live="comparisonPeriod" 
                        id="comparison"
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="year">Previous Year</option>
                    <option value="month">Previous Month</option>
                </select>
            </div>

            <div class="flex items-end space-x-2">
                <button wire:click="exportData('excel')" 
                        class="flex-1 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Export Excel
                </button>
                <button wire:click="exportData('pdf')" 
                        class="flex-1 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Export PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Expenses</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format($yearlySummary['total_amount'] ?? 0, 0, ',', '.') }} IDR
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Records</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $yearlySummary['total_count'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-8 w-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Average Monthly</p>
                        <p class="text-2xl font-semibold text-gray-900">
                            {{ number_format($yearlySummary['average_monthly'] ?? 0, 0, ',', '.') }} IDR
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        @if(isset($comparison['difference']['percentage']))
                            @if($comparison['difference']['percentage'] > 0)
                                <svg class="h-8 w-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                </svg>
                            @else
                                <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            @endif
                        @else
                            <svg class="h-8 w-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">vs {{ $comparison['period2_label'] ?? 'Previous' }}</p>
                        <p class="text-2xl font-semibold {{ isset($comparison['difference']['percentage']) && $comparison['difference']['percentage'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                            @if(isset($comparison['difference']['percentage']))
                                {{ $comparison['difference']['percentage'] > 0 ? '+' : '' }}{{ number_format($comparison['difference']['percentage'], 1) }}%
                            @else
                                N/A
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Trend Chart -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">12-Month Trend</h3>
            <div class="h-64">
                <canvas id="trendChart" width="400" height="200"></canvas>
            </div>
        </div>

        <!-- Category Breakdown -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Category Breakdown</h3>
            <div class="h-64">
                <canvas id="categoryChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly Breakdown Table -->
    @if(!empty($yearlySummary['monthly_breakdown']))
    <div class="bg-white p-6 rounded-lg shadow mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Monthly Breakdown - {{ $selectedYear }}</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Month</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">% of Year</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($yearlySummary['monthly_breakdown'] as $month => $data)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $data['month'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ number_format($data['amount'], 0, ',', '.') }} IDR
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $data['count'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($yearlySummary['total_amount'] > 0)
                                    {{ number_format(($data['amount'] / $yearlySummary['total_amount']) * 100, 1) }}%
                                @else
                                    0%
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Category Details -->
    @if(!empty($categoryBreakdown))
    <div class="bg-white p-6 rounded-lg shadow">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Category Details</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($categoryBreakdown as $category)
                <div class="border rounded-lg p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h4 class="font-medium text-gray-900">{{ $category['label'] }}</h4>
                        <span class="text-sm text-gray-500">{{ number_format($category['percentage'], 1) }}%</span>
                    </div>
                    <p class="text-2xl font-semibold text-gray-900 mb-1">
                        {{ number_format($category['total'], 0, ',', '.') }} IDR
                    </p>
                    <p class="text-sm text-gray-500">{{ $category['count'] }} transactions</p>
                    <div class="mt-2 bg-gray-200 rounded-full h-2">
                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Trend Chart
            const trendCtx = document.getElementById('trendChart').getContext('2d');
            const trendData = @json($trendData);
            
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => item.short_month),
                    datasets: [{
                        label: 'Monthly Expenses',
                        data: trendData.map(item => item.total),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Amount: ' + new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(context.parsed.y);
                                }
                            }
                        }
                    }
                }
            });

            // Category Chart
            const categoryCtx = document.getElementById('categoryChart').getContext('2d');
            const categoryData = @json($categoryBreakdown);
            
            new Chart(categoryCtx, {
                type: 'doughnut',
                data: {
                    labels: categoryData.map(item => item.label),
                    datasets: [{
                        data: categoryData.map(item => item.total),
                        backgroundColor: [
                            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = new Intl.NumberFormat('id-ID', {
                                        style: 'currency',
                                        currency: 'IDR'
                                    }).format(context.parsed);
                                    const percentage = ((context.parsed / categoryData.reduce((sum, item) => sum + item.total, 0)) * 100).toFixed(1);
                                    return `${label}: ${value} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush

    <!-- Flash Messages -->
    @if (session()->has('info'))
        <div class="fixed top-4 right-4 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded z-50"
             x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)">
            {{ session('info') }}
        </div>
    @endif
</div>