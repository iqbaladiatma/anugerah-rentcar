<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NotificationService;

class GenerateNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifications:generate {--type=all : Type of notifications to generate (all, maintenance, stnk, payment, booking)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate system notifications for maintenance, STNK expiry, payments, and bookings';

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
        $type = $this->option('type');
        
        $this->info('Generating notifications...');
        
        $totalGenerated = 0;
        
        switch ($type) {
            case 'maintenance':
                $notifications = $this->notificationService->generateMaintenanceNotifications();
                $totalGenerated += $notifications->count();
                $this->info("Generated {$notifications->count()} maintenance notifications");
                break;
                
            case 'stnk':
                $notifications = $this->notificationService->generateStnkExpiryNotifications();
                $totalGenerated += $notifications->count();
                $this->info("Generated {$notifications->count()} STNK expiry notifications");
                break;
                
            case 'payment':
                $notifications = $this->notificationService->generatePaymentOverdueNotifications();
                $totalGenerated += $notifications->count();
                $this->info("Generated {$notifications->count()} payment overdue notifications");
                break;
                
            case 'booking':
                $notifications = $this->notificationService->generateBookingConfirmationNotifications();
                $totalGenerated += $notifications->count();
                $this->info("Generated {$notifications->count()} booking confirmation notifications");
                break;
                
            case 'all':
            default:
                $allNotifications = $this->notificationService->generateSystemNotifications();
                $totalGenerated = $allNotifications->count();
                
                // Group by type for reporting
                $byType = $allNotifications->groupBy('type');
                foreach ($byType as $notificationType => $notifications) {
                    $this->info("Generated {$notifications->count()} {$notificationType} notifications");
                }
                break;
        }
        
        $this->info("Total notifications generated: {$totalGenerated}");
        
        return Command::SUCCESS;
    }
}
