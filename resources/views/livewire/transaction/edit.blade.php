<?php

use App\Enum\ExpenseType;
use App\Livewire\Forms\TransactionForm;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use function Livewire\Volt\{uses, updated, state, rules, mount, form};

uses(AuthorizesRequests::class);

rules(Expense::getRules());
form(TransactionForm::class);
mount(function (Transaction $transaction) {
    $this->form->transaction = $transaction;
    $this->form->createdAt = $transaction->created_at;
    $this->form->transactionable = $transaction->transactionable;
    $this->form->amount = $transaction->amount;
    $this->form->description = $transaction->description;
    $this->selectedBudgetItem = $transaction->getBudgetItemKey();
});
state([
    'selectedBudgetItem' => null,
]);

updated([
    'selectedBudgetItem' => function () {
        $this->form->updatedSelectedBudgetItem($this->selectedBudgetItem);
    }
]);
$save = fn() => $this->form->updateTransaction();
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    <form wire:submit="save">
        <x-datetime-picker
            label="Date"
            required="true"
            placeholder="Date"
            wire:model.defer="form.createdAt"
            without-time="true"
            timezone="Australia/Brisbane"
            display-format="DD/MM/YYYY"
        />
        <x-select
            label="Income/Expense"
            wire:model.live="selectedBudgetItem"
            :options="$this->form->types"
            selected=""
            option-label="label"
            option-value="value"
        />

        <x-input wire:model="form.description" label="Description"/>
        <x-input wire:model="form.amount" label="Amount" icon="currency-dollar"/>

        <div class="pt-3">
            <x-button type="submit" primary>Update Transaction</x-button>
        </div>
    </form>
</div>
