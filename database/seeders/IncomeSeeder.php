<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\User;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->map(function (User $user) {
            Income::factory()->create([
                'user_id' => $user->id,
                'cycle' => 'weekly',
            ]);
            Income::factory()->create([
                'user_id' => $user->id,
                'source' => 'Bonus',
                'amount' => fake()->numberBetween(1000, 5000),
                'cycle' => 'once',
            ]);
        });
    }
}
