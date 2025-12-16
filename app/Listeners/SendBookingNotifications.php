<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Services\NotificationService;
use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendBookingNotifications implements ShouldQueue
{
    use InteractsWithQueue;

    protected $notificationService;

    /**
     * Create the event listener.
     */
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Handle the event.
     */
    public function handle(BookingCreated $event): void
    {
        $booking = $event->booking;

        // Create booking confirmation notification for staff
        Notification::createBookingConfirmationNotification($booking);

        // Send booking confirmation email to customer
        $this->notificationService->sendBookingConfirmationToCustomer($booking);
    }
}
