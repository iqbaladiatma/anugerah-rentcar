<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Profitability Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .period {
            font-size: 12px;
            color: #666;
        }
        .summary-box {
            background-color: #f8f9fa;
            padding: 15px;
            margin: 20px 0;
            border: 1px solid #dee2e6;
        }
        .summary-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .profit-excellent {
            color: #28a745;
            font-weight: bold;
        }
        .profit-good {
            color: #17a2b8;
            font-weight: bold;
        }
        .profit-average {
            color: #ffc107;
            font-weight: bold;
        }
        .profit-poor {
            color: #dc3545;
            font-weight: bold;
        }
        .highlight-box {
            background-color: #e9ecef;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Anugerah Rentcar</div>
        <div class="report-title">Vehicle Profitability Analysis</div>
        <div class="period">Period: {{ $reportData['period']['start_date'] }} to {{ $reportData['period']['end_date'] }}</div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Profitability Summary</div>
        <div class="summary-grid">
            <div class="summary-item">
                <span>Total Vehicles:</span>
                <span>{{ number_format($reportData['summary']['total_vehicles']) }}</span>
            </div>
            <div class="summary-item">
                <span>Profitable Vehicles:</span>
                <span>{{ number_format($reportData['summary']['profitable_vehicles']) }}</span>
            </div>
            <div class="summary-item">
                <span>Total Revenue:</span>
                <span>Rp {{ number_format($reportData['summary']['total_revenue'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Total Maintenance Costs:</span>
                <span>Rp {{ number_format($reportData['summary']['total_maintenance_costs'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Total Net Profit:</span>
                <span>Rp {{ number_format($reportData['summary']['total_net_profit'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Average Profit Margin:</span>
                <span>{{ number_format($reportData['summary']['average_profit_margin'], 2) }}%</span>
            </div>
        </div>
    </div>    @if
(isset($reportData['summary']['best_performer']))
    <div class="highlight-box">
        <strong>Best Performer:</strong> 
        {{ $reportData['summary']['best_performer']->license_plate }} 
        - Net Profit: Rp {{ number_format($reportData['summary']['best_performer']->net_profit ?? 0, 0, ',', '.') }}
    </div>
    @endif

    @if(isset($reportData['summary']['worst_performer']))
    <div class="highlight-box">
        <strong>Needs Attention:</strong> 
        {{ $reportData['summary']['worst_performer']->license_plate }} 
        - Net Profit: Rp {{ number_format($reportData['summary']['worst_performer']->net_profit ?? 0, 0, ',', '.') }}
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>License Plate</th>
                <th>Vehicle</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">Maintenance</th>
                <th class="text-right">Net Profit</th>
                <th class="text-center">Profit Margin %</th>
                <th class="text-center">Utilization %</th>
                <th class="text-right">Rev/Day</th>
                <th class="text-center">Performance</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['vehicles'] as $vehicle)
            @php
                $profitMargin = $vehicle->profit_margin ?? 0;
                $performanceClass = $profitMargin >= 30 ? 'profit-excellent' : 
                                   ($profitMargin >= 15 ? 'profit-good' : 
                                   ($profitMargin >= 5 ? 'profit-average' : 'profit-poor'));
                $performance = $profitMargin >= 30 ? 'Excellent' : 
                              ($profitMargin >= 15 ? 'Good' : 
                              ($profitMargin >= 5 ? 'Average' : 'Poor'));
            @endphp
            <tr>
                <td>{{ $vehicle->license_plate }}</td>
                <td>{{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->year }})</td>
                <td class="text-right">Rp {{ number_format($vehicle->revenue ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($vehicle->maintenance_costs ?? 0, 0, ',', '.') }}</td>
                <td class="text-right">
                    <span class="{{ ($vehicle->net_profit ?? 0) >= 0 ? 'profit-excellent' : 'profit-poor' }}">
                        Rp {{ number_format($vehicle->net_profit ?? 0, 0, ',', '.') }}
                    </span>
                </td>
                <td class="text-center">
                    <span class="{{ $performanceClass }}">{{ number_format($profitMargin, 2) }}%</span>
                </td>
                <td class="text-center">{{ number_format($vehicle->utilization_rate ?? 0, 2) }}%</td>
                <td class="text-right">Rp {{ number_format($vehicle->revenue_per_day ?? 0, 0, ',', '.') }}</td>
                <td class="text-center">
                    <span class="{{ $performanceClass }}">{{ $performance }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666;">
        <p><strong>Performance Rating:</strong></p>
        <ul>
            <li><span class="profit-excellent">Excellent</span>: Profit Margin ≥ 30%</li>
            <li><span class="profit-good">Good</span>: Profit Margin 15-29%</li>
            <li><span class="profit-average">Average</span>: Profit Margin 5-14%</li>
            <li><span class="profit-poor">Poor</span>: Profit Margin < 5%</li>
        </ul>
    </div>
</body>
</html>