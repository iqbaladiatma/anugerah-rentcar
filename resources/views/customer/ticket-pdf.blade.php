<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - {{ $booking->booking_number }}</title>
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
            display: table;
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
        <div class="ticket-title">Electronic Ticket</div>
        <div class="booking-number">Booking #{{ $booking->booking_number }}</div>
    </div>

    <div class="content">
        <!-- Customer Information -->
        <div class="section">
            <div class="section-title">Customer Information</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Name:</div>
                    <div class="info-value">{{ $booking->customer->name }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Phone:</div>
                    <div class="info-value">{{ $booking->customer->phone }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $booking->customer->email ?? 'Not provided' }}</div>
                </div>
                @if($booking->customer->is_member)
                <div class="info-row">
                    <div class="info-label">Member Status:</div>
                    <div class="info-value">Premium Member ({{ $booking->customer->getMemberDiscountPercentage() }}% discount)</div>
                </div>
                @endif
            </div>
        </div>

        <!-- Vehicle Information -->
        <div class="section">
            <div class="section-title">Vehicle Information</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Vehicle:</div>
                    <div class="info-value">{{ $booking->car->brand }} {{ $booking->car->model }} ({{ $booking->car->year }})</div>
                </div>
                <div class="info-row">
                    <div class="info-label">License Plate:</div>
                    <div class="info-value">{{ $booking->car->license_plate }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Color:</div>
                    <div class="info-value">{{ $booking->car->color }}</div>
                </div>
            </div>
        </div>

        <!-- Rental Details -->
        <div class="section">
            <div class="section-title">Rental Details</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Start Date:</div>
                    <div class="info-value">{{ $booking->start_date->format('l, F d, Y - H:i') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">End Date:</div>
                    <div class="info-value">{{ $booking->end_date->format('l, F d, Y - H:i') }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Duration:</div>
                    <div class="info-value">{{ $booking->getDurationInDays() }} day(s)</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Pickup Location:</div>
                    <div class="info-value">{{ $booking->pickup_location }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Return Location:</div>
                    <div class="info-value">{{ $booking->return_location }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Driver Service:</div>
                    <div class="info-value">{{ $booking->with_driver ? 'Yes' : 'No' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Out of Town:</div>
                    <div class="info-value">{{ $booking->is_out_of_town ? 'Yes' : 'No' }}</div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status:</div>
                    <div class="info-value">
                        <span class="status-badge status-{{ $booking->booking_status }}">
                            {{ ucfirst($booking->booking_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pricing Breakdown -->
        <div class="section">
            <div class="section-title">Pricing Breakdown</div>
            <table class="pricing-table">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th style="text-align: right;">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Base Rental ({{ $booking->getDurationInDays() }} day(s) × Rp {{ number_format($booking->car->daily_rate, 0, ',', '.') }})</td>
                        <td style="text-align: right;">Rp {{ number_format($booking->base_amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($booking->driver_fee > 0)
                    <tr>
                        <td>Driver Service ({{ $booking->getDurationInDays() }} day(s) × Rp {{ number_format($booking->car->driver_fee_per_day, 0, ',', '.') }})</td>
                        <td style="text-align: right;">Rp {{ number_format($booking->driver_fee, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($booking->out_of_town_fee > 0)
                    <tr>
                        <td>Out of Town Fee</td>
                        <td style="text-align: right;">Rp {{ number_format($booking->out_of_town_fee, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($booking->member_discount > 0)
                    <tr style="color: #16a34a;">
                        <td>Member Discount ({{ $booking->customer->getMemberDiscountPercentage() }}%)</td>
                        <td style="text-align: right;">-Rp {{ number_format($booking->member_discount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    @if($booking->late_penalty > 0)
                    <tr style="color: #dc2626;">
                        <td>Late Return Penalty</td>
                        <td style="text-align: right;">Rp {{ number_format($booking->late_penalty, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                    <tr class="total-row">
                        <td>Total Amount</td>
                        <td style="text-align: right;">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</td>
                    </tr>
                    @if($booking->deposit_amount > 0)
                    <tr>
                        <td>Security Deposit</td>
                        <td style="text-align: right;">Rp {{ number_format($booking->deposit_amount, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>

        @if($booking->notes)
        <!-- Notes -->
        <div class="section">
            <div class="section-title">Additional Notes</div>
            <p>{{ $booking->notes }}</p>
        </div>
        @endif
    </div>

    <!-- QR Code Section (Placeholder) -->
    <div class="qr-section">
        <div style="font-weight: bold; margin-bottom: 10px;">Booking Verification</div>
        <div style="width: 100px; height: 100px; border: 2px dashed #ccc; margin: 0 auto; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #666;">
            QR Code<br>{{ $booking->booking_number }}
        </div>
        <div style="margin-top: 10px; font-size: 12px; color: #666;">
            Show this ticket during vehicle pickup
        </div>
    </div>

    <!-- Important Notes -->
    <div class="important-notes">
        <h4>Important Information:</h4>
        <ul>
            <li>Please bring your original KTP and valid driving license (SIM) during pickup</li>
            <li>Vehicle inspection will be conducted before and after rental period</li>
            <li>Late returns are subject to penalty charges as specified in the pricing breakdown</li>
            <li>Contact our customer service at +62 123 456 7890 for any assistance</li>
            <li>This e-ticket is valid only for the specified booking period and vehicle</li>
            @if($booking->with_driver)
            <li>Driver service is included - our professional driver will be assigned to your booking</li>
            @endif
            @if($booking->is_out_of_town)
            <li>Out of town trip approved - additional terms and conditions may apply</li>
            @endif
        </ul>
    </div>

    <div class="footer">
        <p><strong>Anugerah Rent Car</strong></p>
        <p>Jl. Raya Utama No. 123, Jakarta Selatan 12345</p>
        <p>Phone: +62 123 456 7890 | Email: info@anugerahrentcar.com</p>
        <p style="margin-top: 15px;">Generated on {{ now()->format('F d, Y H:i:s') }}</p>
        <p>Booking ID: {{ $booking->booking_number }} | Customer: {{ $booking->customer->name }}</p>
    </div>
</body>
</html>