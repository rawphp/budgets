<?php

namespace Database\Factories;

use App\Enum\ExpenseType;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Expense>
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
        return [
            'user_id' => User::factory(),
            'description' => fake()->slug(),
            'category' => fake()->randomElement([ExpenseType::Need, ExpenseType::Want, ExpenseType::SavingDebt]),
            'amount' => fake()->numberBetween(10, 1000),
        ];
    }
}
