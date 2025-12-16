<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FinancialSummarySheet implements FromArray, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function array(): array
    {
        $revenue = $this->reportData['revenue'];
        $expenses = $this->reportData['expenses'];
        $profitLoss = $this->reportData['profit_loss'];

        return [
            ['FINANCIAL SUMMARY REPORT'],
            ['Period: ' . $this->reportData['period']['start_date'] . ' to ' . $this->reportData['period']['end_date']],
            [],
            ['REVENUE BREAKDOWN'],
            ['Rental Income', 'Rp ' . number_format($revenue['rental_income'], 0, ',', '.')],
            ['Driver Fees', 'Rp ' . number_format($revenue['driver_fees'], 0, ',', '.')],
            ['Out of Town Fees', 'Rp ' . number_format($revenue['out_of_town_fees'], 0, ',', '.')],
            ['Late Penalties', 'Rp ' . number_format($revenue['late_penalties'], 0, ',', '.')],
            ['Member Discounts', 'Rp ' . number_format($revenue['member_discounts'], 0, ',', '.')],
            ['Total Gross Revenue', 'Rp ' . number_format($revenue['total_gross_revenue'], 0, ',', '.')],
            ['Total Net Revenue', 'Rp ' . number_format($revenue['total_net_revenue'], 0, ',', '.')],
            [],
            ['EXPENSE BREAKDOWN'],
            ['Operational Expenses', 'Rp ' . number_format($expenses['operational'], 0, ',', '.')],
            ['Maintenance Costs', 'Rp ' . number_format($expenses['maintenance'], 0, ',', '.')],
            ['Total Expenses', 'Rp ' . number_format($expenses['total'], 0, ',', '.')],
            [],
            ['PROFIT & LOSS'],
            ['Gross Profit', 'Rp ' . number_format($profitLoss['gross_profit'], 0, ',', '.')],
            ['Profit Margin', number_format($profitLoss['profit_margin'], 2) . '%'],
            ['Revenue per Booking', 'Rp ' . number_format($profitLoss['revenue_per_booking'], 0, ',', '.')],
        ];
    }

    public function title(): string
    {
        return 'Financial Summary';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            2 => ['font' => ['bold' => true]],
            4 => ['font' => ['bold' => true]],
            13 => ['font' => ['bold' => true]],
            18 => ['font' => ['bold' => true]],
        ];
    }
}