<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfitabilityAnalysisSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['profitability']);
    }

    public function headings(): array
    {
        return [
            'License Plate',
            'Vehicle',
            'Revenue',
            'Maintenance Costs',
            'Net Profit',
            'Profit Margin %',
            'Utilization Rate %',
            'Revenue per Day',
        ];
    }

    public function map($vehicle): array
    {
        return [
            $vehicle->license_plate ?? 'N/A',
            ($vehicle->brand ?? '') . ' ' . ($vehicle->model ?? ''),
            'Rp ' . number_format($vehicle->revenue ?? 0, 0, ',', '.'),
            'Rp ' . number_format($vehicle->maintenance_costs ?? 0, 0, ',', '.'),
            'Rp ' . number_format($vehicle->net_profit ?? 0, 0, ',', '.'),
            number_format($vehicle->profit_margin ?? 0, 2),
            number_format($vehicle->utilization_rate ?? 0, 2),
            'Rp ' . number_format($vehicle->revenue_per_day ?? 0, 0, ',', '.'),
        ];
    }

    public function title(): string
    {
        return 'Profitability Analysis';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}