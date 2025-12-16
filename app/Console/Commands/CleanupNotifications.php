<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class CleanupNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:cleanup {--days=30 : Number of days to keep read notifications}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up old read notifications to keep the database tidy';

    protected $notificationService;

    /**
     * Create a new command instance.
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService = $notificationService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = (int) $this->option('days');
        
        $this->info("Cleaning up notifications older than {$days} days...");
        
        $deletedCount = $this->notificationService->cleanupOldNotifications($days);
        
        $this->info("Deleted {$deletedCount} old notifications");
        
        return Command::SUCCESS;
    }
}
