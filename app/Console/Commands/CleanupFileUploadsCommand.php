<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupFileUploadsCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'file-upload:cleanup 
                            {--quarantine-days=30 : Days to keep quarantined files}
                            {--temp-hours=24 : Hours to keep temporary files}
                            {--dry-run : Show what would be deleted without actually deleting}';

    /**
     * The console command description.
     */
    protected $description = 'Clean up old quarantined files and temporary uploads';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $quarantineDays = (int) $this->option('quarantine-days');
        $tempHours = (int) $this->option('temp-hours');
        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->info('DRY RUN MODE - No files will be deleted');
        }

        $this->info('Starting file upload cleanup...');

        // Clean quarantined files
        $quarantineCount = $this->cleanQuarantinedFiles($quarantineDays, $dryRun);
        
        // Clean temporary files
        $tempCount = $this->cleanTemporaryFiles($tempHours, $dryRun);

        // Clean orphaned thumbnails
        $thumbnailCount = $this->cleanOrphanedThumbnails($dryRun);

        $this->info("Cleanup complete:");
        $this->line("- Quarantined files: {$quarantineCount}");
        $this->line("- Temporary files: {$tempCount}");
        $this->line("- Orphaned thumbnails: {$thumbnailCount}");

        return 0;
    }

    /**
     * Clean old quarantined files
     */
    protected function cleanQuarantinedFiles(int $days, bool $dryRun): int
    {
        $quarantineDir = storage_path('app/quarantine');
        
        if (!is_dir($quarantineDir)) {
            return 0;
        }

        $cutoffTime = Carbon::now()->subDays($days);
        $files = glob($quarantineDir . '/*');
        $deletedCount = 0;

        foreach ($files as $file) {
            if (is_file($file)) {
                $fileTime = Carbon::createFromTimestamp(filemtime($file));
                
                if ($fileTime->lt($cutoffTime)) {
                    if ($dryRun) {
                        $this->line("Would delete quarantined file: " . basename($file));
                        $deletedCount++;
                    } else {
                        if (unlink($file)) {
                            $this->line("Deleted quarantined file: " . basename($file));
                            $deletedCount++;
                        }
                    }
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Clean old temporary files
     */
    protected function cleanTemporaryFiles(int $hours, bool $dryRun): int
    {
        $tempDisk = config('file-upload.storage.temp_disk', 'local');
        $cutoffTime = Carbon::now()->subHours($hours);
        $deletedCount = 0;

        // Clean Livewire temporary files
        $livewireTempPath = 'livewire-tmp';
        
        if (Storage::disk($tempDisk)->exists($livewireTempPath)) {
            $tempFiles = Storage::disk($tempDisk)->allFiles($livewireTempPath);
            
            foreach ($tempFiles as $file) {
                $fileTime = Carbon::createFromTimestamp(Storage::disk($tempDisk)->lastModified($file));
                
                if ($fileTime->lt($cutoffTime)) {
                    if ($dryRun) {
                        $this->line("Would delete temp file: {$file}");
                        $deletedCount++;
                    } else {
                        if (Storage::disk($tempDisk)->delete($file)) {
                            $this->line("Deleted temp file: {$file}");
                            $deletedCount++;
                        }
                    }
                }
            }
        }

        return $deletedCount;
    }

    /**
     * Clean orphaned thumbnail files
     */
    protected function cleanOrphanedThumbnails(bool $dryRun): int
    {
        $publicDisk = config('file-upload.storage.public_disk', 'public');
        $deletedCount = 0;

        // Get all thumbnail files
        $allFiles = Storage::disk($publicDisk)->allFiles();
        $thumbnailFiles = array_filter($allFiles, function ($file) {
            return strpos(basename($file), 'thumb_') === 0;
        });

        foreach ($thumbnailFiles as $thumbnailFile) {
            // Check if original file exists
            $originalFile = str_replace('thumb_', '', $thumbnailFile);
            
            if (!Storage::disk($publicDisk)->exists($originalFile)) {
                if ($dryRun) {
                    $this->line("Would delete orphaned thumbnail: {$thumbnailFile}");
                    $deletedCount++;
                } else {
                    if (Storage::disk($publicDisk)->delete($thumbnailFile)) {
                        $this->line("Deleted orphaned thumbnail: {$thumbnailFile}");
                        $deletedCount++;
                    }
                }
            }
        }

        return $deletedCount;
    }
}