<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanupQuarantinedFiles extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'files:cleanup-quarantine 
                            {--days=30 : Number of days to retain quarantined files}
                            {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up old quarantined files to free up storage space';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $retentionDays = (int) $this->option('days');
        $dryRun = $this->option('dry-run');
        
        $this->info("Cleaning up quarantined files older than {$retentionDays} days...");
        
        $quarantinePath = storage_path('app/quarantine');
        
        if (!is_dir($quarantinePath)) {
            $this->info('No quarantine directory found.');
            return self::SUCCESS;
        }
        
        $cutoffDate = Carbon::now()->subDays($retentionDays);
        $files = glob($quarantinePath . '/*');
        $deletedCount = 0;
        $totalSize = 0;
        
        foreach ($files as $file) {
            if (!is_file($file)) {
                continue;
            }
            
            $fileTime = Carbon::createFromTimestamp(filemtime($file));
            
            if ($fileTime->lt($cutoffDate)) {
                $fileSize = filesize($file);
                $totalSize += $fileSize;
                
                if ($dryRun) {
                    $this->line("Would delete: " . basename($file) . " (" . $this->formatBytes($fileSize) . ")");
                } else {
                    if (unlink($file)) {
                        $this->line("Deleted: " . basename($file) . " (" . $this->formatBytes($fileSize) . ")");
                        $deletedCount++;
                    } else {
                        $this->error("Failed to delete: " . basename($file));
                    }
                }
            }
        }
        
        if ($dryRun) {
            $this->info("Dry run completed. Would delete {$deletedCount} files totaling " . $this->formatBytes($totalSize));
        } else {
            $this->info("Cleanup completed. Deleted {$deletedCount} files totaling " . $this->formatBytes($totalSize));
            
            Log::info('Quarantine cleanup completed', [
                'deleted_files' => $deletedCount,
                'total_size_freed' => $totalSize,
                'retention_days' => $retentionDays
            ]);
        }
        
        return self::SUCCESS;
    }
    
    /**
     * Format bytes to human readable format
     */
    protected function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        
        $bytes /= (1 << (10 * $pow));
        
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}