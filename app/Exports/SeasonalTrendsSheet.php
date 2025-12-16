<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SeasonalTrendsSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['seasonal_trends']);
    }

    public function headings(): array
    {
        return [
            'Period',
            'Bookings Count',
            'Revenue',
            'Average Booking Value',
            'Utilization Rate %',
            'Growth Rate %',
        ];
    }

    public function map($trend): array
    {
        return [
            $trend['period'] ?? 'N/A',
            number_format($trend['bookings_count'] ?? 0),
            'Rp ' . number_format($trend['revenue'] ?? 0, 0, ',', '.'),
            'Rp ' . number_format($trend['average_booking_value'] ?? 0, 0, ',', '.'),
            number_format($trend['utilization_rate'] ?? 0, 2),
            number_format($trend['growth_rate'] ?? 0, 2),
        ];
    }

    public function title(): string
    {
        return 'Seasonal Trends';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}