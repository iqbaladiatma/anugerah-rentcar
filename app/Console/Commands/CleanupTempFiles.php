<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CleanupTempFiles extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'files:cleanup-temp 
                            {--hours=24 : Number of hours after which temp files are deleted}
                            {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up temporary uploaded files older than specified hours';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $dryRun = $this->option('dry-run');
        $cutoffTime = Carbon::now()->subHours($hours);

        $this->info("Cleaning up temporary files older than {$hours} hours...");
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No files will be deleted');
        }

        $deletedCount = 0;
        $totalSize = 0;

        // Clean up Livewire temporary files
        $deletedCount += $this->cleanupLivewireTemp($cutoffTime, $dryRun, $totalSize);

        // Clean up failed upload files
        $deletedCount += $this->cleanupFailedUploads($cutoffTime, $dryRun, $totalSize);

        // Clean up orphaned thumbnails
        $deletedCount += $this->cleanupOrphanedThumbnails($dryRun, $totalSize);

        if ($deletedCount > 0) {
            $sizeFormatted = $this->formatBytes($totalSize);
            $this->info("Cleanup completed: {$deletedCount} files deleted, {$sizeFormatted} freed");
            
            Log::info('Temporary file cleanup completed', [
                'files_deleted' => $deletedCount,
                'size_freed' => $totalSize,
                'cutoff_time' => $cutoffTime,
                'dry_run' => $dryRun
            ]);
        } else {
            $this->info('No temporary files found to clean up');
        }

        return Command::SUCCESS;
    }

    /**
     * Clean up Livewire temporary files
     */
    protected function cleanupLivewireTemp(Carbon $cutoffTime, bool $dryRun, int &$totalSize): int
    {
        $deletedCount = 0;
        $tempPath = storage_path('app/livewire-tmp');

        if (!is_dir($tempPath)) {
            return 0;
        }

        $files = glob($tempPath . '/*');
        
        foreach ($files as $file) {
            if (is_file($file)) {
                $fileTime = Carbon::createFromTimestamp(filemtime($file));
                
                if ($fileTime->lt($cutoffTime)) {
                    $size = filesize($file);
                    
                    if ($dryRun) {
                        $this->line("Would delete: " . basename($file) . " ({$this->formatBytes($size)})");
                    } else {
                        if (unlink($file)) {
                            $totalSize += $size;
                            $deletedCount++;
                        }
                    }
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Clean up failed upload files
     */
    protected function cleanupFailedUploads(Carbon $cutoffTime, bool $dryRun, int &$totalSize): int
    {
        $deletedCount = 0;
        $disks = ['public', 'local'];

        foreach ($disks as $diskName) {
            $disk = Storage::disk($diskName);
            
            // Look for temp files in various directories
            $tempDirectories = ['temp', 'uploads/temp', 'failed-uploads'];
            
            foreach ($tempDirectories as $directory) {
                if ($disk->exists($directory)) {
                    $files = $disk->allFiles($directory);
                    
                    foreach ($files as $file) {
                        $lastModified = Carbon::createFromTimestamp($disk->lastModified($file));
                        
                        if ($lastModified->lt($cutoffTime)) {
                            $size = $disk->size($file);
                            
                            if ($dryRun) {
                                $this->line("Would delete: {$file} ({$this->formatBytes($size)})");
                            } else {
                                if ($disk->delete($file)) {
                                    $totalSize += $size;
                                    $deletedCount++;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Clean up orphaned thumbnails
     */
    protected function cleanupOrphanedThumbnails(bool $dryRun, int &$totalSize): int
    {
        $deletedCount = 0;
        $disk = Storage::disk('public');
        
        // Find all thumbnail files
        $allFiles = $disk->allFiles();
        $thumbnails = array_filter($allFiles, function ($file) {
            return strpos(basename($file), 'thumb_') === 0;
        });

        foreach ($thumbnails as $thumbnail) {
            // Check if original file exists
            $originalFile = str_replace('thumb_', '', $thumbnail);
            
            if (!$disk->exists($originalFile)) {
                $size = $disk->size($thumbnail);
                
                if ($dryRun) {
                    $this->line("Would delete orphaned thumbnail: {$thumbnail} ({$this->formatBytes($size)})");
                } else {
                    if ($disk->delete($thumbnail)) {
                        $totalSize += $size;
                        $deletedCount++;
                    }
                }
            }
        }

        return $deletedCount;
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