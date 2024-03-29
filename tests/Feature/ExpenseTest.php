<?php

use App\Enum\ExpenseType;
use App\Models\Expense;
use App\Models\User;
use Livewire\Volt\Volt;

test('viewing expenses is not permitted without logging in', function () {
    $response = $this->get('/expenses');

    $response->assertStatus(302);
    $response->assertSee('Redirecting to');
    $response->assertSee('/login');
});

test('list expenses page', function () {
    $user = User::factory()->create();
    Expense::factory()->create([
        'user_id' => $user->id,
        'amount' => 1501
    ]);
    $this->actingAs($user);
    $response = $this->get('/expenses');

    $response->assertStatus(200);
    $response->assertSee('Expenses');
    $response->assertSee('A$1,501.00');
});

test('delete expense on list page', function () {
    $user = User::factory()->create();
    $expense = Expense::factory()->create([
        'user_id' => $user->id,
        'amount' => '12398',
    ]);
    $this->actingAs($user);

    Volt::test('expense.list')
        ->assertSee('$12,398.00')
        ->call('delete', $expense->id)
        ->assertRedirectToRoute('expense.index');
});

test('see create expense form', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/expenses/create');
    $response->assertSee('Name');
    $response->assertSee('Category');
    $response->assertSee('Amount');
    $response->assertSee('Create Expense');
});

test('create expense', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    Volt::test('expense.create')
        ->assertSee('Create Expense')
        ->set('description', 'Test Expense')
        ->set('amount', '1000')
        ->set('category', ExpenseType::Need->value)
        ->call('create')
        ->assertRedirectToRoute('expense.index');
});

test('update expense', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    $expense = Expense::factory()->create([
        'user_id' => $user->id,
        'category' => ExpenseType::Need->value,
    ]);

    Volt::test('expense.edit', ['expense' => $expense])
        ->set('category', ExpenseType::Want->value)
        ->call('update')
        ->assertRedirectToRoute('expense.index')
        ->assertSee(ExpenseType::Want->value);
});
