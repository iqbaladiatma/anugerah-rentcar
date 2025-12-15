<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Customer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->unique()->phoneNumber(),
            'email' => $this->faker->unique()->safeEmail(),
            'nik' => $this->faker->unique()->numerify('################'), // 16 digits
            'address' => $this->faker->address(),
            'ktp_photo' => 'customers/sample_ktp.jpg',
            'sim_photo' => 'customers/sample_sim.jpg',
            'is_member' => $this->faker->boolean(30), // 30% chance of being a member
            'member_discount' => function (array $attributes) {
                return $attributes['is_member'] ? $this->faker->randomFloat(2, 5, 20) : null;
            },
            'is_blacklisted' => $this->faker->boolean(5), // 5% chance of being blacklisted
            'blacklist_reason' => function (array $attributes) {
                return $attributes['is_blacklisted'] ? $this->faker->sentence() : null;
            },
        ];
    }

    /**
     * Indicate that the customer is a member.
     */
    public function member(float $discountPercentage = 10.0): static
    {
        return $this->state(fn (array $attributes) => [
            'is_member' => true,
            'member_discount' => $discountPercentage,
        ]);
    }

    /**
     * Indicate that the customer is blacklisted.
     */
    public function blacklisted(string $reason = 'Violation of rental terms'): static
    {
        return $this->state(fn (array $attributes) => [
            'is_blacklisted' => true,
            'blacklist_reason' => $reason,
        ]);
    }

    /**
     * Indicate that the customer is active (not blacklisted).
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_blacklisted' => false,
            'blacklist_reason' => null,
        ]);
    }

    /**
     * Indicate that the customer is a regular customer (not a member).
     */
    public function regular(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_member' => false,
            'member_discount' => null,
        ]);
    }
}