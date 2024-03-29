<?php

use App\Models\Transaction;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use function Livewire\Volt\{state, uses};

uses(AuthorizesRequests::class);
state([
    'transactions' => Auth::user()->transactions->sortByDesc('created_at'),
]);

$delete = function (int $id) {
    $transaction = Transaction::find($id);
    $this->authorize('delete', $transaction);
    $transaction->delete();

    redirect(route('transaction.index'));
}
?>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mx-2">
    @if ($transactions->isEmpty())
        <div class="text-center">
            <p class="text-xl font-bold">No transactions yet</p>
            <p class="text-sm">Let's create your first transaction.</p>
            <x-button primary icon-right="plus" class="mt-6" href="{{ route('transaction.create') }}" wire:navigate>Create
                Transaction
            </x-button>
        </div>
    @else
        <div>
            <x-button primary icon-right="plus" class="mt-6" href="{{ route('transaction.create') }}" wire:navigate>Create
                Transaction
            </x-button>
        </div>
        @foreach ($transactions as $transaction)
            <x-card class="mb-3" title="{{ $transaction->description }}">
                <div>Date: {{ $transaction->created_at->format('d-M-Y') }}</div>
                <div>
                    {{ Number::currency($transaction->amount, in: $transaction->user->currency_code, locale: app()->getLocale()) }} @if(!is_null($transaction->cycle))
                        {{ $transaction->cycle }}
                    @endif
                </div>
                <x-slot name="footer">
                    <div class="flex justify-between items-center">
                        <x-button.circle icon="pencil" flat href="{{ route('transaction.edit', $transaction) }}" wire:navigate/>
                        <x-button.circle icon="trash" flat negative
                                         wire:confirm="Are you sure you want to delete this transaction?"
                                         wire:click="delete('{{ $transaction->id }}')"/>
                    </div>
                </x-slot>
            </x-card>
        @endforeach
    @endif
</div>
