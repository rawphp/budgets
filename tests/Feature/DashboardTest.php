<?php

use App\Models\Currency;
use App\Models\User;
use Livewire\Volt\Volt;

test('dashboard shows total income graph', function () {
    Currency::factory()->create(['code' => 'NZD']);
    $this->actingAs(User::factory()->create([
        'currency_code' => 'NZD',
    ]));
    $response = $this->get('/dashboard');
    $response->assertStatus(200);

    Volt::test('dashboard.total-income')
        ->assertHasNoErrors()
        ->assertNoRedirect();
});
