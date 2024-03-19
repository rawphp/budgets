<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $code
 * @property string $name
 * @property string $symbol
 */
class Currency extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $primaryKey = 'code';

    const CREATED_AT = null;
    const UPDATED_AT = null;

    protected $fillable = [
        'code',
        'name',
        'symbol',
    ];
}
