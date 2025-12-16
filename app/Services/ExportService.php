<?php

namespace App\Services;

use App\Exports\CustomerReportExport;
use App\Exports\FinancialReportExport;
use App\Exports\VehicleReportExport;
use App\Exports\AnalyticsReportExport;
use App\Exports\ProfitabilityReportExport;
use App\Exports\CustomerLTVReportExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ExportService
{
    /**
     * Export customer report in specified format.
     */
    public function exportCustomerReport($reportData, $format = 'excel', $email = null)
    {
        $filename = $this->generateFilename('customer-report', $reportData['period'], $format);
        
        if ($format === 'excel') {
            return $this->exportToExcel(new CustomerReportExport($reportData), $filename, $email);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf('admin.reports.pdf.customer', $reportData, $filename, $email);
        }
        
        throw new \InvalidArgumentException('Unsupported export format: ' . $format);
    }

    /**
     * Export financial report in specified format.
     */
    public function exportFinancialReport($reportData, $format = 'excel', $email = null)
    {
        $filename = $this->generateFilename('financial-report', $reportData['period'], $format);
        
        if ($format === 'excel') {
            return $this->exportToExcel(new FinancialReportExport($reportData), $filename, $email);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf('admin.reports.pdf.financial', $reportData, $filename, $email);
        }
        
        throw new \InvalidArgumentException('Unsupported export format: ' . $format);
    }

    /**
     * Export vehicle report in specified format.
     */
    public function exportVehicleReport($reportData, $format = 'excel', $email = null)
    {
        $filename = $this->generateFilename('vehicle-report', $reportData['period'], $format);
        
        if ($format === 'excel') {
            return $this->exportToExcel(new VehicleReportExport($reportData), $filename, $email);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf('admin.reports.pdf.vehicle', $reportData, $filename, $email);
        }
        
        throw new \InvalidArgumentException('Unsupported export format: ' . $format);
    }

    /**
     * Export analytics report in specified format.
     */
    public function exportAnalyticsReport($reportData, $format = 'excel', $email = null)
    {
        $filename = $this->generateFilename('analytics-report', $reportData['period'], $format);
        
        if ($format === 'excel') {
            return $this->exportToExcel(new AnalyticsReportExport($reportData), $filename, $email);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf('admin.reports.pdf.analytics', $reportData, $filename, $email);
        }
        
        throw new \InvalidArgumentException('Unsupported export format: ' . $format);
    }    
/**
     * Export profitability report in specified format.
     */
    public function exportProfitabilityReport($reportData, $format = 'excel', $email = null)
    {
        $filename = $this->generateFilename('profitability-report', $reportData['period'], $format);
        
        if ($format === 'excel') {
            return $this->exportToExcel(new ProfitabilityReportExport($reportData), $filename, $email);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf('admin.reports.pdf.profitability', $reportData, $filename, $email);
        }
        
        throw new \InvalidArgumentException('Unsupported export format: ' . $format);
    }

    /**
     * Export customer LTV report in specified format.
     */
    public function exportCustomerLTVReport($reportData, $format = 'excel', $email = null)
    {
        $filename = $this->generateFilename('customer-ltv-report', [], $format);
        
        if ($format === 'excel') {
            return $this->exportToExcel(new CustomerLTVReportExport($reportData), $filename, $email);
        } elseif ($format === 'pdf') {
            return $this->exportToPdf('admin.reports.pdf.customer-ltv', $reportData, $filename, $email);
        }
        
        throw new \InvalidArgumentException('Unsupported export format: ' . $format);
    }

    /**
     * Batch export multiple reports.
     */
    public function batchExport($reports, $email = null)
    {
        $exportedFiles = [];
        
        foreach ($reports as $reportConfig) {
            try {
                $method = 'export' . ucfirst($reportConfig['type']) . 'Report';
                
                if (method_exists($this, $method)) {
                    $result = $this->$method(
                        $reportConfig['data'],
                        $reportConfig['format'] ?? 'excel',
                        null // Don't email individual files in batch
                    );
                    
                    $exportedFiles[] = [
                        'type' => $reportConfig['type'],
                        'format' => $reportConfig['format'] ?? 'excel',
                        'filename' => $result['filename'],
                        'path' => $result['path'],
                        'size' => $result['size'],
                    ];
                }
            } catch (\Exception $e) {
                \Log::error('Batch export failed for report: ' . $reportConfig['type'], [
                    'error' => $e->getMessage(),
                    'config' => $reportConfig
                ]);
            }
        }
        
        if ($email && !empty($exportedFiles)) {
            $this->emailBatchExports($exportedFiles, $email);
        }
        
        return $exportedFiles;
    }

    /**
     * Schedule export for later processing.
     */
    public function scheduleExport($reportType, $reportData, $format, $email, $scheduledAt = null)
    {
        $scheduledAt = $scheduledAt ? Carbon::parse($scheduledAt) : Carbon::now()->addMinutes(5);
        
        // In a real implementation, this would dispatch a job to a queue
        // For now, we'll just log the scheduled export
        \Log::info('Export scheduled', [
            'report_type' => $reportType,
            'format' => $format,
            'email' => $email,
            'scheduled_at' => $scheduledAt->toDateTimeString(),
        ]);
        
        return [
            'scheduled' => true,
            'scheduled_at' => $scheduledAt->toDateTimeString(),
            'report_type' => $reportType,
            'format' => $format,
        ];
    }    /**

     * Export data to Excel format.
     */
    private function exportToExcel($exportClass, $filename, $email = null)
    {
        $path = 'exports/' . $filename;
        
        // Store the file
        Excel::store($exportClass, $path, 'local');
        
        $fullPath = Storage::path($path);
        $fileSize = Storage::size($path);
        
        $result = [
            'filename' => $filename,
            'path' => $path,
            'full_path' => $fullPath,
            'size' => $fileSize,
            'format' => 'excel',
        ];
        
        if ($email) {
            $this->emailExport($result, $email);
        }
        
        return $result;
    }

    /**
     * Export data to PDF format.
     */
    private function exportToPdf($view, $reportData, $filename, $email = null)
    {
        $pdf = Pdf::loadView($view, compact('reportData'));
        $path = 'exports/' . $filename;
        
        // Store the PDF file
        Storage::put($path, $pdf->output());
        
        $fullPath = Storage::path($path);
        $fileSize = Storage::size($path);
        
        $result = [
            'filename' => $filename,
            'path' => $path,
            'full_path' => $fullPath,
            'size' => $fileSize,
            'format' => 'pdf',
        ];
        
        if ($email) {
            $this->emailExport($result, $email);
        }
        
        return $result;
    }

    /**
     * Generate filename for export.
     */
    private function generateFilename($reportType, $period = [], $format = 'excel')
    {
        $timestamp = Carbon::now()->format('Y-m-d-H-i-s');
        $extension = $format === 'excel' ? 'xlsx' : 'pdf';
        
        $filename = $reportType . '-' . $timestamp;
        
        if (!empty($period) && isset($period['start_date']) && isset($period['end_date'])) {
            $filename .= '-' . $period['start_date'] . '-to-' . $period['end_date'];
        }
        
        return $filename . '.' . $extension;
    }

    /**
     * Email single export file.
     */
    private function emailExport($fileInfo, $email)
    {
        try {
            // In a real implementation, you would create a proper mail class
            // For now, we'll just log the email action
            \Log::info('Export file emailed', [
                'email' => $email,
                'filename' => $fileInfo['filename'],
                'size' => $fileInfo['size'],
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to email export', [
                'error' => $e->getMessage(),
                'email' => $email,
                'file' => $fileInfo['filename'],
            ]);
            
            return false;
        }
    }   
 /**
     * Email batch export files.
     */
    private function emailBatchExports($exportedFiles, $email)
    {
        try {
            // In a real implementation, you would create a proper mail class
            // For now, we'll just log the batch email action
            \Log::info('Batch export files emailed', [
                'email' => $email,
                'files_count' => count($exportedFiles),
                'total_size' => array_sum(array_column($exportedFiles, 'size')),
                'files' => array_column($exportedFiles, 'filename'),
            ]);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to email batch exports', [
                'error' => $e->getMessage(),
                'email' => $email,
                'files_count' => count($exportedFiles),
            ]);
            
            return false;
        }
    }

    /**
     * Get export history.
     */
    public function getExportHistory($limit = 50)
    {
        $exportPath = Storage::path('exports');
        
        if (!is_dir($exportPath)) {
            return collect();
        }
        
        $files = collect(scandir($exportPath))
            ->filter(function ($file) {
                return !in_array($file, ['.', '..']) && is_file(Storage::path('exports/' . $file));
            })
            ->map(function ($file) {
                $path = 'exports/' . $file;
                $fullPath = Storage::path($path);
                
                return [
                    'filename' => $file,
                    'path' => $path,
                    'size' => Storage::size($path),
                    'created_at' => Carbon::createFromTimestamp(filemtime($fullPath)),
                    'format' => pathinfo($file, PATHINFO_EXTENSION),
                ];
            })
            ->sortByDesc('created_at')
            ->take($limit);
        
        return $files;
    }

    /**
     * Clean up old export files.
     */
    public function cleanupOldExports($daysOld = 30)
    {
        $cutoffDate = Carbon::now()->subDays($daysOld);
        $exportPath = Storage::path('exports');
        
        if (!is_dir($exportPath)) {
            return 0;
        }
        
        $deletedCount = 0;
        $files = scandir($exportPath);
        
        foreach ($files as $file) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }
            
            $fullPath = $exportPath . '/' . $file;
            
            if (is_file($fullPath)) {
                $fileDate = Carbon::createFromTimestamp(filemtime($fullPath));
                
                if ($fileDate->lt($cutoffDate)) {
                    if (unlink($fullPath)) {
                        $deletedCount++;
                    }
                }
            }
        }
        
        \Log::info('Export cleanup completed', [
            'deleted_files' => $deletedCount,
            'cutoff_date' => $cutoffDate->toDateString(),
        ]);
        
        return $deletedCount;
    }
}