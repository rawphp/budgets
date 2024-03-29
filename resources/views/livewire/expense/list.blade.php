<?php

use App\Models\Expense;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use function Livewire\Volt\{state, uses};

uses(AuthorizesRequests::class);
state([
    'expenses' => Auth::user()->expenses,
]);

$delete = function (int $id) {
    $expense = Expense::find($id);
    $this->authorize('delete', $expense);
    $expense->delete();

    redirect(route('expense.index'));
}
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    @if ($expenses->isEmpty())
        <div class="text-center">
            <p class="text-xl font-bold">No expenses yet</p>
            <p class="text-sm">Let's create your first expense.</p>
            <x-button primary icon-right="plus" class="mt-6" href="{{ route('expense.create') }}" wire:navigate>Create
                Expense
            </x-button>
        </div>
    @else
        <div>
            <x-button primary icon-right="plus" class="mt-6" href="{{ route('expense.create') }}" wire:navigate>Create
                Expense
            </x-button>
        </div>
        @foreach ($expenses as $expense)
            <x-card class="mb-3" title="{{ $expense->description }}">
                <div>Type: {{ $expense->category->value }}</div>
                <div>
                    {{ Number::currency($expense->amount, in: $expense->user->currency_code, locale: app()->getLocale()) }} @if(!is_null($expense->cycle))
                        {{ $expense->cycle }}
                    @endif
                </div>
                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <x-button.circle icon="pencil" flat href="{{ route('expense.edit', $expense) }}" wire:navigate/>
                        <x-button.circle icon="trash" flat negative
                                         wire:confirm="Are you sure you want to delete this expense?"
                                         wire:click="delete('{{ $expense->id }}')"/>
                    </div>
                </x-slot>
            </x-card>
        @endforeach
    @endif
</div>
