<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Models\Notification;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Mark a notification as read.
     */
    public function markAsRead(Request $request, Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read for the current user.
     */
    public function markAllAsRead(Request $request)
    {
        $count = $this->notificationService->markAllAsRead(auth()->id());

        return response()->json([
            'success' => true,
            'count' => $count,
        ]);
    }

    /**
     * Get unread notification count for the current user.
     */
    public function getUnreadCount(Request $request)
    {
        $count = $this->notificationService->getUnreadCount(auth()->id());

        return response()->json([
            'count' => $count,
        ]);
    }

    /**
     * Generate system notifications.
     */
    public function generate(Request $request)
    {
        $request->validate([
            'type' => 'nullable|string|in:all,maintenance,stnk,payment,booking',
        ]);

        $type = $request->input('type', 'all');
        $notifications = collect();

        switch ($type) {
            case 'maintenance':
                $notifications = $this->notificationService->generateMaintenanceNotifications();
                break;
            case 'stnk':
                $notifications = $this->notificationService->generateStnkExpiryNotifications();
                break;
            case 'payment':
                $notifications = $this->notificationService->generatePaymentOverdueNotifications();
                break;
            case 'booking':
                $notifications = $this->notificationService->generateBookingConfirmationNotifications();
                break;
            case 'all':
            default:
                $notifications = $this->notificationService->generateSystemNotifications();
                break;
        }

        return response()->json([
            'success' => true,
            'count' => $notifications->count(),
            'message' => "Generated {$notifications->count()} notifications",
        ]);
    }
}
