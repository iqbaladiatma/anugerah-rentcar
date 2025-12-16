<?php

namespace App\Jobs;

use App\Services\ExportService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class ProcessScheduledExport implements ShouldQueue
{
    use Queueable;

    public $reportType;
    public $reportData;
    public $format;
    public $email;

    /**
     * Create a new job instance.
     */
    public function __construct($reportType, $reportData, $format, $email)
    {
        $this->reportType = $reportType;
        $this->reportData = $reportData;
        $this->format = $format;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(ExportService $exportService): void
    {
        try {
            Log::info('Processing scheduled export', [
                'report_type' => $this->reportType,
                'format' => $this->format,
                'email' => $this->email,
            ]);

            $method = 'export' . ucfirst($this->reportType) . 'Report';
            
            if (method_exists($exportService, $method)) {
                $result = $exportService->$method($this->reportData, $this->format, $this->email);
                
                Log::info('Scheduled export completed successfully', [
                    'report_type' => $this->reportType,
                    'filename' => $result['filename'],
                    'email' => $this->email,
                ]);
            } else {
                throw new \Exception("Export method not found: {$method}");
            }
        } catch (\Exception $e) {
            Log::error('Scheduled export failed', [
                'report_type' => $this->reportType,
                'format' => $this->format,
                'email' => $this->email,
                'error' => $e->getMessage(),
            ]);
            
            throw $e;
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('Scheduled export job failed', [
            'report_type' => $this->reportType,
            'format' => $this->format,
            'email' => $this->email,
            'error' => $exception->getMessage(),
        ]);
    }
}
