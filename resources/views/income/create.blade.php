<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Income Source') }}
        </h2>
    </x-slot>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-button icon="arrow-left" flat wire:navigate href="{{ route('income.index') }}" class="mb-2">All Income Sources</x-button>
            <livewire:income.create />
        </div>
    </div>
</x-app-layout>
