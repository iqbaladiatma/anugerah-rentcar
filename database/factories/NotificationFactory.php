<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Notification;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement([
                Notification::TYPE_MAINTENANCE,
                Notification::TYPE_STNK_EXPIRY,
                Notification::TYPE_PAYMENT_OVERDUE,
                Notification::TYPE_BOOKING_CONFIRMATION,
            ]),
            'title' => $this->faker->sentence(3),
            'message' => $this->faker->sentence(),
            'details' => $this->faker->optional()->sentence(),
            'priority' => $this->faker->randomElement([
                Notification::PRIORITY_LOW,
                Notification::PRIORITY_MEDIUM,
                Notification::PRIORITY_HIGH,
            ]),
            'data' => null,
            'action_url' => $this->faker->optional()->url(),
            'icon' => $this->faker->randomElement(['wrench', 'calendar', 'currency-dollar', 'clipboard-list']),
            'user_id' => User::factory(),
            'recipient_type' => Notification::RECIPIENT_USER,
            'read_at' => null,
            'email_sent_at' => null,
            'sms_sent_at' => null,
            'delivery_status' => null,
            'is_active' => true,
            'expires_at' => null,
        ];
    }

    /**
     * Indicate that the notification is read.
     */
    public function read(): static
    {
        return $this->state(fn (array $attributes) => [
            'read_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
        ]);
    }

    /**
     * Indicate that the notification is high priority.
     */
    public function highPriority(): static
    {
        return $this->state(fn (array $attributes) => [
            'priority' => Notification::PRIORITY_HIGH,
        ]);
    }

    /**
     * Indicate that the notification is for maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => Notification::TYPE_MAINTENANCE,
            'title' => 'Maintenance Due',
            'icon' => 'wrench',
        ]);
    }
}
