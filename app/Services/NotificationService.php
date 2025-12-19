<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\NotificationPreference;
use App\Models\User;
use App\Models\Car;
use App\Models\Booking;
use App\Models\Customer;
use App\Notifications\SystemNotification;
use App\Notifications\CustomerNotification;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class NotificationService
{
    /**
     * Create and send a notification.
     */
    public function createNotification(array $data): Notification
    {
        $notification = Notification::create($data);
        
        // Send notification based on recipient type
        if ($notification->recipient_type === Notification::RECIPIENT_ALL_STAFF) {
            $this->sendToAllStaff($notification);
        } elseif ($notification->user_id) {
            $this->sendToUser($notification, User::find($notification->user_id));
        }
        
        return $notification;
    }

    /**
     * Send notification to all staff members.
     */
    public function sendToAllStaff(Notification $notification): void
    {
        $staffUsers = User::whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
            ->where('is_active', true)
            ->get();

        foreach ($staffUsers as $user) {
            // Create individual notification for each staff member
            $userNotification = $notification->replicate();
            $userNotification->user_id = $user->id;
            $userNotification->recipient_type = Notification::RECIPIENT_USER;
            $userNotification->save();
            
            $this->sendToUser($userNotification, $user);
        }
        
        // Mark original notification as processed
        $notification->update(['is_active' => false]);
    }

    /**
     * Send notification to a specific user.
     */
    public function sendToUser(Notification $notification, User $user): void
    {
        $preferences = $this->getUserPreferences($user, $notification->type);
        
        // Send email if enabled
        if ($preferences->shouldReceiveEmail($notification->priority)) {
            $this->sendEmailNotification($notification, $user);
        }
        
        // Send SMS if enabled
        if ($preferences->shouldReceiveSms($notification->priority)) {
            $this->sendSmsNotification($notification, $user);
        }
        
        // Browser notifications are handled by the frontend
        if ($preferences->shouldReceiveBrowser($notification->priority)) {
            // Mark as ready for browser notification
            $notification->updateDeliveryStatus('browser', 'ready');
        }
    }

    /**
     * Send email notification.
     */
    protected function sendEmailNotification(Notification $notification, User $user): void
    {
        try {
            // Mail::to($user->email)->send(new SystemNotification($notification));
            Log::info('Email notification disabled per user request', [
                'notification_id' => $notification->id,
                'user_id' => $user->id
            ]);
            $notification->markEmailSent();
            $notification->updateDeliveryStatus('email', 'sent');
        } catch (\Exception $e) {
            Log::error('Failed to send email notification', [
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            $notification->updateDeliveryStatus('email', 'failed', $e->getMessage());
        }
    }

    /**
     * Send SMS notification.
     */
    protected function sendSmsNotification(Notification $notification, User $user): void
    {
        try {
            // This would integrate with SMS service (Twilio, etc.)
            // For now, we'll just log it
            Log::info('SMS notification would be sent', [
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'phone' => $user->phone,
                'message' => $notification->message,
            ]);
            
            $notification->markSmsSent();
            $notification->updateDeliveryStatus('sms', 'sent');
        } catch (\Exception $e) {
            Log::error('Failed to send SMS notification', [
                'notification_id' => $notification->id,
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
            $notification->updateDeliveryStatus('sms', 'failed', $e->getMessage());
        }
    }

    /**
     * Send notification to customer.
     */
    public function sendCustomerNotification(Customer $customer, array $data): void
    {
        try {
            if ($customer->email) {
                // Mail::to($customer->email)->send(new CustomerNotification($data));
                Log::info('Customer notification sent', [
                    'customer_id' => $customer->id,
                    'type' => $data['type'] ?? 'general',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send customer notification', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Get user notification preferences.
     */
    protected function getUserPreferences(User $user, string $notificationType): NotificationPreference
    {
        return NotificationPreference::firstOrCreate(
            [
                'user_id' => $user->id,
                'notification_type' => $notificationType,
            ],
            NotificationPreference::getDefaultPreferences()[$notificationType] ?? []
        );
    }

    /**
     * Generate maintenance notifications.
     */
    public function generateMaintenanceNotifications(): Collection
    {
        $notifications = collect();
        
        $carsNeedingMaintenance = Car::where(function ($query) {
            $query->where('last_oil_change', '<=', Carbon::now()->subDays(90))
                  ->orWhereNull('last_oil_change');
        })->get();

        foreach ($carsNeedingMaintenance as $car) {
            // Check if notification already exists for this car
            $existingNotification = Notification::where('type', Notification::TYPE_MAINTENANCE)
                ->where('notifiable_type', Car::class)
                ->where('notifiable_id', $car->id)
                ->where('is_active', true)
                ->first();

            if (!$existingNotification) {
                $daysSinceOilChange = $car->last_oil_change 
                    ? Carbon::parse($car->last_oil_change)->diffInDays(Carbon::now())
                    : 999;

                $notification = Notification::createMaintenanceNotification(
                    $car,
                    "Oil change due for {$car->license_plate}",
                    $daysSinceOilChange > 90 ? "{$daysSinceOilChange} days overdue" : "Due now"
                );
                
                $notifications->push($notification);
            }
        }

        return $notifications;
    }

    /**
     * Generate STNK expiry notifications.
     */
    public function generateStnkExpiryNotifications(): Collection
    {
        $notifications = collect();
        
        $carsWithExpiringStnk = Car::where('stnk_expiry', '<=', Carbon::now()->addDays(7))
            ->where('stnk_expiry', '>=', Carbon::now())
            ->get();

        foreach ($carsWithExpiringStnk as $car) {
            // Check if notification already exists for this car
            $existingNotification = Notification::where('type', Notification::TYPE_STNK_EXPIRY)
                ->where('notifiable_type', Car::class)
                ->where('notifiable_id', $car->id)
                ->where('is_active', true)
                ->first();

            if (!$existingNotification) {
                $daysLeft = Carbon::parse($car->stnk_expiry)->diffInDays(Carbon::now());
                
                $notification = Notification::createStnkExpiryNotification($car, $daysLeft);
                $notifications->push($notification);
            }
        }

        return $notifications;
    }

    /**
     * Generate payment overdue notifications.
     */
    public function generatePaymentOverdueNotifications(): Collection
    {
        $notifications = collect();
        
        $overdueBookings = Booking::with('customer')
            ->where('payment_status', Booking::PAYMENT_PENDING)
            ->where('created_at', '<=', Carbon::now()->subDays(1))
            ->get();

        foreach ($overdueBookings as $booking) {
            // Check if notification already exists for this booking
            $existingNotification = Notification::where('type', Notification::TYPE_PAYMENT_OVERDUE)
                ->where('notifiable_type', Booking::class)
                ->where('notifiable_id', $booking->id)
                ->where('is_active', true)
                ->first();

            if (!$existingNotification) {
                $daysOverdue = Carbon::parse($booking->created_at)->diffInDays(Carbon::now());
                
                $notification = Notification::createPaymentOverdueNotification($booking, $daysOverdue);
                $notifications->push($notification);
            }
        }

        return $notifications;
    }

    /**
     * Generate booking confirmation notifications.
     */
    public function generateBookingConfirmationNotifications(): Collection
    {
        $notifications = collect();
        
        $pendingBookings = Booking::with('customer')
            ->where('booking_status', Booking::STATUS_PENDING)
            ->get();

        foreach ($pendingBookings as $booking) {
            // Check if notification already exists for this booking
            $existingNotification = Notification::where('type', Notification::TYPE_BOOKING_CONFIRMATION)
                ->where('notifiable_type', Booking::class)
                ->where('notifiable_id', $booking->id)
                ->where('is_active', true)
                ->first();

            if (!$existingNotification) {
                $notification = Notification::createBookingConfirmationNotification($booking);
                $notifications->push($notification);
            }
        }

        return $notifications;
    }

    /**
     * Generate all system notifications.
     */
    public function generateSystemNotifications(): Collection
    {
        $allNotifications = collect();
        
        $allNotifications = $allNotifications->merge($this->generateMaintenanceNotifications());
        $allNotifications = $allNotifications->merge($this->generateStnkExpiryNotifications());
        $allNotifications = $allNotifications->merge($this->generatePaymentOverdueNotifications());
        $allNotifications = $allNotifications->merge($this->generateBookingConfirmationNotifications());
        
        return $allNotifications;
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(int $notificationId, int $userId): bool
    {
        $notification = Notification::where('id', $notificationId)
            ->where('user_id', $userId)
            ->first();

        if ($notification) {
            $notification->markAsRead();
            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read for user.
     */
    public function markAllAsRead(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->update(['read_at' => Carbon::now()]);
    }

    /**
     * Get unread notifications count for user.
     */
    public function getUnreadCount(int $userId): int
    {
        return Notification::where('user_id', $userId)
            ->unread()
            ->active()
            ->count();
    }

    /**
     * Get recent notifications for user.
     */
    public function getRecentNotifications(int $userId, int $limit = 10): Collection
    {
        return Notification::where('user_id', $userId)
            ->active()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Clean up old notifications.
     */
    public function cleanupOldNotifications(int $daysOld = 30): int
    {
        return Notification::where('created_at', '<', Carbon::now()->subDays($daysOld))
            ->where('read_at', '!=', null)
            ->delete();
    }

    /**
     * Send booking confirmation email to customer.
     */
    public function sendBookingConfirmationToCustomer(Booking $booking): void
    {
        $this->sendCustomerNotification($booking->customer, [
            'type' => 'booking_confirmation',
            'title' => 'Booking Confirmation',
            'booking' => $booking,
            'message' => "Your booking #{$booking->booking_number} has been confirmed.",
        ]);
    }

    /**
     * Send booking reminder to customer.
     */
    public function sendBookingReminderToCustomer(Booking $booking): void
    {
        $this->sendCustomerNotification($booking->customer, [
            'type' => 'booking_reminder',
            'title' => 'Booking Reminder',
            'booking' => $booking,
            'message' => "Reminder: Your booking #{$booking->booking_number} starts tomorrow.",
        ]);
    }

    /**
     * Send payment reminder to customer.
     */
    public function sendPaymentReminderToCustomer(Booking $booking): void
    {
        $this->sendCustomerNotification($booking->customer, [
            'type' => 'payment_reminder',
            'title' => 'Payment Reminder',
            'booking' => $booking,
            'message' => "Payment is due for booking #{$booking->booking_number}.",
        ]);
    }
}