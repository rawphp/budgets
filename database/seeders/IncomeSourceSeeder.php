<?php

namespace Database\Seeders;

use App\Models\Income;
use App\Models\User;
use Illuminate\Database\Seeder;

class IncomeSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->map(function (User $user) {
            Income::factory()->create([
                'user_id' => $user->id,
            ]);
        });
    }
}
