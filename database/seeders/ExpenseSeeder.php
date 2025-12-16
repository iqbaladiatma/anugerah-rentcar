<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have at least one user to assign expenses to
        $users = User::all();
        if ($users->isEmpty()) {
            $users = User::factory(3)->create();
        }

        // Create expenses for the current year
        $currentYear = now()->year;
        
        // Create monthly expenses for each month of the current year
        for ($month = 1; $month <= 12; $month++) {
            $startDate = now()->setYear($currentYear)->setMonth($month)->startOfMonth();
            $endDate = now()->setYear($currentYear)->setMonth($month)->endOfMonth();
            
            // Skip future months
            if ($startDate->isFuture()) {
                continue;
            }
            
            // Create 5-15 expenses per month
            $expenseCount = rand(5, 15);
            
            for ($i = 0; $i < $expenseCount; $i++) {
                $category = collect([
                    'salary' => 2,      // Higher weight for salary
                    'utilities' => 3,   // Higher weight for utilities
                    'supplies' => 2,
                    'marketing' => 1,
                    'other' => 1,
                ])->flatMap(function ($weight, $category) {
                    return array_fill(0, $weight, $category);
                })->random();
                
                $expenseDate = $startDate->copy()->addDays(rand(0, $startDate->daysInMonth - 1));
                
                Expense::factory()
                    ->state([
                        'category' => $category,
                        'expense_date' => $expenseDate,
                        'created_by' => $users->random()->id,
                    ])
                    ->create();
            }
        }

        // Create some expenses for the previous year for comparison
        $previousYear = $currentYear - 1;
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = now()->setYear($previousYear)->setMonth($month)->startOfMonth();
            
            // Create 3-10 expenses per month for previous year
            $expenseCount = rand(3, 10);
            
            for ($i = 0; $i < $expenseCount; $i++) {
                $category = collect([
                    'salary' => 2,
                    'utilities' => 3,
                    'supplies' => 2,
                    'marketing' => 1,
                    'other' => 1,
                ])->flatMap(function ($weight, $category) {
                    return array_fill(0, $weight, $category);
                })->random();
                
                $expenseDate = $startDate->copy()->addDays(rand(0, $startDate->daysInMonth - 1));
                
                Expense::factory()
                    ->state([
                        'category' => $category,
                        'expense_date' => $expenseDate,
                        'created_by' => $users->random()->id,
                    ])
                    ->create();
            }
        }

        $this->command->info('Created expenses for current and previous year with realistic distribution.');
    }
}