<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Collection;

class NotificationCenter extends Component
{
    use WithPagination;

    public $showUnreadOnly = false;
    public $selectedType = '';
    public $selectedPriority = '';

    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function mount()
    {
        // Component initialization
    }

    public function getNotificationsProperty()
    {
        $query = Notification::with('notifiable')
            ->where('user_id', auth()->id())
            ->active()
            ->orderBy('priority', 'asc')
            ->orderBy('created_at', 'desc');

        if ($this->showUnreadOnly) {
            $query->unread();
        }

        if ($this->selectedType) {
            $query->ofType($this->selectedType);
        }

        if ($this->selectedPriority) {
            $query->withPriority($this->selectedPriority);
        }

        return $query->paginate(10);
    }

    public function getUnreadCountProperty(): int
    {
        return $this->notificationService->getUnreadCount(auth()->id());
    }

    public function getNotificationTypesProperty(): array
    {
        return [
            '' => 'All Types',
            Notification::TYPE_NEW_CUSTOMER => 'Pelanggan Baru',
            Notification::TYPE_NEW_BOOKING => 'Orderan Baru',
            Notification::TYPE_MAINTENANCE => 'Maintenance',
            Notification::TYPE_STNK_EXPIRY => 'STNK Expiry',
            Notification::TYPE_PAYMENT_OVERDUE => 'Payment Overdue',
            Notification::TYPE_BOOKING_CONFIRMATION => 'Booking Confirmation',
            Notification::TYPE_BOOKING_REMINDER => 'Booking Reminder',
            Notification::TYPE_VEHICLE_RETURN => 'Vehicle Return',
            Notification::TYPE_SYSTEM_ALERT => 'System Alert',
        ];
    }

    public function getPriorityOptionsProperty(): array
    {
        return [
            '' => 'All Priorities',
            Notification::PRIORITY_HIGH => 'High',
            Notification::PRIORITY_MEDIUM => 'Medium',
            Notification::PRIORITY_LOW => 'Low',
        ];
    }

    public function markAsRead($notificationId)
    {
        $this->notificationService->markAsRead($notificationId, auth()->id());
        $this->dispatch('notification-read');
    }

    public function markAllAsRead()
    {
        $count = $this->notificationService->markAllAsRead(auth()->id());
        $this->dispatch('notifications-marked-read', count: $count);
        session()->flash('message', "Berhasil menandai {$count} notifikasi sebagai sudah dibaca.");
    }

    public function toggleUnreadFilter()
    {
        $this->showUnreadOnly = !$this->showUnreadOnly;
        $this->resetPage();
    }

    public function filterByType($type)
    {
        $this->selectedType = $type;
        $this->resetPage();
    }

    public function filterByPriority($priority)
    {
        $this->selectedPriority = $priority;
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->showUnreadOnly = false;
        $this->selectedType = '';
        $this->selectedPriority = '';
        $this->resetPage();
    }

    public function refreshNotifications()
    {
        // Generate new system notifications
        $this->notificationService->generateSystemNotifications();
        $this->dispatch('notifications-refreshed');
        session()->flash('message', 'Notifications refreshed successfully.');
    }

    public function render()
    {
        return view('livewire.admin.notification-center', [
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
            'notificationTypes' => $this->notificationTypes,
            'priorityOptions' => $this->priorityOptions,
        ]);
    }
}
