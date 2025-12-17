<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Tiket - <?php echo e($booking->booking_number); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.4;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        .ticket-title {
            font-size: 18px;
            color: #666;
            margin-bottom: 10px;
        }
        .booking-number {
            font-size: 16px;
            font-weight: bold;
            background: #f3f4f6;
            padding: 8px 16px;
            border-radius: 4px;
            display: inline-block;
        }
        .content {
            display: block;
            width: 100%;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 25px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-label {
            display: table-cell;
            width: 30%;
            padding: 8px 0;
            font-weight: bold;
            color: #666;
        }
        .info-value {
            display: table-cell;
            padding: 8px 0;
            color: #333;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-confirmed {
            background: #ddd6fe;
            color: #7c3aed;
        }
        .status-active {
            background: #dcfce7;
            color: #16a34a;
        }
        .pricing-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .pricing-table th,
        .pricing-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }
        .pricing-table th {
            background: #f9fafb;
            font-weight: bold;
            color: #374151;
        }
        .pricing-table .total-row {
            font-weight: bold;
            background: #f3f4f6;
        }
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
        .important-notes {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 4px;
            padding: 15px;
            margin: 20px 0;
        }
        .important-notes h4 {
            margin: 0 0 10px 0;
            color: #92400e;
            font-size: 14px;
        }
        .important-notes ul {
            margin: 0;
            padding-left: 20px;
            font-size: 12px;
            color: #92400e;
        }
        .qr-section {
            text-align: center;
            margin: 20px 0;
            padding: 15px;
            background: #f9fafb;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-name">Anugerah Rent Car</div>
        <div class="ticket-title">Tiket Elektronik</div>
        <div class="booking-number">Pemesanan #<?php echo e($booking->booking_number); ?></div>
    </div>

    <div class="content">
        <!-- Customer Information -->
        <div class="section">
            <div class="section-title">Informasi Pelanggan</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nama:</div>
                    <div class="info-value"><?php echo e($booking->customer->name); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Telepon:</div>
                    <div class="info-value"><?php echo e($booking->customer->phone); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value"><?php echo e($booking->customer->email ?? 'Tidak disediakan'); ?></div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->customer->is_member): ?>
                <div class="info-row">
                    <div class="info-label">Status Anggota:</div>
                    <div class="info-value">Anggota Premium (diskon <?php echo e($booking->customer->getMemberDiscountPercentage()); ?>%)</div>
                </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Vehicle Information -->
        <div class="section">
            <div class="section-title">Informasi Kendaraan</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Kendaraan:</div>
                    <div class="info-value"><?php echo e($booking->car->brand); ?> <?php echo e($booking->car->model); ?> (<?php echo e($booking->car->year); ?>)</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Plat Nomor:</div>
                    <div class="info-value"><?php echo e($booking->car->license_plate); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Warna:</div>
                    <div class="info-value"><?php echo e($booking->car->color); ?></div>
                </div>
            </div>
        </div>

        <!-- Rental Details -->
        <div class="section">
            <div class="section-title">Detail Sewa</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Tanggal Mulai:</div>
                    <div class="info-value"><?php echo e($booking->start_date->format('l, F d, Y - H:i')); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Tanggal Selesai:</div>
                    <div class="info-value"><?php echo e($booking->end_date->format('l, F d, Y - H:i')); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Durasi:</div>
                    <div class="info-value"><?php echo e($booking->getDurationInDays()); ?> hari</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Lokasi Penjemputan:</div>
                    <div class="info-value"><?php echo e($booking->pickup_location); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Lokasi Pengembalian:</div>
                    <div class="info-value"><?php echo e($booking->return_location); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Layanan Sopir:</div>
                    <div class="info-value"><?php echo e($booking->with_driver ? 'Ya' : 'Tidak'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Luar Kota:</div>
                    <div class="info-value"><?php echo e($booking->is_out_of_town ? 'Ya' : 'Tidak'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="status-badge status-<?php echo e($booking->booking_status); ?>">
                            <?php echo e(ucfirst($booking->booking_status)); ?>

                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Breakdown -->
        <div class="section">
            <div class="section-title">Rincian Harga</div>
            <table class="pricing-table">
                <thead>
                    <tr>
                        <th>Deskripsi</th>
                        <th style="text-align: right;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sewa Dasar (<?php echo e($booking->getDurationInDays()); ?> hari × Rp <?php echo e(number_format($booking->car->daily_rate, 0, ',', '.')); ?>)</td>
                        <td style="text-align: right;">Rp <?php echo e(number_format($booking->base_amount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->driver_fee > 0): ?>
                    <tr>
                        <td>Layanan Sopir (<?php echo e($booking->getDurationInDays()); ?> hari × Rp <?php echo e(number_format($booking->car->driver_fee_per_day, 0, ',', '.')); ?>)</td>
                        <td style="text-align: right;">Rp <?php echo e(number_format($booking->driver_fee, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->out_of_town_fee > 0): ?>
                    <tr>
                        <td>Biaya Luar Kota</td>
                        <td style="text-align: right;">Rp <?php echo e(number_format($booking->out_of_town_fee, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->member_discount > 0): ?>
                    <tr style="color: #16a34a;">
                        <td>Diskon Anggota (<?php echo e($booking->customer->getMemberDiscountPercentage()); ?>%)</td>
                        <td style="text-align: right;">-Rp <?php echo e(number_format($booking->member_discount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->late_penalty > 0): ?>
                    <tr style="color: #dc2626;">
                        <td>Denda Keterlambatan Pengembalian</td>
                        <td style="text-align: right;">Rp <?php echo e(number_format($booking->late_penalty, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <tr class="total-row">
                        <td>Total Jumlah</td>
                        <td style="text-align: right;">Rp <?php echo e(number_format($booking->total_amount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->deposit_amount > 0): ?>
                    <tr>
                        <td>Deposit Keamanan</td>
                        <td style="text-align: right;">Rp <?php echo e(number_format($booking->deposit_amount, 0, ',', '.')); ?></td>
                    </tr>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->notes): ?>
        <!-- Notes -->
        <div class="section">
            <div class="section-title">Catatan Tambahan</div>
            <p><?php echo e($booking->notes); ?></p>
        </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    <!-- QR Code Section (Placeholder) -->
    <div class="qr-section">
        <div style="font-weight: bold; margin-bottom: 10px;">Verifikasi Pemesanan</div>
        <div style="width: 100px; height: 100px; border: 2px dashed #ccc; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #666;">
            Kode QR<br><?php echo e($booking->booking_number); ?>

        </div>
        <div style="margin-top: 10px; font-size: 12px; color: #666;">
            Tunjukkan tiket ini saat pengambilan kendaraan
        </div>
    </div>

    <!-- Important Notes -->
    <div class="important-notes">
        <h4>Informasi Penting:</h4>
        <ul>
            <li>Harap bawa KTP asli dan SIM yang sah saat pengambilan</li>
            <li>Pemeriksaan kendaraan akan dilakukan sebelum dan sesudah masa sewa</li>
            <li>Pengembalian terlambat dikenakan biaya denda sebagaimana tercantum dalam rincian harga</li>
            <li>Hubungi layanan pelanggan kami di +62 123 456 7890 untuk bantuan apa pun</li>
            <li>E-tiket ini hanya berlaku untuk periode pemesanan dan kendaraan yang ditentukan</li>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->with_driver): ?>
            <li>Layanan sopir sudah termasuk - sopir profesional kami akan ditugaskan untuk pemesanan Anda</li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($booking->is_out_of_town): ?>
            <li>Perjalanan luar kota disetujui - syarat dan ketentuan tambahan mungkin berlaku</li>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </ul>
    </div>

    <div class="footer">
        <p><strong>Anugerah Rent Car</strong></p>
        <p>Jl. Raya Utama No. 123, Jakarta Selatan 12345</p>
        <p>Telepon: +62 123 456 7890 | Email: info@anugerahrentcar.com</p>
        <p style="margin-top: 15px;">Dibuat pada <?php echo e(now()->format('F d, Y H:i:s')); ?></p>
        <p>ID Pemesanan: <?php echo e($booking->booking_number); ?> | Pelanggan: <?php echo e($booking->customer->name); ?></p>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\anugerah-rentcar\resources\views/customer/ticket-pdf.blade.php ENDPATH**/ ?>