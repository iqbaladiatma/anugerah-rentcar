<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProfitabilityReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['vehicles']);
    }

    public function headings(): array
    {
        return [
            'License Plate',
            'Brand & Model',
            'Year',
            'Revenue',
            'Maintenance Costs',
            'Net Profit',
            'Profit Margin %',
            'Utilization Rate %',
            'Revenue per Day',
            'Bookings Count',
            'Performance Rating',
        ];
    }

    public function map($vehicle): array
    {
        $profitMargin = $vehicle->profit_margin ?? 0;
        $performance = $profitMargin >= 30 ? 'Excellent' : 
                      ($profitMargin >= 15 ? 'Good' : 
                      ($profitMargin >= 5 ? 'Average' : 'Poor'));

        return [
            $vehicle->license_plate ?? 'N/A',
            ($vehicle->brand ?? '') . ' ' . ($vehicle->model ?? ''),
            $vehicle->year ?? 'N/A',
            'Rp ' . number_format($vehicle->revenue ?? 0, 0, ',', '.'),
            'Rp ' . number_format($vehicle->maintenance_costs ?? 0, 0, ',', '.'),
            'Rp ' . number_format($vehicle->net_profit ?? 0, 0, ',', '.'),
            number_format($profitMargin, 2),
            number_format($vehicle->utilization_rate ?? 0, 2),
            'Rp ' . number_format($vehicle->revenue_per_day ?? 0, 0, ',', '.'),
            number_format($vehicle->bookings_count ?? 0),
            $performance,
        ];
    }

    public function title(): string
    {
        return 'Vehicle Profitability Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}