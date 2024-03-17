<?php

use App\Models\Income;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use function Livewire\Volt\{state, uses};

uses(AuthorizesRequests::class);
state([
    'incomes' => Auth::user()->incomes,
]);

$delete = function (int $id) {
    $income = Income::find($id);
    $this->authorize('delete', $income);
    $income->delete();

    redirect(route('income.index'));
}
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    @if ($incomes->isEmpty())
        <div class="text-center">
            <p class="text-xl font-bold">No income sources yet</p>
            <p class="text-sm">Let's create your first income source.</p>
            <x-button primary icon-right="plus" class="mt-6" href="{{ route('income.create') }}" wire:navigate>Create
                Income Source
            </x-button>
        </div>
    @else
        <div>
            <x-button primary icon-right="plus" class="mt-6" href="{{ route('income.create') }}" wire:navigate>Create
                Income Source
            </x-button>
        </div>
        @foreach ($incomes as $income)
            <x-card class="mb-3" title="{{ $income->source }}">
                <div>
                    {{ Number::currency($income->amount, in: 'AUD', locale: 'aud') }} @if(!is_null($income->cycle))
                        {{ $income->cycle }}
                    @endif
                </div>
                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <x-button.circle icon="pencil" flat href="{{ route('income.edit', $income) }}" wire:navigate />
                        <x-button.circle icon="trash" flat negative wire:confirm="Are you sure you want to delete this income source?" wire:click="delete('{{ $income->id }}')" />
                    </div>
                </x-slot>
            </x-card>
        @endforeach
    @endif
</div>
