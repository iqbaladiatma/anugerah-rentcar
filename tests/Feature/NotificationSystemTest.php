<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Car;
use App\Models\Notification;
use App\Services\NotificationService;
use Carbon\Carbon;

class NotificationSystemTest extends TestCase
{
    use RefreshDatabase;

    protected $notificationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->notificationService = app(NotificationService::class);
    }

    /** @test */
    public function notification_service_can_generate_maintenance_notifications()
    {
        // Create a car with overdue oil change
        $car = Car::factory()->create([
            'last_oil_change' => Carbon::now()->subDays(100),
            'license_plate' => 'B 1234 TEST',
        ]);

        $notifications = $this->notificationService->generateMaintenanceNotifications();

        $this->assertCount(1, $notifications);
        $this->assertEquals(Notification::TYPE_MAINTENANCE, $notifications->first()->type);
        $this->assertStringContainsString('Oil change due', $notifications->first()->message);
    }

    /** @test */
    public function notification_service_can_generate_stnk_expiry_notifications()
    {
        // Create a car with STNK expiring soon
        $car = Car::factory()->create([
            'stnk_expiry' => Carbon::now()->addDays(15),
            'license_plate' => 'B 5678 TEST',
        ]);

        $notifications = $this->notificationService->generateStnkExpiryNotifications();

        $this->assertCount(1, $notifications);
        $this->assertEquals(Notification::TYPE_STNK_EXPIRY, $notifications->first()->type);
        $this->assertStringContainsString('STNK expires soon', $notifications->first()->message);
    }

    /** @test */
    public function notification_can_be_marked_as_read()
    {
        $user = User::factory()->create();
        
        $notification = Notification::create([
            'type' => Notification::TYPE_MAINTENANCE,
            'title' => 'Test Notification',
            'message' => 'Test message',
            'priority' => Notification::PRIORITY_MEDIUM,
            'user_id' => $user->id,
            'recipient_type' => Notification::RECIPIENT_USER,
        ]);

        $this->assertTrue($notification->isUnread());

        $result = $this->notificationService->markAsRead($notification->id, $user->id);

        $this->assertTrue($result);
        $notification->refresh();
        $this->assertTrue($notification->isRead());
    }

    /** @test */
    public function notification_service_can_get_unread_count()
    {
        $user = User::factory()->create();
        
        // Create some notifications
        Notification::factory()->count(3)->create([
            'user_id' => $user->id,
            'read_at' => null,
        ]);
        
        Notification::factory()->count(2)->create([
            'user_id' => $user->id,
            'read_at' => Carbon::now(),
        ]);

        $unreadCount = $this->notificationService->getUnreadCount($user->id);

        $this->assertEquals(3, $unreadCount);
    }

    /** @test */
    public function notification_service_can_mark_all_as_read()
    {
        $user = User::factory()->create();
        
        // Create some unread notifications
        Notification::factory()->count(5)->create([
            'user_id' => $user->id,
            'read_at' => null,
        ]);

        $markedCount = $this->notificationService->markAllAsRead($user->id);

        $this->assertEquals(5, $markedCount);
        
        $unreadCount = $this->notificationService->getUnreadCount($user->id);
        $this->assertEquals(0, $unreadCount);
    }
}