<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Kendaraan</title>
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
        .utilization-high {
            color: #28a745;
            font-weight: bold;
        }
        .utilization-medium {
            color: #ffc107;
            font-weight: bold;
        }
        .utilization-low {
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
        <div class="report-title">Laporan Utilisasi & Pendapatan Kendaraan</div>
        <div class="period">Periode: {{ $reportData['period']['start_date'] }} to {{ $reportData['period']['end_date'] }} ({{ $reportData['period']['total_days'] }} days)</div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Ringkasan Armada</div>
        <div class="summary-grid">
            <div class="summary-item">
                <span>Total Kendaraan:</span>
                <span>{{ number_format($reportData['fleet_summary']['total_vehicles']) }}</span>
            </div>
            <div class="summary-item">
                <span>Average Utilisasi:</span>
                <span>{{ number_format($reportData['fleet_summary']['average_utilization'], 2) }}%</span>
            </div>
            <div class="summary-item">
                <span>Total Pendapatan Armada:</span>
                <span>Rp {{ number_format($reportData['fleet_summary']['total_fleet_revenue'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Total Biaya Pemeliharaan:</span>
                <span>Rp {{ number_format($reportData['fleet_summary']['total_maintenance_costs'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    @if($reportData['fleet_summary']['most_profitable_vehicle'])
    <div class="highlight-box">
        <strong>Kendaraan yang Paling Laku:</strong> 
        {{ $reportData['fleet_summary']['most_profitable_vehicle']->license_plate }} 
        ({{ $reportData['fleet_summary']['most_profitable_vehicle']->brand }} {{ $reportData['fleet_summary']['most_profitable_vehicle']->model }})
    </div>
    @endif

    @if($reportData['fleet_summary']['highest_utilization_vehicle'])
    <div class="highlight-box">
        <strong>Kendaraan dengan Utilisasi Terendah:</strong> 
        {{ $reportData['fleet_summary']['highest_utilization_vehicle']->license_plate }} 
        ({{ $reportData['fleet_summary']['highest_utilization_vehicle']->brand }} {{ $reportData['fleet_summary']['highest_utilization_vehicle']->model }})
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>Plat Kendaraan</th>
                <th>Kendaraan</th>
                <th class="text-center">Booking</th>
                <th class="text-center">Hari Booked</th>
                <th class="text-center">Utilisasi %</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">Pemeliharaan</th>
                <th class="text-right">Net Revenue</th>
                <th class="text-right">Rev/Hari</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['vehicles'] as $vehicleData)
            <tr>
                <td>{{ $vehicleData['vehicle']->license_plate }}</td>
                <td>{{ $vehicleData['vehicle']->brand }} {{ $vehicleData['vehicle']->model }} ({{ $vehicleData['vehicle']->year }})</td>
                <td class="text-center">{{ $vehicleData['total_bookings'] }}</td>
                <td class="text-center">{{ $vehicleData['total_booked_days'] }}</td>
                <td class="text-center">
                    @php
                        $utilization = $vehicleData['utilization_rate'];
                        $class = $utilization >= 70 ? 'utilization-high' : ($utilization >= 40 ? 'utilization-medium' : 'utilization-low');
                    @endphp
                    <span class="{{ $class }}">{{ number_format($utilization, 1) }}%</span>
                </td>
                <td class="text-right">Rp {{ number_format($vehicleData['total_revenue'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($vehicleData['maintenance_costs'], 0, ',', '.') }}</td>
                <td class="text-right">
                    @php
                        $netRevenue = $vehicleData['net_revenue'];
                        $class = $netRevenue >= 0 ? 'utilization-high' : 'utilization-low';
                    @endphp
                    <span class="{{ $class }}">Rp {{ number_format($netRevenue, 0, ',', '.') }}</span>
                </td>
                <td class="text-right">Rp {{ number_format($vehicleData['revenue_per_day'], 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666;">
        <p><strong>Notes:</strong></p>
        <ul>
            <li>Utilisasi Rate = (Hari Booked / Hari Total) × 100%</li>
            <li>Net Revenue = Total Revenue - Pemeliharaan</li>
            <li>Revenue per Day = Total Revenue / Hari Booked</li>
            <li>Color coding: Green (≥70%), Yellow (40-69%), Red (<40%)</li>
        </ul>
    </div>
</body>
</html>