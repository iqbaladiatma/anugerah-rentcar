<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class VehicleReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
            'Total Bookings',
            'Completed Bookings',
            'Total Booked Days',
            'Utilization Rate (%)',
            'Total Revenue',
            'Maintenance Costs',
            'Net Revenue',
            'Revenue per Day',
            'Average Booking Value',
            'Maintenance Frequency',
        ];
    }

    public function map($vehicle): array
    {
        return [
            $vehicle['vehicle']->license_plate,
            $vehicle['vehicle']->brand . ' ' . $vehicle['vehicle']->model,
            $vehicle['vehicle']->year,
            $vehicle['total_bookings'],
            $vehicle['completed_bookings'],
            $vehicle['total_booked_days'],
            number_format($vehicle['utilization_rate'], 2),
            'Rp ' . number_format($vehicle['total_revenue'], 0, ',', '.'),
            'Rp ' . number_format($vehicle['maintenance_costs'], 0, ',', '.'),
            'Rp ' . number_format($vehicle['net_revenue'], 0, ',', '.'),
            'Rp ' . number_format($vehicle['revenue_per_day'], 0, ',', '.'),
            'Rp ' . number_format($vehicle['average_booking_value'], 0, ',', '.'),
            $vehicle['maintenance_frequency'],
        ];
    }

    public function title(): string
    {
        return 'Vehicle Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}