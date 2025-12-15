<?php

namespace Database\Factories;

use App\Models\Car;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = ['Toyota', 'Honda', 'Daihatsu', 'Suzuki', 'Mitsubishi', 'Nissan'];
        $models = [
            'Toyota' => ['Avanza', 'Innova', 'Calya', 'Rush', 'Fortuner'],
            'Honda' => ['Brio', 'Mobilio', 'BR-V', 'HR-V', 'CR-V'],
            'Daihatsu' => ['Xenia', 'Terios', 'Ayla', 'Sigra', 'Gran Max'],
            'Suzuki' => ['Ertiga', 'XL7', 'Baleno', 'Swift', 'Jimny'],
            'Mitsubishi' => ['Xpander', 'Pajero Sport', 'Outlander', 'Mirage'],
            'Nissan' => ['Grand Livina', 'Serena', 'X-Trail', 'Juke', 'Kicks'],
        ];

        $brand = $this->faker->randomElement($brands);
        $model = $this->faker->randomElement($models[$brand]);

        return [
            'license_plate' => 'B ' . $this->faker->numberBetween(1000, 9999) . ' ' . strtoupper($this->faker->lexify('???')),
            'brand' => $brand,
            'model' => $model,
            'year' => $this->faker->numberBetween(2015, 2024),
            'color' => $this->faker->randomElement(['White', 'Black', 'Silver', 'Red', 'Blue', 'Gray']),
            'stnk_number' => 'STNK' . $this->faker->numberBetween(100000, 999999),
            'stnk_expiry' => $this->faker->dateTimeBetween('now', '+2 years'),
            'last_oil_change' => $this->faker->optional(0.8)->dateTimeBetween('-6 months', 'now'),
            'oil_change_interval_km' => $this->faker->optional(0.9)->randomElement([5000, 7500, 10000]),
            'photo_front' => null,
            'photo_side' => null,
            'photo_back' => null,
            'current_odometer' => $this->faker->numberBetween(5000, 150000),
            'daily_rate' => $this->faker->numberBetween(200000, 500000),
            'weekly_rate' => function (array $attributes) {
                return $attributes['daily_rate'] * 6; // Weekly rate is typically 6x daily rate
            },
            'driver_fee_per_day' => $this->faker->numberBetween(75000, 150000),
            'status' => $this->faker->randomElement([
                Car::STATUS_AVAILABLE,
                Car::STATUS_AVAILABLE, // Make available more likely
                Car::STATUS_AVAILABLE,
                Car::STATUS_RENTED,
                Car::STATUS_MAINTENANCE,
                Car::STATUS_INACTIVE,
            ]),
        ];
    }

    /**
     * Indicate that the vehicle is available.
     */
    public function available(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Car::STATUS_AVAILABLE,
        ]);
    }

    /**
     * Indicate that the vehicle is rented.
     */
    public function rented(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Car::STATUS_RENTED,
        ]);
    }

    /**
     * Indicate that the vehicle is in maintenance.
     */
    public function maintenance(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Car::STATUS_MAINTENANCE,
        ]);
    }

    /**
     * Indicate that the vehicle is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => Car::STATUS_INACTIVE,
        ]);
    }

    /**
     * Indicate that the vehicle needs oil change.
     */
    public function needsOilChange(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_oil_change' => now()->subDays(100), // Overdue by 10 days
        ]);
    }

    /**
     * Indicate that the vehicle's STNK is expiring soon.
     */
    public function stnkExpiringSoon(): static
    {
        return $this->state(fn (array $attributes) => [
            'stnk_expiry' => now()->addDays(15), // Expires in 15 days
        ]);
    }

    /**
     * Indicate that the vehicle has photos.
     */
    public function withPhotos(): static
    {
        return $this->state(fn (array $attributes) => [
            'photo_front' => 'vehicles/' . $attributes['license_plate'] . '_front_' . now()->format('YmdHis') . '.jpg',
            'photo_side' => 'vehicles/' . $attributes['license_plate'] . '_side_' . now()->format('YmdHis') . '.jpg',
            'photo_back' => 'vehicles/' . $attributes['license_plate'] . '_back_' . now()->format('YmdHis') . '.jpg',
        ]);
    }

    /**
     * Indicate that the vehicle is a luxury model.
     */
    public function luxury(): static
    {
        return $this->state(fn (array $attributes) => [
            'brand' => $this->faker->randomElement(['Toyota', 'Honda', 'Mitsubishi']),
            'model' => $this->faker->randomElement(['Fortuner', 'CR-V', 'Pajero Sport']),
            'year' => $this->faker->numberBetween(2020, 2024),
            'daily_rate' => $this->faker->numberBetween(400000, 800000),
            'weekly_rate' => function (array $attributes) {
                return $attributes['daily_rate'] * 6;
            },
            'driver_fee_per_day' => $this->faker->numberBetween(120000, 200000),
        ]);
    }

    /**
     * Indicate that the vehicle is economy class.
     */
    public function economy(): static
    {
        return $this->state(fn (array $attributes) => [
            'brand' => $this->faker->randomElement(['Daihatsu', 'Suzuki']),
            'model' => $this->faker->randomElement(['Ayla', 'Calya', 'Sigra', 'Baleno']),
            'daily_rate' => $this->faker->numberBetween(150000, 250000),
            'weekly_rate' => function (array $attributes) {
                return $attributes['daily_rate'] * 6;
            },
            'driver_fee_per_day' => $this->faker->numberBetween(75000, 100000),
        ]);
    }
}