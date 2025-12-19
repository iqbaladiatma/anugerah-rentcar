<?php

namespace App\Listeners;

use App\Events\CustomerCreated;
use App\Services\NotificationService;
use App\Models\Notification;
use App\Models\Customer;
use App\Models\User;

class SendCustomerNotifications
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
    public function handle(CustomerCreated $event): void
    {
        $customer = $event->customer;

        // Get all admin and staff users
        $adminUsers = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
            ->where('is_active', true)
            ->get();

        // Create notification for each admin/staff
        foreach ($adminUsers as $user) {
            Notification::create([
                'type' => Notification::TYPE_NEW_CUSTOMER,
                'title' => 'Pelanggan Baru',
                'message' => "Pelanggan baru telah terdaftar: {$customer->name}",
                'details' => "Telepon: {$customer->phone}" . ($customer->email ? " | Email: {$customer->email}" : ""),
                'priority' => Notification::PRIORITY_LOW,
                'icon' => 'user-plus',
                'notifiable_type' => Customer::class,
                'notifiable_id' => $customer->id,
                'user_id' => $user->id,
                'recipient_type' => Notification::RECIPIENT_USER,
                'action_url' => route('admin.customers.show', $customer->id),
                'is_active' => true,
            ]);
        }
    }
}
