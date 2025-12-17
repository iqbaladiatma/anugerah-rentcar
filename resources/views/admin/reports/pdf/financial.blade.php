<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan</title>
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
        .section {
            margin: 20px 0;
        }
        .section-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }
        .financial-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .financial-box {
            border: 1px solid #ddd;
            padding: 15px;
        }
        .financial-item {
            display: flex;
            justify-content: space-between;
            margin: 5px 0;
        }
        .financial-item.total {
            font-weight: bold;
            border-top: 1px solid #333;
            padding-top: 5px;
            margin-top: 10px;
        }
        .profit-positive {
            color: #28a745;
            font-weight: bold;
        }
        .profit-negative {
            color: #dc3545;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
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
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Anugerah Rentcar</div>
        <div class="report-title">Laporan Keuangan</div>
        <div class="period">Periode: {{ $reportData['period']['start_date'] }} sampai {{ $reportData['period']['end_date'] }}</div>
    </div>

    <div class="financial-grid">
        <div class="financial-box">
            <div class="section-title">Pendapatan</div>
            <div class="financial-item">
                <span>Pendapatan Rental:</span>
                <span>Rp {{ number_format($reportData['revenue']['rental_income'], 0, ',', '.') }}</span>
            </div>
            <div class="financial-item">
                <span>Driver Fees:</span>
                <span>Rp {{ number_format($reportData['revenue']['driver_fees'], 0, ',', '.') }}</span>
            </div>
            <div class="financial-item">
                <span>Out of Town Fees:</span>
                <span>Rp {{ number_format($reportData['revenue']['out_of_town_fees'], 0, ',', '.') }}</span>
            </div>
            <div class="financial-item">
                <span>Late Penalties:</span>
                <span>Rp {{ number_format($reportData['revenue']['late_penalties'], 0, ',', '.') }}</span>
            </div>
            <div class="financial-item">
                <span>Member Discounts:</span>
                <span>(Rp {{ number_format($reportData['revenue']['member_discounts'], 0, ',', '.') }})</span>
            </div>
            <div class="financial-item total">
                <span>Total Net Revenue:</span>
                <span>Rp {{ number_format($reportData['revenue']['total_net_revenue'], 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="financial-box">
            <div class="section-title">Biaya</div>
            <div class="financial-item">
                <span>Biaya Operasional:</span>
                <span>Rp {{ number_format($reportData['expenses']['operational'], 0, ',', '.') }}</span>
            </div>
            <div class="financial-item">
                <span>Biaya Pemeliharaan:</span>
                <span>Rp {{ number_format($reportData['expenses']['maintenance'], 0, ',', '.') }}</span>
            </div>
            <div class="financial-item total">
                <span>Total Biaya:</span>
                <span>Rp {{ number_format($reportData['expenses']['total'], 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Analisis Laba Rugi</div>
        <div class="financial-item">
            <span>Laba Bruto:</span>
            <span class="{{ $reportData['profit_loss']['gross_profit'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                Rp {{ number_format($reportData['profit_loss']['gross_profit'], 0, ',', '.') }}
            </span>
        </div>
        <div class="financial-item">
            <span>Margin Laba:</span>
            <span class="{{ $reportData['profit_loss']['profit_margin'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                {{ number_format($reportData['profit_loss']['profit_margin'], 2) }}%
            </span>
        </div>
        <div class="financial-item">
            <span>Revenue per Booking:</span>
            <span>Rp {{ number_format($reportData['profit_loss']['revenue_per_booking'], 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Pendapatan Bulanan</div>
        <table>
            <thead>
                <tr>
                    <th>Bulan</th>
                    <th class="text-right">Pendapatan</th>
                    <th class="text-right">Biaya</th>
                    <th class="text-right">Laba</th>
                    <th class="text-center">Peminjaman</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData['monthly_breakdown'] as $month)
                <tr>
                    <td>{{ $month['month_name'] }}</td>
                    <td class="text-right">Rp {{ number_format($month['revenue'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($month['expenses'], 0, ',', '.') }}</td>
                    <td class="text-right {{ $month['profit'] >= 0 ? 'profit-positive' : 'profit-negative' }}">
                        Rp {{ number_format($month['profit'], 0, ',', '.') }}
                    </td>
                    <td class="text-center">{{ $month['bookings_count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if(count($reportData['expenses']['by_category']) > 0)
    <div class="section">
        <div class="section-title">Kategori Biaya</div>
        <table>
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th class="text-right">Jumlah</th>
                    <th class="text-center">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData['expenses']['by_category'] as $category => $data)
                <tr>
                    <td>{{ ucfirst($category) }}</td>
                    <td class="text-right">Rp {{ number_format($data['amount'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ $data['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</body>
</html>