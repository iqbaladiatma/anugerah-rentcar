<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
            ->subject($this->data['title'] . ' - Anugerah Rentcar')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line($this->data['message']);

        // Add booking-specific information
        if (isset($this->data['booking'])) {
            $booking = $this->data['booking'];
            $mailMessage->line("Booking Number: #{$booking->booking_number}")
                       ->line("Vehicle: {$booking->car->brand} {$booking->car->model} ({$booking->car->license_plate})")
                       ->line("Start Date: " . $booking->start_date->format('d M Y H:i'))
                       ->line("End Date: " . $booking->end_date->format('d M Y H:i'))
                       ->line("Total Amount: Rp " . number_format($booking->total_amount, 0, ',', '.'));
        }

        // Add action based on notification type
        switch ($this->data['type']) {
            case 'booking_confirmation':
                $mailMessage->action('View Booking Details', route('customer.bookings'));
                break;
            case 'booking_reminder':
                $mailMessage->action('View Booking', route('customer.bookings'));
                break;
            case 'payment_reminder':
                $mailMessage->action('Make Payment', route('customer.bookings'));
                break;
        }

        $mailMessage->line('Thank you for choosing Anugerah Rentcar!')
                   ->line('If you have any questions, please contact our customer service.');

        return $mailMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return $this->data;
    }
}
