<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Nilai Hidup Pelanggan</title>
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
        .segment-vip {
            background-color: #ffd700;
            color: #000;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .segment-premium {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .segment-regular {
            background-color: #17a2b8;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .segment-basic {
            background-color: #6c757d;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .member-badge {
            background-color: #007bff;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
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
        <div class="report-title">Analisis Nilai Hidup Pelanggan</div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Ringkasan Nilai Hidup Pelanggan</div>
        <div class="summary-grid">
            <div class="summary-item">
                <span>Total Pelanggan:</span>
                <span>{{ number_format($reportData['summary']['total_customers']) }}</span>
            </div>
            <div class="summary-item">
                <span>Total Nilai Hidup:</span>
                <span>Rp {{ number_format($reportData['summary']['total_lifetime_value'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Rata-rata Nilai Hidup:</span>
                <span>Rp {{ number_format($reportData['summary']['average_lifetime_value'], 0, ',', '.') }}</span>
            </div>
            <div class="summary-item">
                <span>Top 10% Customer Value:</span>
                <span>Rp {{ number_format($reportData['summary']['top_10_percent_value'], 0, ',', '.') }}</span>

    <table>
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Phone</th>
                <th class="text-center">Status</th>
                <th class="text-right">Nilai Hidup</th>
                <th class="text-center">Bookings</th>
                <th class="text-right">Avg. Value</th>
                <th class="text-center">Frequency</th>
                <th class="text-center">Segment</th>
                <th>Last Booking</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reportData['customers'] as $customer)
            @php
                $ltv = $customer->lifetime_value ?? 0;
                $segmentClass = $ltv >= 10000000 ? 'segment-vip' : 
                               ($ltv >= 5000000 ? 'segment-premium' : 
                               ($ltv >= 2000000 ? 'segment-regular' : 'segment-basic'));
                $segment = $ltv >= 10000000 ? 'VIP' : 
                          ($ltv >= 5000000 ? 'Premium' : 
                          ($ltv >= 2000000 ? 'Regular' : 'Basic'));
            @endphp
            <tr>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->phone }}</td>
                <td class="text-center">
                    @if($customer->is_member ?? false)
                        <span class="member-badge">Member</span>
                    @else
                        Regular
                    @endif
                </td>
                <td class="text-right">Rp {{ number_format($ltv, 0, ',', '.') }}</td>
                <td class="text-center">{{ number_format($customer->total_bookings ?? 0) }}</td>
                <td class="text-right">Rp {{ number_format($customer->average_booking_value ?? 0, 0, ',', '.') }}</td>
                <td class="text-center">{{ number_format($customer->booking_frequency_days ?? 0, 1) }} days</td>
                <td class="text-center">
                    <span class="{{ $segmentClass }}">{{ $segment }}</span>
                </td>
                <td>{{ $customer->last_booking_date ?? 'Never' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666;">
        <p><strong>Segmen Pelanggan:</strong></p>
        <ul>
            <li><span class="segment-vip">VIP</span>: Nilai Hidup ≥ Rp 10,000,000</li>
            <li><span class="segment-premium">Premium</span>: Nilai Hidup Rp 5,000,000 - 9,999,999</li>
            <li><span class="segment-regular">Regular</span>: Nilai Hidup Rp 2,000,000 - 4,999,999</li>
            <li><span class="segment-basic">Basic</span>: Nilai Hidup < Rp 2,000,000</li>
        </ul>
        <p><strong>Notes:</strong></p>
        <ul>
            <li>Nilai Hidup = Total pendapatan yang dihasilkan oleh pelanggan selama semua peminjaman</li>
            <li>Frekuensi Peminjaman = Rata-rata hari antara peminjaman</li>
            <li>Fokuskan upaya pemasaran pada segmen VIP dan Premium</li>
        </ul>
    </div>
</body>
</html>