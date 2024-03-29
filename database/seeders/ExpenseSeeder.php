<?php

namespace Database\Seeders;

use App\Enum\ExpenseType;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->map(function (User $user) {
            Expense::factory()->create([
                'user_id' => $user->id,
                'description' => 'Mortgage',
                'category' => ExpenseType::Need,
                'amount' => 765.00,
            ]);
            Expense::factory()->count(5)->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
