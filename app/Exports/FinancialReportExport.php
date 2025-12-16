<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FinancialReportExport implements WithMultipleSheets
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function sheets(): array
    {
        return [
            new FinancialSummarySheet($this->reportData),
            new MonthlyBreakdownSheet($this->reportData),
            new ExpenseBreakdownSheet($this->reportData),
        ];
    }
}