<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Tom Kaczocha',
            'email' => 'tomkaczocha@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => Carbon::now(),
            'currency_code' => 'AUD',
        ]);
    }
}
