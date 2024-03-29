<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'created_at',
        'description',
        'amount',
        'transactionable_id',
        'transactionable_type',
    ];

    // Polymorphic relationship to either Income or Expense
    public function transactionable(): MorphTo
    {
        return $this->morphTo();
    }

    // Relationship with User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100
        );
    }

    public function getBudgetItemKey()
    {
        $type = null;

        if ($this->transactionable::class === Income::class)
        {
            $type = 'income';
        }
        if ($this->transactionable::class === Expense::class) {
            $type = 'expense';
        }

        return sprintf("%d-%s", $this->transactionable->id, $type);
    }

    public static function transactionTypes(): array
    {
        return [
            [
                'label' => 'Income',
                'value' => 'income',
            ],
            [
                'label' => 'Expense',
                'value' => 'expense',
            ],
        ];
    }

    public static function getRules(): array
    {
        return [
            'transactionable_type' => 'required|string',
            'transactionable_id' => 'required|numeric',
            'description' => 'string',
            'amount' => 'required|numeric',
            'createdAt' => 'required|date',
        ];
    }
}
