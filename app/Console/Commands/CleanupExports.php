<?php

namespace App\Console\Commands;

use App\Services\ExportService;
use Illuminate\Console\Command;

class CleanupExports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'exports:cleanup {--days=30 : Number of days to keep export files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old export files to free up storage space';

    /**
     * Execute the console command.
     */
    public function handle(ExportService $exportService)
    {
        $days = $this->option('days');
        
        $this->info("Cleaning up export files older than {$days} days...");
        
        $deletedCount = $exportService->cleanupOldExports($days);
        
        if ($deletedCount > 0) {
            $this->info("Successfully deleted {$deletedCount} old export files.");
        } else {
            $this->info("No old export files found to delete.");
        }
        
        return Command::SUCCESS;
    }
}
