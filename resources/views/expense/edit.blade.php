<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Expense') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-button icon="arrow-left" flat wire:navigate href="{{ route('expense.index') }}" class="mb-2">All Expenses</x-button>
            <livewire:expense.edit :expense="$expense" />
        </div>
    </div>
</x-app-layout>
