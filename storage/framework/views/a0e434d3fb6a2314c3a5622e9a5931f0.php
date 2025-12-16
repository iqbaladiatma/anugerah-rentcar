<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Lifetime Value Report</title>
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
        <div class="report-title">Customer Lifetime Value Analysis</div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Customer LTV Summary</div>
        <div class="summary-grid">
            <div class="summary-item">
                <span>Total Customers:</span>
                <span><?php echo e(number_format($reportData['summary']['total_customers'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Total Lifetime Value:</span>
                <span>Rp <?php echo e(number_format($reportData['summary']['total_lifetime_value'], 0, ',', '.')); ?></span>
            </div>
            <div class="summary-item">
                <span>Average Lifetime Value:</span>
                <span>Rp <?php echo e(number_format($reportData['summary']['average_lifetime_value'], 0, ',', '.')); ?></span>
            </div>
            <div class="summary-item">
                <span>Top 10% Customer Value:</span>
                <span>Rp <?php echo e(number_format($reportData['summary']['top_10_percent_value'], 0, ',', '.')); ?></span>
            </div>
            <div class="summary-item">
                <span>Average Booking Frequency:</span>
                <span><?php echo e(number_format($reportData['summary']['average_booking_frequency'], 1)); ?> days</span>
            </div>
        </div>
    </div>    @i
f(isset($reportData['summary']['highest_ltv_customer']))
    <div class="highlight-box">
        <strong>Highest Value Customer:</strong> 
        <?php echo e($reportData['summary']['highest_ltv_customer']->name); ?> 
        - LTV: Rp <?php echo e(number_format($reportData['summary']['highest_ltv_customer']->lifetime_value ?? 0, 0, ',', '.')); ?>

    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Phone</th>
                <th class="text-center">Status</th>
                <th class="text-right">Lifetime Value</th>
                <th class="text-center">Bookings</th>
                <th class="text-right">Avg. Value</th>
                <th class="text-center">Frequency</th>
                <th class="text-center">Segment</th>
                <th>Last Booking</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['customers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $ltv = $customer->lifetime_value ?? 0;
                $segmentClass = $ltv >= 10000000 ? 'segment-vip' : 
                               ($ltv >= 5000000 ? 'segment-premium' : 
                               ($ltv >= 2000000 ? 'segment-regular' : 'segment-basic'));
                $segment = $ltv >= 10000000 ? 'VIP' : 
                          ($ltv >= 5000000 ? 'Premium' : 
                          ($ltv >= 2000000 ? 'Regular' : 'Basic'));
            ?>
            <tr>
                <td><?php echo e($customer->name); ?></td>
                <td><?php echo e($customer->phone); ?></td>
                <td class="text-center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customer->is_member ?? false): ?>
                        <span class="member-badge">Member</span>
                    <?php else: ?>
                        Regular
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="text-right">Rp <?php echo e(number_format($ltv, 0, ',', '.')); ?></td>
                <td class="text-center"><?php echo e(number_format($customer->total_bookings ?? 0)); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($customer->average_booking_value ?? 0, 0, ',', '.')); ?></td>
                <td class="text-center"><?php echo e(number_format($customer->booking_frequency_days ?? 0, 1)); ?> days</td>
                <td class="text-center">
                    <span class="<?php echo e($segmentClass); ?>"><?php echo e($segment); ?></span>
                </td>
                <td><?php echo e($customer->last_booking_date ?? 'Never'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 30px; font-size: 10px; color: #666;">
        <p><strong>Customer Segments:</strong></p>
        <ul>
            <li><span class="segment-vip">VIP</span>: Lifetime Value ≥ Rp 10,000,000</li>
            <li><span class="segment-premium">Premium</span>: Lifetime Value Rp 5,000,000 - 9,999,999</li>
            <li><span class="segment-regular">Regular</span>: Lifetime Value Rp 2,000,000 - 4,999,999</li>
            <li><span class="segment-basic">Basic</span>: Lifetime Value < Rp 2,000,000</li>
        </ul>
        <p><strong>Notes:</strong></p>
        <ul>
            <li>Lifetime Value = Total revenue generated by customer across all bookings</li>
            <li>Booking Frequency = Average days between bookings</li>
            <li>Focus retention efforts on VIP and Premium segments</li>
        </ul>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\reports\pdf\customer-ltv.blade.php ENDPATH**/ ?>