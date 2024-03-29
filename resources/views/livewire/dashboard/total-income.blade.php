<?php

use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\{state};

state([
    'labels' => ['October', 'November', 'December', 'January', 'February', 'March'],
    'monthlyIncome' => [10000, 10000, 10000, 12500, 10000, 10000],
    'currency' => Auth::user()->currency_code,
    'locale' => app()->getLocale(),
]);
?>
@assets
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endassets

<div>
    <x-card title="Total Monthly Income">
        <div>
            <canvas id="total-monthly-income-chart"></canvas>
        </div>
    </x-card>
</div>

@script
<script>
    const ctx = document.getElementById('total-monthly-income-chart');
    const data = $wire.monthlyIncome;
    const labels = $wire.labels;
    const currency = $wire.currency;
    const locale = $wire.locale;

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Total Monthly Income',
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

                            if (context.parsed.y !== null) {
                                label += new Intl.NumberFormat(
                                    locale,
                                    {
                                        style: 'currency',
                                        currency: currency
                                    }
                                ).format(context.parsed.y);
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
