<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AnalyticsReportExport implements WithMultipleSheets
{
    protected $reportData;

    public function __construct($reportData)
    {
        $this->reportData = $reportData;
    }

    public function sheets(): array
    {
        return [
            new AnalyticsSummarySheet($this->reportData),
            new ProfitabilityAnalysisSheet($this->reportData),
            new CustomerLTVSheet($this->reportData),
            new SeasonalTrendsSheet($this->reportData),
        ];
    }
}