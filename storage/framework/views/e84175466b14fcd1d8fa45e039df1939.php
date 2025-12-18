<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
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
        .metrics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .metrics-box {
            border: 1px solid #ddd;
            padding: 15px;
        }
        .metrics-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }
        .metric-item {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 4px 0;
        }
        .metric-value {
            font-weight: bold;
        }
        .highlight {
            background-color: #f8f9fa;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
        }
        .positive {
            color: #28a745;
        }
        .negative {
            color: #dc3545;
        }
        .warning {
            color: #ffc107;
        }
    </style>
</head>
<body>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Analytics Report</title>
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
        .metrics-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin: 20px 0;
        }
        .metrics-box {
            border: 1px solid #ddd;
            padding: 15px;
        }
        .metrics-title {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #333;
        }
        .metric-item {
            display: flex;
            justify-content: space-between;
            margin: 8px 0;
            padding: 4px 0;
        }
        .metric-value {
            font-weight: bold;
        }
        .highlight {
            background-color: #f8f9fa;
            padding: 10px;
            margin: 10px 0;
            border-left: 4px solid #007bff;
        }
        .positive {
            color: #28a745;
        }
        .negative {
            color: #dc3545;
        }
        .warning {
            color: #ffc107;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Anugerah Rentcar</div>
        <div class="report-title">Laporan Analitik</div>
        <div class="period">Periode: <?php echo e($reportData['period']['start_date']); ?> to <?php echo e($reportData['period']['end_date']); ?></div>
    </div>

    <div class="metrics-grid">
        <div class="metrics-box">
            <div class="metrics-title">Indikator Kinerja Utama</div>
            <div class="metric-item">
                <span>Total Pendapatan:</span>
                <span class="metric-value">Rp <?php echo e(number_format($reportData['analytics']['revenue_analytics']['current_revenue'] ?? 0, 0, ',', '.')); ?></span>
            </div>
            <div class="metric-item">
                <span>Total Bookings:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['revenue_analytics']['total_bookings'] ?? 0)); ?></span>
            </div>
            <div class="metric-item">
                <span>Average Booking Value:</span>
                <span class="metric-value">Rp <?php echo e(number_format($reportData['analytics']['revenue_analytics']['average_revenue_per_booking'] ?? 0, 0, ',', '.')); ?></span>
            </div>
            <div class="metric-item">
                <span>Fleet Utilization Rate:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['vehicle_analytics']['average_utilization'] ?? 0, 2)); ?>%</span>
            </div>
        </div>

        <div class="metrics-box">
            <div class="metrics-title">Indikator Pertumbuhan</div>
            <div class="metric-item">
                <span>Revenue Growth Rate:</span>
                <span class="metric-value <?php echo e(($reportData['analytics']['revenue_analytics']['growth_percentage'] ?? 0) >= 0 ? 'positive' : 'negative'); ?>">
                    <?php echo e(number_format($reportData['analytics']['revenue_analytics']['growth_percentage'] ?? 0, 2)); ?>%
                </span>
            </div>
            <div class="metric-item">
                <span>Customer Retention Rate:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['customer_analytics']['repeat_rate'] ?? 0, 2)); ?>%</span>
            </div>
            <div class="metric-item">
                <span>New Customers:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['customer_analytics']['new_customers'] ?? 0)); ?></span>
            </div>
            <div class="metric-item">
                <span>Member Conversion Rate:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['customer_analytics']['member_conversion_rate'] ?? 0, 2)); ?>%</span>
            </div>
        </div>
    </div>    <div
 class="metrics-grid">
        <div class="metrics-box">
            <div class="metrics-title">Indikator Operasional</div>
            <div class="metric-item">
                <span>Peminjaman Selesai:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['revenue_analytics']['total_bookings'] ?? 0)); ?></span>
            </div>
            <div class="metric-item">
                <span>Cancelled Bookings:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['cancelled_bookings'] ?? 0)); ?></span>
            </div>
            <div class="metric-item">
                <span>Late Returns:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['late_returns'] ?? 0)); ?></span>
            </div>
            <div class="metric-item">
                <span>Average Booking Duration:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['average_booking_duration'] ?? 0, 1)); ?> days</span>
            </div>
        </div>

        <div class="metrics-box">
            <div class="metrics-title">Indikator Keuangan</div>
            <div class="metric-item">
                <span>Margin Laba:</span>
                <span class="metric-value <?php echo e(($reportData['analytics']['gross_profit_margin'] ?? 0) >= 20 ? 'positive' : 'warning'); ?>">
                    <?php echo e(number_format($reportData['analytics']['gross_profit_margin'] ?? 0, 2)); ?>%
                </span>
            </div>
            <div class="metric-item">
                <span>Biaya Operasional:</span>
                <span class="metric-value"><?php echo e(number_format($reportData['analytics']['operating_expense_ratio'] ?? 0, 2)); ?>%</span>
            </div>
            <div class="metric-item">
                <span>Pendapatan per Kendaraan:</span>
                <span class="metric-value">Rp <?php echo e(number_format($reportData['analytics']['revenue_per_vehicle'] ?? 0, 0, ',', '.')); ?></span>
            </div>
            <div class="metric-item">
                <span>Average Customer LTV:</span>
                <span class="metric-value">Rp <?php echo e(number_format($reportData['analytics']['average_customer_ltv'] ?? 0, 0, ',', '.')); ?></span>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($reportData['profitability']) && count($reportData['profitability']) > 0): ?>
    <div class="highlight">
        <strong>Top Performing Vehicles (Top 5):</strong>
        <ul>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['profitability']->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($vehicle['vehicle']->license_plate); ?> - Profit: Rp <?php echo e(number_format($vehicle['net_profit'] ?? 0, 0, ',', '.')); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($reportData['customer_ltv']) && count($reportData['customer_ltv']) > 0): ?>
    <div class="highlight">
        <strong>Top Value Customers (Top 5):</strong>
        <ul>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['customer_ltv']->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($customer['customer']->name); ?> - LTV: Rp <?php echo e(number_format($customer['lifetime_value'] ?? 0, 0, ',', '.')); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/reports/pdf/analytics.blade.php ENDPATH**/ ?>