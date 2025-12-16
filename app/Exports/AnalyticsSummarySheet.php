<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AnalyticsSummarySheet implements FromArray, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        $analytics = $this->reportData['analytics'];

        return [
            ['ANALYTICS DASHBOARD REPORT'],
            ['Period: ' . $this->reportData['period']['start_date'] . ' to ' . $this->reportData['period']['end_date']],
            [],
            ['KEY PERFORMANCE INDICATORS'],
            ['Total Revenue', 'Rp ' . number_format($analytics['total_revenue'] ?? 0, 0, ',', '.')],
            ['Total Bookings', number_format($analytics['total_bookings'] ?? 0)],
            ['Active Vehicles', number_format($analytics['active_vehicles'] ?? 0)],
            ['Active Customers', number_format($analytics['active_customers'] ?? 0)],
            ['Average Booking Value', 'Rp ' . number_format($analytics['average_booking_value'] ?? 0, 0, ',', '.')],
            ['Fleet Utilization Rate', number_format($analytics['fleet_utilization_rate'] ?? 0, 2) . '%'],
            ['Customer Retention Rate', number_format($analytics['customer_retention_rate'] ?? 0, 2) . '%'],
            ['Revenue Growth Rate', number_format($analytics['revenue_growth_rate'] ?? 0, 2) . '%'],
            [],
            ['OPERATIONAL METRICS'],
            ['Completed Bookings', number_format($analytics['completed_bookings'] ?? 0)],
            ['Cancelled Bookings', number_format($analytics['cancelled_bookings'] ?? 0)],
            ['Pending Bookings', number_format($analytics['pending_bookings'] ?? 0)],
            ['Average Booking Duration', number_format($analytics['average_booking_duration'] ?? 0, 1) . ' days'],
            ['Late Returns', number_format($analytics['late_returns'] ?? 0)],
            ['Late Fee Revenue', 'Rp ' . number_format($analytics['late_fee_revenue'] ?? 0, 0, ',', '.')],
            [],
            ['CUSTOMER METRICS'],
            ['New Customers', number_format($analytics['new_customers'] ?? 0)],
            ['Member Customers', number_format($analytics['member_customers'] ?? 0)],
            ['Member Conversion Rate', number_format($analytics['member_conversion_rate'] ?? 0, 2) . '%'],
            ['Average Customer LTV', 'Rp ' . number_format($analytics['average_customer_ltv'] ?? 0, 0, ',', '.')],
            [],
            ['FINANCIAL METRICS'],
            ['Gross Profit Margin', number_format($analytics['gross_profit_margin'] ?? 0, 2) . '%'],
            ['Operating Expense Ratio', number_format($analytics['operating_expense_ratio'] ?? 0, 2) . '%'],
            ['Maintenance Cost Ratio', number_format($analytics['maintenance_cost_ratio'] ?? 0, 2) . '%'],
            ['Revenue per Vehicle', 'Rp ' . number_format($analytics['revenue_per_vehicle'] ?? 0, 0, ',', '.')],
        ];
    }

    public function title(): string
    {
        return 'Analytics Summary';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
            14 => ['font' => ['bold' => true]],
            21 => ['font' => ['bold' => true]],
            26 => ['font' => ['bold' => true]],
        ];
    }
}