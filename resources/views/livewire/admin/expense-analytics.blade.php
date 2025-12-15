<div>
    <!-- Period Selection -->
    <div class="mb-6 bg-white p-4 rounded-lg shadow">
        <div class="flex flex-wrap items-center gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Period</label>
                <select wire:model.live="period" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="month">Monthly</option>
                    <option value="year">Yearly</option>
                    <option value="custom">Custom Range</option>
                </select>
            </div>

            @if($period === 'month' || $period === 'year')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                    <select wire:model.live="year" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @for($y = date('Y'); $y >= 2020; $y--)
                            <option value="{{ $y }}">{{ $y }}</option>
                        @endfor
                    </select>
                </div>
            @endif

            @if($period === 'month')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                    <select wire:model.live="month" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}">{{ \Carbon\Carbon::create()->month($m)->format('F') }}</option>
                        @endfor
                    </select>
                </div>
            @endif

            @if($period === 'custom')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                    <input type="date" wire:model.live="startDate" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">End Date</label>
                    <input type="date" wire:model.live="endDate" class="border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            @endif

            <div class="flex items-end">
                <button wire:click="exportData" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                    Export Data
                </button>
            </div>
        </div>
    </div>

    @if(!empty($analytics))
        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <!-- Total Expenses -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-icons.currency-dollar class="h-8 w-8 text-red-500" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Expenses</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ number_format($analytics['total_amount'], 0, ',', '.') }} IDR
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Revenue -->
            @if(!empty($profitability))
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-icons.trending-up class="h-8 w-8 text-green-500" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ number_format($profitability['revenue']['total'], 0, ',', '.') }} IDR
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gross Profit -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-icons.chart-bar class="h-8 w-8 {{ $profitability['profit']['gross'] >= 0 ? 'text-green-500' : 'text-red-500' }}" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Gross Profit</dt>
                                <dd class="text-lg font-medium {{ $profitability['profit']['gross'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($profitability['profit']['gross'], 0, ',', '.') }} IDR
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profit Margin -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <x-icons.adjustments class="h-8 w-8 {{ $profitability['profit']['margin_percentage'] >= 0 ? 'text-green-500' : 'text-red-500' }}" />
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Profit Margin</dt>
                                <dd class="text-lg font-medium {{ $profitability['profit']['margin_percentage'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ number_format($profitability['profit']['margin_percentage'], 1) }}%
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Category Breakdown Chart -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Expenses by Category</h3>
                <div class="h-64">
                    @if(!empty($chartData['categories']['data']) && array_sum($chartData['categories']['data']) > 0)
                        <canvas id="categoryChart" width="400" height="200"></canvas>
                    @else
                        <div class="flex items-center justify-center h-full text-gray-500">
                            <div class="text-center">
                                <x-icons.chart-bar class="h-12 w-12 mx-auto mb-2 text-gray-400" />
                                <p>No expense data available</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Trend Chart (for yearly view) -->
            @if($period === 'year' && !empty($chartData['trend']))
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Monthly Trend</h3>
                <div class="h-64">
                    <canvas id="trendChart" width="400" height="200"></canvas>
                </div>
            </div>
            @endif

            <!-- Profitability Breakdown -->
            @if(!empty($profitability) && $period !== 'year')
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Revenue vs Expenses</h3>
                <div class="h-64">
                    <canvas id="profitChart" width="400" height="200"></canvas>
                </div>
            </div>
            @endif
        </div>

        <!-- Category Details Table -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Category Breakdown</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Count</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Average</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($analytics['by_category'] as $key => $category)
                            @if($category['amount'] > 0)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                        @switch($key)
                                            @case('salary') bg-blue-100 text-blue-800 @break
                                            @case('utilities') bg-yellow-100 text-yellow-800 @break
                                            @case('supplies') bg-green-100 text-green-800 @break
                                            @case('marketing') bg-purple-100 text-purple-800 @break
                                            @default bg-gray-100 text-gray-800
                                        @endswitch">
                                        {{ $category['label'] }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($category['amount'], 0, ',', '.') }} IDR
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $category['count'] }} items
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 rounded-full h-2 mr-2">
                                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $category['percentage'] }}%"></div>
                                        </div>
                                        {{ number_format($category['percentage'], 1) }}%
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $category['count'] > 0 ? number_format($category['amount'] / $category['count'], 0, ',', '.') : 0 }} IDR
                                </td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-lg shadow p-12 text-center">
            <x-icons.chart-bar class="h-16 w-16 mx-auto text-gray-400 mb-4" />
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Data Available</h3>
            <p class="text-gray-500">Select a period to view expense analytics.</p>
        </div>
    @endif

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', function() {
            initializeCharts();
        });

        document.addEventListener('DOMContentLoaded', function() {
            initializeCharts();
        });

        function initializeCharts() {
            // Category Chart
            @if(!empty($chartData['categories']['data']) && array_sum($chartData['categories']['data']) > 0)
            const categoryCtx = document.getElementById('categoryChart');
            if (categoryCtx) {
                new Chart(categoryCtx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($chartData['categories']['labels']),
                        datasets: [{
                            data: @json($chartData['categories']['data']),
                            backgroundColor: [
                                '#3B82F6', '#EAB308', '#10B981', '#8B5CF6', '#6B7280'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }
                });
            }
            @endif

            // Trend Chart
            @if($period === 'year' && !empty($chartData['trend']))
            const trendCtx = document.getElementById('trendChart');
            if (trendCtx) {
                new Chart(trendCtx, {
                    type: 'line',
                    data: {
                        labels: @json($chartData['trend']['labels']),
                        datasets: [{
                            label: 'Monthly Expenses',
                            data: @json($chartData['trend']['data']),
                            borderColor: '#3B82F6',
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            tension: 0.4,
                            fill: true
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
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }
            @endif

            // Profitability Chart
            @if(!empty($profitability) && $period !== 'year')
            const profitCtx = document.getElementById('profitChart');
            if (profitCtx) {
                new Chart(profitCtx, {
                    type: 'bar',
                    data: {
                        labels: ['Revenue', 'Expenses', 'Profit'],
                        datasets: [{
                            data: [
                                {{ $profitability['revenue']['total'] }},
                                {{ $profitability['expenses']['total'] }},
                                {{ $profitability['profit']['gross'] }}
                            ],
                            backgroundColor: [
                                '#10B981',
                                '#EF4444', 
                                '{{ $profitability['profit']['gross'] >= 0 ? '#3B82F6' : '#EF4444' }}'
                            ],
                            borderWidth: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return new Intl.NumberFormat('id-ID', {
                                            style: 'currency',
                                            currency: 'IDR',
                                            minimumFractionDigits: 0
                                        }).format(value);
                                    }
                                }
                            }
                        }
                    }
                });
            }
            @endif
        }
    </script>
    @endpush
</div>