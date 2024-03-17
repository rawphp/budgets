<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $user_id
 * @property string $source
 * @property float $amount
 * @property string $cycle
 */
class Income extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'source',
        'amount',
        'cycle',
    ];

    protected $casts = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): MorphMany
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    public static function getRules(): array
    {
        return [
            'source' => 'required|string',
            'amount' => 'required|numeric',
            'cycle' => 'required|string',
        ];
    }

    public static function getCycles(): array
    {
        return ['once', 'weekly', 'fortnightly', 'monthly', 'quarterly', 'annually'];
    }
}
