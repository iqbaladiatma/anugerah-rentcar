<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vehicle Report</title>
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
        <div class="report-title">Vehicle Utilization & Revenue Report</div>
        <div class="period">Period: <?php echo e($reportData['period']['start_date']); ?> to <?php echo e($reportData['period']['end_date']); ?> (<?php echo e($reportData['period']['total_days']); ?> days)</div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Fleet Summary</div>
        <div class="summary-grid">
            <div class="summary-item">
                <span>Total Vehicles:</span>
                <span><?php echo e(number_format($reportData['fleet_summary']['total_vehicles'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Average Utilization:</span>
                <span><?php echo e(number_format($reportData['fleet_summary']['average_utilization'], 2)); ?>%</span>
            </div>
            <div class="summary-item">
                <span>Total Fleet Revenue:</span>
                <span>Rp <?php echo e(number_format($reportData['fleet_summary']['total_fleet_revenue'], 0, ',', '.')); ?></span>
            </div>
            <div class="summary-item">
                <span>Total Maintenance Costs:</span>
                <span>Rp <?php echo e(number_format($reportData['fleet_summary']['total_maintenance_costs'], 0, ',', '.')); ?></span>
            </div>
        </div>
    </div>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportData['fleet_summary']['most_profitable_vehicle']): ?>
    <div class="highlight-box">
        <strong>Most Profitable Vehicle:</strong> 
        <?php echo e($reportData['fleet_summary']['most_profitable_vehicle']->license_plate); ?> 
        (<?php echo e($reportData['fleet_summary']['most_profitable_vehicle']->brand); ?> <?php echo e($reportData['fleet_summary']['most_profitable_vehicle']->model); ?>)
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($reportData['fleet_summary']['highest_utilization_vehicle']): ?>
    <div class="highlight-box">
        <strong>Highest Utilization Vehicle:</strong> 
        <?php echo e($reportData['fleet_summary']['highest_utilization_vehicle']->license_plate); ?> 
        (<?php echo e($reportData['fleet_summary']['highest_utilization_vehicle']->brand); ?> <?php echo e($reportData['fleet_summary']['highest_utilization_vehicle']->model); ?>)
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>License Plate</th>
                <th>Vehicle</th>
                <th class="text-center">Bookings</th>
                <th class="text-center">Days Booked</th>
                <th class="text-center">Utilization %</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">Maintenance</th>
                <th class="text-right">Net Revenue</th>
                <th class="text-right">Rev/Day</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['vehicles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vehicleData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($vehicleData['vehicle']->license_plate); ?></td>
                <td><?php echo e($vehicleData['vehicle']->brand); ?> <?php echo e($vehicleData['vehicle']->model); ?> (<?php echo e($vehicleData['vehicle']->year); ?>)</td>
                <td class="text-center"><?php echo e($vehicleData['total_bookings']); ?></td>
                <td class="text-center"><?php echo e($vehicleData['total_booked_days']); ?></td>
                <td class="text-center">
                    <?php
                        $utilization = $vehicleData['utilization_rate'];
                        $class = $utilization >= 70 ? 'utilization-high' : ($utilization >= 40 ? 'utilization-medium' : 'utilization-low');
                    ?>
                    <span class="<?php echo e($class); ?>"><?php echo e(number_format($utilization, 1)); ?>%</span>
                </td>
                <td class="text-right">Rp <?php echo e(number_format($vehicleData['total_revenue'], 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($vehicleData['maintenance_costs'], 0, ',', '.')); ?></td>
                <td class="text-right">
                    <?php
                        $netRevenue = $vehicleData['net_revenue'];
                        $class = $netRevenue >= 0 ? 'utilization-high' : 'utilization-low';
                    ?>
                    <span class="<?php echo e($class); ?>">Rp <?php echo e(number_format($netRevenue, 0, ',', '.')); ?></span>
                </td>
                <td class="text-right">Rp <?php echo e(number_format($vehicleData['revenue_per_day'], 0, ',', '.')); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666;">
        <p><strong>Notes:</strong></p>
        <ul>
            <li>Utilization Rate = (Total Booked Days / Total Period Days) × 100%</li>
            <li>Net Revenue = Total Revenue - Maintenance Costs</li>
            <li>Revenue per Day = Total Revenue / Total Booked Days</li>
            <li>Color coding: Green (≥70%), Yellow (40-69%), Red (<40%)</li>
        </ul>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\reports\pdf\vehicle.blade.php ENDPATH**/ ?>