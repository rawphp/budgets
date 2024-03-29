<?php

use App\Livewire\Forms\TransactionForm;
use App\Models\Expense;
use App\Models\Income;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use WireUi\Traits\Actions;
use function Livewire\Volt\{state, rules, form, uses, updated};

form(TransactionForm::class);

state([
    'selectedBudgetItem' => null,
]);

updated([
    'selectedBudgetItem' => fn () => $this->form->updatedSelectedBudgetItem($this->selectedBudgetItem),
]);

$save = fn() => $this->form->createTransaction();
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
            option-label="label"
            option-value="value"
        />

        <x-input wire:model="form.description" label="Description"/>
        <x-input wire:model="form.amount" label="Amount" icon="currency-dollar"/>

        <div class="pt-3">
            <x-button type="submit" primary>Create Transaction</x-button>
        </div>
    </form>
</div>
