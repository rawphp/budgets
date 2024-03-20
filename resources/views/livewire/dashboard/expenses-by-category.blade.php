<?php

use App\Enum\ExpenseType;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state};

$needs = 0;
$wants = 0;
$saving = 0;

$expenses = Auth::user()->expenses;

/** @var Expense $expense */
foreach ($expenses as $expense) {
    switch ($expense->category->value) {
        case ExpenseType::Need->value:
            $needs += $expense->amount;
            break;
        case ExpenseType::Want->value:
            $wants += $expense->amount;
            break;
        case ExpenseType::SavingDebt->value:
            $saving += $expense->amount;
            break;
        default:
            break;
    }
}

state([
    'labels' => [ExpenseType::Need->value, ExpenseType::Want->value, 'Saving/Debt'],
    'expenses' => [$needs, $wants, $saving],
    'locale' => app()->getLocale(),
    'totalExpenses' => $needs + $wants + $saving,
]);
?>
@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

<div>
    <x-card title="Expenses by Category">
        <div>
            <canvas id="expenses-by-category-chart"></canvas>
        </div>
    </x-card>
</div>

@script
<script>
    const ctx = document.getElementById('expenses-by-category-chart');
    const data = $wire.expenses;
    const labels = $wire.labels;
    const locale = $wire.locale;
    const totalExpenses = $wire.totalExpenses;

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels,
            datasets: [{
                data,
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            let label = context.dataset.label || '';

                            if (label) {
                                label += ': ';
                            }

                            if (context.parsed !== null) {
                                label += new Intl.NumberFormat(
                                    locale,
                                    { style: 'percent'}
                                ).format((context.parsed / totalExpenses));
                            }

                            return label;
                        }
                    }
                }
            }
        }
    });
</script>
@endscript
