<?php

use App\Models\User;

test('viewing income-sources is not permitted without logging in', function () {
    $response = $this->get('/income-sources');

    $response->assertStatus(302);
    $response->assertSee('Redirecting to');
    $response->assertSee('/login');
});

test('list income sources page', function () {
    $this->actingAs(User::factory()->create());
    $response = $this->get('/income-sources');

    $response->assertStatus(200);
    $response->assertSee('Income Sources');
    $response->assertSee('$2,000');
});
