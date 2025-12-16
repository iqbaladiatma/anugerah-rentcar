<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Support\Collection;

class NotificationWidget extends Component
{
    public $showDropdown = false;
    
    protected $notificationService;

    public function boot(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function getUnreadCountProperty(): int
    {
        return $this->notificationService->getUnreadCount(auth()->id());
    }

    public function getRecentNotificationsProperty(): Collection
    {
        return $this->notificationService->getRecentNotifications(auth()->id(), 5);
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead($notificationId)
    {
        $this->notificationService->markAsRead($notificationId, auth()->id());
        $this->dispatch('notification-read');
    }

    public function markAllAsRead()
    {
        $this->notificationService->markAllAsRead(auth()->id());
        $this->dispatch('notifications-marked-read');
    }

    public function render()
    {
        return view('livewire.admin.notification-widget');
    }
}
