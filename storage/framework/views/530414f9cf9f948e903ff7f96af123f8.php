<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuntungan</title>
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
        <div class="report-title">Analisis Keuntungan</div>
        <div class="period">Periode: <?php echo e($reportData['period']['start_date']); ?> to <?php echo e($reportData['period']['end_date']); ?></div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Ringkasan Keuntungan</div>
        <div class="summary-grid">
            <div class="summary-item">
                <span>Total Kendaraan:</span>
                <span><?php echo e(number_format($reportData['summary']['total_vehicles'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Kendaraan Profitable:</span>
                <span><?php echo e(number_format($reportData['summary']['profitable_vehicles'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Total Pendapatan:</span>
                <span>Rp <?php echo e(number_format($reportData['summary']['total_revenue'], 0, ',', '.')); ?></span>
            </div>
            <div class="summary-item">
                <span>Total Biaya Pemeliharaan:</span>
                <span>Rp <?php echo e(number_format($reportData['summary']['total_maintenance_costs'], 0, ',', '.')); ?></span>
            </div>
            <div class="summary-item">
                <span>Total Laba:</span>
                <span>Rp <?php echo e(number_format($reportData['summary']['total_net_profit'], 0, ',', '.')); ?></span>
            </div>
            <div class="summary-item">
                <span>Margin Laba:</span>
                <span><?php echo e(number_format($reportData['summary']['average_profit_margin'], 2)); ?>%</span>
            </div>
        </div>
    </div>    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if: ?>
(isset($reportData['summary']['best_performer']))
    <div class="highlight-box">
        <strong>Pemilik Kendaraan Terbaik:</strong> 
        <?php echo e($reportData['summary']['best_performer']->license_plate); ?> 
        - Laba: Rp <?php echo e(number_format($reportData['summary']['best_performer']->net_profit ?? 0, 0, ',', '.')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($reportData['summary']['worst_performer'])): ?>
    <div class="highlight-box">
        <strong>Pemilik Kendaraan yang Memerlukan Perhatian:</strong> 
        <?php echo e($reportData['summary']['worst_performer']->license_plate); ?> 
        - Laba: Rp <?php echo e(number_format($reportData['summary']['worst_performer']->net_profit ?? 0, 0, ',', '.')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Plat Kendaraan</th>
                <th>Kendaraan</th>
                <th class="text-right">Pendapatan</th>
                <th class="text-right">Biaya Pemeliharaan</th>
                <th class="text-right">Laba</th>
                <th class="text-center">Margin Laba %</th>
                <th class="text-center">Utilization %</th>
                <th class="text-right">Rev/Day</th>
                <th class="text-center">Performance</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['vehicles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $profitMargin = $vehicle->profit_margin ?? 0;
                $performanceClass = $profitMargin >= 30 ? 'profit-excellent' : 
                                   ($profitMargin >= 15 ? 'profit-good' : 
                                   ($profitMargin >= 5 ? 'profit-average' : 'profit-poor'));
                $performance = $profitMargin >= 30 ? 'Excellent' : 
                              ($profitMargin >= 15 ? 'Good' : 
                              ($profitMargin >= 5 ? 'Average' : 'Poor'));
            ?>
            <tr>
                <td><?php echo e($vehicle->license_plate); ?></td>
                <td><?php echo e($vehicle->brand); ?> <?php echo e($vehicle->model); ?> (<?php echo e($vehicle->year); ?>)</td>
                <td class="text-right">Rp <?php echo e(number_format($vehicle->revenue ?? 0, 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($vehicle->maintenance_costs ?? 0, 0, ',', '.')); ?></td>
                <td class="text-right">
                    <span class="<?php echo e(($vehicle->net_profit ?? 0) >= 0 ? 'profit-excellent' : 'profit-poor'); ?>">
                        Rp <?php echo e(number_format($vehicle->net_profit ?? 0, 0, ',', '.')); ?>

                    </span>
                </td>
                <td class="text-center">
                    <span class="<?php echo e($performanceClass); ?>"><?php echo e(number_format($profitMargin, 2)); ?>%</span>
                </td>
                <td class="text-center"><?php echo e(number_format($vehicle->utilization_rate ?? 0, 2)); ?>%</td>
                <td class="text-right">Rp <?php echo e(number_format($vehicle->revenue_per_day ?? 0, 0, ',', '.')); ?></td>
                <td class="text-center">
                    <span class="<?php echo e($performanceClass); ?>"><?php echo e($performance); ?></span>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666;">
        <p><strong>Rating Performa:</strong></p>
        <ul>
            <li><span class="profit-excellent">Excellent</span>: Margin Laba ≥ 30%</li>
            <li><span class="profit-good">Good</span>: Margin Laba 15-29%</li>
            <li><span class="profit-average">Average</span>: Margin Laba 5-14%</li>
            <li><span class="profit-poor">Poor</span>: Margin Laba < 5%</li>
        </ul>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/admin/reports/pdf/profitability.blade.php ENDPATH**/ ?>