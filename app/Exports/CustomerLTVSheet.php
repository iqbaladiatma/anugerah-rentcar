<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerLTVSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['customer_ltv']);
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Phone',
            'Member Status',
            'Lifetime Value',
            'Total Bookings',
            'Average Booking Value',
            'Booking Frequency (days)',
            'First Booking',
            'Last Booking',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->name ?? 'N/A',
            $customer->phone ?? 'N/A',
            ($customer->is_member ?? false) ? 'Member' : 'Regular',
            'Rp ' . number_format($customer->lifetime_value ?? 0, 0, ',', '.'),
            number_format($customer->total_bookings ?? 0),
            'Rp ' . number_format($customer->average_booking_value ?? 0, 0, ',', '.'),
            number_format($customer->booking_frequency_days ?? 0, 1),
            $customer->first_booking_date ?? 'N/A',
            $customer->last_booking_date ?? 'N/A',
        ];
    }

    public function title(): string
    {
        return 'Customer LTV Analysis';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}