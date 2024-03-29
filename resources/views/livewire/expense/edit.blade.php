<?php

use App\Enum\ExpenseType;
use App\Models\Expense;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use function Livewire\Volt\{uses, state, rules, mount};

uses(AuthorizesRequests::class);
rules(Expense::getRules());
state([
    'id' => null,
    'categories' => [ExpenseType::Need->value, ExpenseType::Want->value, ExpenseType::SavingDebt->value],
    'description' => '',
    'category' => null,
    'amount' => ''
]);
mount(function (Expense $expense) {
    $this->fill($expense);
});

$update = function () {
    $this->validate();

    $expense = Expense::find($this->id);

    $expense->update([
        'description' => $this->description,
        'category' => $this->category,
        'amount' => $this->amount,
    ]);

    redirect(route('expense.index'));
};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    <form wire:submit="update">
        <x-input wire:model="description" label="Name"/>
        <x-input wire:model="amount" label="Amount" icon="currency-dollar"/>
        <x-select label="Category" wire:model.defer="category" :options="$this->categories"/>

        <div class="pt-3">

        </div>
        <x-button type="submit" primary>Save Expense</x-button>
    </form>
</div>
