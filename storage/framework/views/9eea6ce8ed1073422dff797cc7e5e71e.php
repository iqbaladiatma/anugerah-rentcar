<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Financial Report</title>
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
        <div class="report-title">Financial Report</div>
        <div class="period">Period: <?php echo e($reportData['period']['start_date']); ?> to <?php echo e($reportData['period']['end_date']); ?></div>
    </div>

    <div class="financial-grid">
        <div class="financial-box">
            <div class="section-title">Revenue Breakdown</div>
            <div class="financial-item">
                <span>Rental Income:</span>
                <span>Rp <?php echo e(number_format($reportData['revenue']['rental_income'], 0, ',', '.')); ?></span>
            </div>
            <div class="financial-item">
                <span>Driver Fees:</span>
                <span>Rp <?php echo e(number_format($reportData['revenue']['driver_fees'], 0, ',', '.')); ?></span>
            </div>
            <div class="financial-item">
                <span>Out of Town Fees:</span>
                <span>Rp <?php echo e(number_format($reportData['revenue']['out_of_town_fees'], 0, ',', '.')); ?></span>
            </div>
            <div class="financial-item">
                <span>Late Penalties:</span>
                <span>Rp <?php echo e(number_format($reportData['revenue']['late_penalties'], 0, ',', '.')); ?></span>
            </div>
            <div class="financial-item">
                <span>Member Discounts:</span>
                <span>(Rp <?php echo e(number_format($reportData['revenue']['member_discounts'], 0, ',', '.')); ?>)</span>
            </div>
            <div class="financial-item total">
                <span>Total Net Revenue:</span>
                <span>Rp <?php echo e(number_format($reportData['revenue']['total_net_revenue'], 0, ',', '.')); ?></span>
            </div>
        </div>

        <div class="financial-box">
            <div class="section-title">Expense Breakdown</div>
            <div class="financial-item">
                <span>Operational Expenses:</span>
                <span>Rp <?php echo e(number_format($reportData['expenses']['operational'], 0, ',', '.')); ?></span>
            </div>
            <div class="financial-item">
                <span>Maintenance Costs:</span>
                <span>Rp <?php echo e(number_format($reportData['expenses']['maintenance'], 0, ',', '.')); ?></span>
            </div>
            <div class="financial-item total">
                <span>Total Expenses:</span>
                <span>Rp <?php echo e(number_format($reportData['expenses']['total'], 0, ',', '.')); ?></span>
            </div>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Profit & Loss Analysis</div>
        <div class="financial-item">
            <span>Gross Profit:</span>
            <span class="<?php echo e($reportData['profit_loss']['gross_profit'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                Rp <?php echo e(number_format($reportData['profit_loss']['gross_profit'], 0, ',', '.')); ?>

            </span>
        </div>
        <div class="financial-item">
            <span>Profit Margin:</span>
            <span class="<?php echo e($reportData['profit_loss']['profit_margin'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                <?php echo e(number_format($reportData['profit_loss']['profit_margin'], 2)); ?>%
            </span>
        </div>
        <div class="financial-item">
            <span>Revenue per Booking:</span>
            <span>Rp <?php echo e(number_format($reportData['profit_loss']['revenue_per_booking'], 0, ',', '.')); ?></span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Monthly Breakdown</div>
        <table>
            <thead>
                <tr>
                    <th>Month</th>
                    <th class="text-right">Revenue</th>
                    <th class="text-right">Expenses</th>
                    <th class="text-right">Profit</th>
                    <th class="text-center">Bookings</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['monthly_breakdown']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $month): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($month['month_name']); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($month['revenue'], 0, ',', '.')); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($month['expenses'], 0, ',', '.')); ?></td>
                    <td class="text-right <?php echo e($month['profit'] >= 0 ? 'profit-positive' : 'profit-negative'); ?>">
                        Rp <?php echo e(number_format($month['profit'], 0, ',', '.')); ?>

                    </td>
                    <td class="text-center"><?php echo e($month['bookings_count']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($reportData['expenses']['by_category']) > 0): ?>
    <div class="section">
        <div class="section-title">Expense Categories</div>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th class="text-right">Amount</th>
                    <th class="text-center">Count</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['expenses']['by_category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e(ucfirst($category)); ?></td>
                    <td class="text-right">Rp <?php echo e(number_format($data['amount'], 0, ',', '.')); ?></td>
                    <td class="text-center"><?php echo e($data['count']); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\reports\pdf\financial.blade.php ENDPATH**/ ?>