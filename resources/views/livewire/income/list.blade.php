<?php

use App\Models\Income;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use function Livewire\Volt\{state};

state([
    'incomes' => Income::where('user_id', Auth::id())->get(),
])

?>

<div>
    @foreach ($incomes as $income)
        <div>
            <div>{{ $income->source }}</div>
            <div>{{ Number::currency($income->amount, in: 'AUD', locale: 'aud') }}</div>
        </div>
    @endforeach
</div>
