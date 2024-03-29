<?php

namespace App\Livewire\Forms;

use App\Models\Expense;
use App\Models\Income;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Form;

class TransactionForm extends Form
{
    public const INCOME = 'income';
    public const EXPENSE = 'expense';

    public ?Transaction $transaction = null;
    #[Validate('required|date')]
    public $createdAt;
    #[Validate('required|numeric')]
    public $amount = '';
    #[Validate('required|string|min:3')]
    public $description = '';
    #[Validate('required')]
    public Income|Expense|null $transactionable = null;
    public array $types = [];

    public function __construct(protected Component $component,
                                protected           $propertyName)
    {
        parent::__construct($component, $this->propertyName);

        $this->createdAt = Carbon::now()->setTimezone('Australia/Brisbane');

        $this->loadUserDefinedIncomeAndExpenses();
    }

    public function createTransaction(): void
    {
        $this->validate();

        Auth::user()->transactions()->create([
            'created_at' => $this->createdAt,
            'transactionable_id' => $this->transactionable->id,
            'transactionable_type' => $this->transactionable::class,
            'description' => $this->description,
            'amount' => $this->amount,
        ]);

        redirect(route('transaction.index'));
    }

    public function updateTransaction(): void
    {
        $this->validate();

        $transaction = Auth::user()
            ->transactions()
            ->where('id', $this->transaction->id)
            ->first();

        $transaction->update([
            'created_at' => $this->createdAt,
            'transactionable_id' => $this->transactionable->id,
            'transactionable_type' => $this->transactionable::class,
            'description' => $this->description,
            'amount' => $this->amount,
        ]);

        redirect(route('transaction.index'));
    }

    public function updatedSelectedBudgetItem(string|null $budgetItem): void
    {
        if (is_null($budgetItem)) {
            return;
        }

        [$budgetItemId, $type] = explode('-', $budgetItem);

        if ($type === self::INCOME) {
            $this->transactionable = Income::find($budgetItemId);
        } else if ($type === self::EXPENSE) {
            $this->transactionable = Expense::find($budgetItemId);
        }

        $this->amount = $this->transactionable->amount;
        $this->description = $this->transactionable->description;
    }

    public function loadUserDefinedIncomeAndExpenses(): void
    {
        $user = Auth::user();

        $incomes = Income::query()
            ->where('user_id', $user->id)
            ->get()
            ->map(fn($income) => ['value' => $income->id . '-' . self::INCOME, 'label' => $income->description . ' (Income)'])
            ->all();
        $expenses = Expense::query()
            ->where('user_id', $user->id)
            ->get()
            ->map(fn($expense) => ['value' => $expense->id . '-' . self::EXPENSE, 'label' => $expense->description . ' (Expense)'])
            ->all();

        $this->types = array_merge($incomes, $expenses);
    }
}
