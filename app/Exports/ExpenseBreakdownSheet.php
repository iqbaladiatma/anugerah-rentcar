<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExpenseBreakdownSheet implements FromCollection, WithHeadings, WithMapping, WithTitle, WithStyles
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function collection()
    {
        return collect($this->reportData['expenses']['by_category'])->map(function($data, $category) {
            return [$category, $data];
        });
    }

    public function headings(): array
    {
        return [
            'Category',
            'Amount',
            'Count',
        ];
    }

    public function map($categoryData): array
    {
        $category = $categoryData[0];
        $data = $categoryData[1];
        
        return [
            ucfirst($category),
            'Rp ' . number_format($data['amount'], 0, ',', '.'),
            $data['count'],
        ];
    }

    public function title(): string
    {
        return 'Expense Breakdown';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}