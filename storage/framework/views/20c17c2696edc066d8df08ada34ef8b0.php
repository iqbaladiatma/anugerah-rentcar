<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Report</title>
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
        .member-badge {
            background-color: #28a745;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
        .blacklist-badge {
            background-color: #dc3545;
            color: white;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Anugerah Rentcar</div>
        <div class="report-title">Customer Report</div>
        <div class="period">Period: <?php echo e($reportData['period']['start_date']); ?> to <?php echo e($reportData['period']['end_date']); ?></div>
    </div>

    <div class="summary-box">
        <div class="summary-title">Summary Statistics</div>
        <div class="summary-grid">
            <div class="summary-item">
                <span>Total Customers:</span>
                <span><?php echo e(number_format($reportData['summary']['total_customers'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Active Customers:</span>
                <span><?php echo e(number_format($reportData['summary']['active_customers'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Member Customers:</span>
                <span><?php echo e(number_format($reportData['summary']['member_customers'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Blacklisted Customers:</span>
                <span><?php echo e(number_format($reportData['summary']['blacklisted_customers'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Total Bookings:</span>
                <span><?php echo e(number_format($reportData['summary']['total_bookings'])); ?></span>
            </div>
            <div class="summary-item">
                <span>Total Revenue:</span>
                <span>Rp <?php echo e(number_format($reportData['summary']['total_revenue'], 0, ',', '.')); ?></span>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Status</th>
                <th class="text-center">Bookings</th>
                <th class="text-right">Revenue</th>
                <th class="text-right">Avg. Value</th>
                <th>Frequency</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reportData['customers']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $customerData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($customerData['customer']->name); ?></td>
                <td><?php echo e($customerData['customer']->phone); ?></td>
                <td>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customerData['customer']->is_member): ?>
                        <span class="member-badge">Member</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($customerData['customer']->is_blacklisted): ?>
                        <span class="blacklist-badge">Blacklisted</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="text-center"><?php echo e($customerData['total_bookings']); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($customerData['total_revenue'], 0, ',', '.')); ?></td>
                <td class="text-right">Rp <?php echo e(number_format($customerData['average_booking_value'], 0, ',', '.')); ?></td>
                <td><?php echo e($customerData['booking_frequency']); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views\admin\reports\pdf\customer.blade.php ENDPATH**/ ?>