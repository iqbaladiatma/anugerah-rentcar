<?php

namespace Database\Factories;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            Expense::CATEGORY_SALARY,
            Expense::CATEGORY_UTILITIES,
            Expense::CATEGORY_SUPPLIES,
            Expense::CATEGORY_MARKETING,
            Expense::CATEGORY_OTHER,
        ];

        return [
            'category' => $this->faker->randomElement($categories),
            'description' => $this->faker->sentence(4),
            'amount' => $this->faker->randomFloat(2, 50000, 5000000), // 50k to 5M IDR
            'expense_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'receipt_photo' => $this->faker->boolean(30) ? 'expenses/receipts/sample-receipt.jpg' : null,
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the expense is for salary.
     */
    public function salary(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => Expense::CATEGORY_SALARY,
            'description' => $this->faker->randomElement([
                'Monthly salary payment',
                'Overtime payment',
                'Bonus payment',
                'Staff allowance',
            ]),
            'amount' => $this->faker->randomFloat(2, 3000000, 15000000), // 3M to 15M IDR
        ]);
    }

    /**
     * Indicate that the expense is for utilities.
     */
    public function utilities(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => Expense::CATEGORY_UTILITIES,
            'description' => $this->faker->randomElement([
                'Electricity bill',
                'Water bill',
                'Internet bill',
                'Phone bill',
                'Gas bill',
            ]),
            'amount' => $this->faker->randomFloat(2, 100000, 2000000), // 100k to 2M IDR
        ]);
    }

    /**
     * Indicate that the expense is for supplies.
     */
    public function supplies(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => Expense::CATEGORY_SUPPLIES,
            'description' => $this->faker->randomElement([
                'Office supplies',
                'Cleaning supplies',
                'Vehicle maintenance supplies',
                'Computer equipment',
                'Stationery',
            ]),
            'amount' => $this->faker->randomFloat(2, 50000, 1000000), // 50k to 1M IDR
        ]);
    }

    /**
     * Indicate that the expense is for marketing.
     */
    public function marketing(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => Expense::CATEGORY_MARKETING,
            'description' => $this->faker->randomElement([
                'Social media advertising',
                'Print advertising',
                'Website maintenance',
                'Marketing materials',
                'Promotional events',
            ]),
            'amount' => $this->faker->randomFloat(2, 200000, 3000000), // 200k to 3M IDR
        ]);
    }

    /**
     * Indicate that the expense is for other category.
     */
    public function other(): static
    {
        return $this->state(fn (array $attributes) => [
            'category' => Expense::CATEGORY_OTHER,
            'description' => $this->faker->randomElement([
                'Miscellaneous expense',
                'Legal fees',
                'Insurance payment',
                'Bank charges',
                'Training costs',
            ]),
            'amount' => $this->faker->randomFloat(2, 100000, 2000000), // 100k to 2M IDR
        ]);
    }

    /**
     * Indicate that the expense has a receipt photo.
     */
    public function withReceipt(): static
    {
        return $this->state(fn (array $attributes) => [
            'receipt_photo' => 'expenses/receipts/receipt-' . $this->faker->uuid() . '.jpg',
        ]);
    }

    /**
     * Indicate that the expense is from this month.
     */
    public function thisMonth(): static
    {
        return $this->state(fn (array $attributes) => [
            'expense_date' => $this->faker->dateTimeBetween('first day of this month', 'now'),
        ]);
    }

    /**
     * Indicate that the expense is from last month.
     */
    public function lastMonth(): static
    {
        return $this->state(fn (array $attributes) => [
            'expense_date' => $this->faker->dateTimeBetween('first day of last month', 'last day of last month'),
        ]);
    }
}