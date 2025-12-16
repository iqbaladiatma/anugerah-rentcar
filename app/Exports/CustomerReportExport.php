<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CustomerReportExport implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
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
            'Blacklisted',
            'Total Bookings',
            'Completed Bookings',
            'Total Revenue',
            'Total Discount Given',
            'Average Booking Value',
            'Last Booking Date',
            'Booking Frequency',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer['customer']->name,
            $customer['customer']->phone,
            $customer['customer']->email ?? 'N/A',
            $customer['customer']->is_member ? 'Member' : 'Regular',
            $customer['customer']->is_blacklisted ? 'Yes' : 'No',
            $customer['total_bookings'],
            $customer['completed_bookings'],
            'Rp ' . number_format($customer['total_revenue'], 0, ',', '.'),
            'Rp ' . number_format($customer['total_discount_given'], 0, ',', '.'),
            'Rp ' . number_format($customer['average_booking_value'], 0, ',', '.'),
            $customer['last_booking_date'] ? \Carbon\Carbon::parse($customer['last_booking_date'])->format('d/m/Y') : 'Never',
            $customer['booking_frequency'],
        ];
    }

    public function title(): string
    {
        return 'Customer Report';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}