<?php

use App\Models\Income;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use function Livewire\Volt\{uses, state, rules, mount};

uses(AuthorizesRequests::class);
rules(Income::getRules());
state([
    'id' => null,
    'cycles' => Income::getCycles(),
    'description' => '',
    'amount' => '',
    'cycle' => '',
]);
mount(function (Income $income) {
//    $this->authorize('update', $income);
    $this->fill($income);
});

$update = function () {
    $this->validate();

    $income = Income::find($this->id);

    $income->update([
        'description' => $this->description,
        'amount' => $this->amount,
        'cycle' => $this->cycle,
    ]);

    redirect(route('income.index'));
};
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    <form wire:submit="update">
        <x-input wire:model="description" label="Source"/>
        <x-input wire:model="amount" label="Amount" icon="currency-dollar"/>
        <x-select label="Cycle" wire:model.defer="cycle" :options="$this->cycles"/>

        <div class="pt-3">

        </div>
        <x-button type="submit" primary>Save Income Source</x-button>
    </form>
</div>
