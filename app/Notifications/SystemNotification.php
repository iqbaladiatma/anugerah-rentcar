<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification as LaravelNotification;
use App\Models\Notification;

class SystemNotification extends LaravelNotification implements ShouldQueue
{
    use Queueable;

    protected $notification;

    /**
     * Create a new notification instance.
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $mailMessage = (new MailMessage)
            ->subject($this->notification->title . ' - Anugerah Rentcar')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->notification->message);

        if ($this->notification->details) {
            $mailMessage->line($this->notification->details);
        }

        if ($this->notification->action_url) {
            $mailMessage->action('View Details', $this->notification->action_url);
        }

        $mailMessage->line('This is an automated notification from Anugerah Rentcar system.');

        // Add priority indicator
        if ($this->notification->priority === Notification::PRIORITY_HIGH) {
            $mailMessage->line('⚠️ This is a high priority notification that requires immediate attention.');
        }

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'id' => $this->notification->id,
            'type' => $this->notification->type,
            'title' => $this->notification->title,
            'message' => $this->notification->message,
            'details' => $this->notification->details,
            'priority' => $this->notification->priority,
            'action_url' => $this->notification->action_url,
        ];
    }
}
