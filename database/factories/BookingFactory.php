<?php

namespace Database\Factories;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+30 days');
        $endDate = Carbon::parse($startDate)->addDays($this->faker->numberBetween(1, 7));
        
        $baseAmount = $this->faker->randomFloat(2, 200000, 1000000);
        $driverFee = $this->faker->boolean(30) ? $this->faker->randomFloat(2, 100000, 300000) : 0;
        $outOfTownFee = $this->faker->boolean(20) ? $this->faker->randomFloat(2, 50000, 200000) : 0;
        $memberDiscount = $this->faker->boolean(25) ? $this->faker->randomFloat(2, 20000, 100000) : 0;
        
        return [
            'booking_number' => 'BK' . Carbon::now()->format('Ymd') . str_pad($this->faker->unique()->numberBetween(1, 999), 3, '0', STR_PAD_LEFT),
            'customer_id' => Customer::factory(),
            'car_id' => Car::factory(),
            'driver_id' => $this->faker->boolean(30) ? User::factory() : null,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'actual_return_date' => null,
            'pickup_location' => $this->faker->address(),
            'return_location' => $this->faker->address(),
            'with_driver' => $driverFee > 0,
            'is_out_of_town' => $outOfTownFee > 0,
            'out_of_town_fee' => $outOfTownFee,
            'base_amount' => $baseAmount,
            'driver_fee' => $driverFee,
            'member_discount' => $memberDiscount,
            'late_penalty' => 0,
            'total_amount' => $baseAmount + $driverFee + $outOfTownFee - $memberDiscount,
            'deposit_amount' => $this->faker->randomFloat(2, 500000, 2000000),
            'payment_status' => $this->faker->randomElement(['pending', 'partial', 'paid']),
            'booking_status' => $this->faker->randomElement(['pending', 'confirmed', 'active']),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    /**
     * Indicate that the booking is confirmed.
     */
    public function confirmed(): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_status' => 'confirmed',
            'payment_status' => 'paid',
        ]);
    }

    /**
     * Indicate that the booking is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_status' => 'active',
            'payment_status' => 'paid',
        ]);
    }

    /**
     * Indicate that the booking is completed.
     */
    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_status' => 'completed',
            'payment_status' => 'paid',
            'actual_return_date' => Carbon::parse($attributes['end_date'])->addHours($this->faker->numberBetween(-2, 5)),
        ]);
    }

    /**
     * Indicate that the booking is overdue.
     */
    public function overdue(): static
    {
        return $this->state(fn (array $attributes) => [
            'booking_status' => 'active',
            'payment_status' => 'paid',
            'end_date' => Carbon::now()->subHours($this->faker->numberBetween(1, 48)),
        ]);
    }

    /**
     * Indicate that the booking has a driver.
     */
    public function withDriver(): static
    {
        return $this->state(fn (array $attributes) => [
            'with_driver' => true,
            'driver_id' => User::factory(),
            'driver_fee' => $this->faker->randomFloat(2, 100000, 300000),
        ]);
    }

    /**
     * Indicate that the booking is out of town.
     */
    public function outOfTown(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_out_of_town' => true,
            'out_of_town_fee' => $this->faker->randomFloat(2, 50000, 200000),
        ]);
    }

    /**
     * Indicate that the booking has member discount.
     */
    public function withMemberDiscount(): static
    {
        return $this->state(fn (array $attributes) => [
            'member_discount' => $this->faker->randomFloat(2, 20000, 100000),
        ]);
    }
}