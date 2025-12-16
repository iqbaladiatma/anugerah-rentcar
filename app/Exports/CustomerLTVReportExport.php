<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerLTVReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['customers']);
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Phone',
            'Email',
            'Member Status',
            'Lifetime Value',
            'Total Bookings',
            'Average Booking Value',
            'Booking Frequency (days)',
            'Customer Segment',
            'First Booking Date',
            'Last Booking Date',
            'Days Since Last Booking',
        ];
    }

    public function map($customer): array
    {
        $ltv = $customer->lifetime_value ?? 0;
        $segment = $ltv >= 10000000 ? 'VIP' : 
                  ($ltv >= 5000000 ? 'Premium' : 
                  ($ltv >= 2000000 ? 'Regular' : 'Basic'));

        return [
            $customer->name ?? 'N/A',
            $customer->phone ?? 'N/A',
            $customer->email ?? 'N/A',
            ($customer->is_member ?? false) ? 'Member' : 'Regular',
            'Rp ' . number_format($ltv, 0, ',', '.'),
            number_format($customer->total_bookings ?? 0),
            'Rp ' . number_format($customer->average_booking_value ?? 0, 0, ',', '.'),
            number_format($customer->booking_frequency_days ?? 0, 1),
            $segment,
            $customer->first_booking_date ?? 'N/A',
            $customer->last_booking_date ?? 'N/A',
            number_format($customer->days_since_last_booking ?? 0),
        ];
    }

    public function title(): string
    {
        return 'Customer Lifetime Value Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}