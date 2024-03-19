<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(database_path('seeders/currencies.json'));
        $data = json_decode($json, true);

        $done = [];

        foreach ($data as $row) {
            if (in_array($row['Code'], $done)) {
                continue;
            }

            $currency = Currency::create([
                'code' => $row['Code'],
                'name' => $row['Currency'],
                'symbol' => $row['Symbol'],
            ]);

            $done[] = $currency->code;
        }
    }
}
