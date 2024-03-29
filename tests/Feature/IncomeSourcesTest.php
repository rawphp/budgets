<?php

use App\Models\Income;
use App\Models\User;
use Livewire\Volt\Volt;

test('viewing income-sources is not permitted without logging in', function () {
    $response = $this->get('/incomes');

    $response->assertStatus(302);
    $response->assertSee('Redirecting to');
    $response->assertSee('/login');
});

test('list income sources page', function () {
    $user = User::factory()->create();
    Income::factory()->create([
        'user_id' => $user->id,
    ]);
    $this->actingAs($user);
    $response = $this->get('/incomes');

    $response->assertStatus(200);
    $response->assertSee('Income Sources');
    $response->assertSee('$1,800.00');
});

test('delete income source on list page', function () {
    $user = User::factory()->create();
    $income = Income::factory()->create([
        'user_id' => $user->id,
        'amount' => '12398',
    ]);
    $this->actingAs($user);

    Volt::test('income.list')
        ->assertSee('$12,398.00')
        ->call('delete', $income->id)
        ->assertRedirectToRoute('income.index');
});

test('see create income source form', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/incomes/create');
    $response->assertSee('Source');
    $response->assertSee('Cycle');
    $response->assertSee('Amount');
    $response->assertSee('Create Income Source');
});

test('create income source', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Volt::test('income.create')
        ->assertSee('Create Income Source')
        ->set('description', 'Test Source')
        ->set('amount', '1000')
        ->set('cycle', 'weekly')
        ->call('create')
        ->assertRedirectToRoute('income.index');
});

test('update income source', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $income = Income::factory()->create([
        'user_id' => $user->id,
        'cycle' => 'weekly',
    ]);

    Volt::test('income.edit', ['income' => $income])
        ->set('cycle', 'annually')
        ->call('update')
        ->assertRedirectToRoute('income.index')
        ->assertSee('annually');
});
