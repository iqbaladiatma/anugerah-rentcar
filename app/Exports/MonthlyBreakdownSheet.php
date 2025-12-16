<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyBreakdownSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['monthly_breakdown']);
    }

    public function headings(): array
    {
        return [
            'Month',
            'Revenue',
            'Expenses',
            'Profit',
            'Bookings Count',
        ];
    }

    public function map($monthData): array
    {
        return [
            $monthData['month_name'],
            'Rp ' . number_format($monthData['revenue'], 0, ',', '.'),
            'Rp ' . number_format($monthData['expenses'], 0, ',', '.'),
            'Rp ' . number_format($monthData['profit'], 0, ',', '.'),
            $monthData['bookings_count'],
        ];
    }

    public function title(): string
    {
        return 'Monthly Breakdown';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}