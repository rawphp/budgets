<?php

use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state};
use function Livewire\Volt\{rules};

state([
    'source' => '',
    'amount' => '',
    'cycles' => Income::getCycles(),
    'cycle' => null,
]);
rules(Income::getRules());

$create = function () {
    $this->validate();

    Auth::user()->incomes()->create([
        'source' => $this->source,
        'amount' => $this->amount,
        'cycle' => $this->cycle,
    ]);

    redirect(route('income.index'));
};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    <form wire:submit="create">
        <x-input wire:model="source" label="Source"/>
        <x-input wire:model="amount" label="Amount" icon="currency-dollar"/>
        <x-select label="Cycle" wire:model.defer="cycle" :options="$this->cycles"/>

        <div class="pt-3">

        </div>
        <x-button type="submit" primary>Create Income Source</x-button>
    </form>
</div>
