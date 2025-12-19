<?php

namespace App\Listeners;

use App\Events\BookingCreated;
use App\Services\NotificationService;
use App\Models\Notification;
use App\Models\Booking;
use App\Models\User;

class SendBookingNotifications
{

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

        // Get all admin and staff users
        $adminUsers = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
            ->where('is_active', true)
            ->get();

        $carInfo = $booking->car ? "{$booking->car->brand} {$booking->car->model} ({$booking->car->license_plate})" : 'N/A';
        $customerName = $booking->customer ? $booking->customer->name : 'N/A';

        // Create notification for each admin/staff
        foreach ($adminUsers as $user) {
            // Notifikasi Orderan Baru
            Notification::create([
                'type' => Notification::TYPE_NEW_BOOKING,
                'title' => 'Orderan Baru',
                'message' => "Orderan baru dari {$customerName}",
                'details' => "Booking #{$booking->booking_number} | Kendaraan: {$carInfo} | Total: Rp " . number_format($booking->total_amount, 0, ',', '.'),
                'priority' => Notification::PRIORITY_HIGH,
                'icon' => 'shopping-cart',
                'notifiable_type' => Booking::class,
                'notifiable_id' => $booking->id,
                'user_id' => $user->id,
                'recipient_type' => Notification::RECIPIENT_USER,
                'action_url' => route('admin.bookings.show', $booking->id),
                'is_active' => true,
            ]);
        }

        // Send booking confirmation email to customer
        if ($booking->customer && $booking->customer->email) {
            $this->notificationService->sendBookingConfirmationToCustomer($booking);
        }
    }
}
