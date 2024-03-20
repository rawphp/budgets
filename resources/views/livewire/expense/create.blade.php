<?php

use App\Enum\ExpenseType;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state};
use function Livewire\Volt\{rules};

state([
    'name' => '',
    'category' => null,
    'amount' => '',
    'categories' => [ExpenseType::Need->value, ExpenseType::Want->value, ExpenseType::SavingDebt->value]
]);
rules(Expense::getRules());

$create = function () {
    $this->validate();

    Auth::user()->expenses()->create([
        'name' => $this->name,
        'category' => $this->category,
        'amount' => $this->amount,
    ]);

    redirect(route('expense.index'));
};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    <form wire:submit="create">
        <x-input wire:model="name" label="Name"/>
        <x-input wire:model="amount" label="Amount" icon="currency-dollar"/>
        <x-select label="Category" wire:model.defer="category" :options="$this->categories"/>

        <div class="pt-3">

        </div>
        <x-button type="submit" primary>Create Expense</x-button>
    </form>
</div>
