<?php

namespace App\Enum;

enum ExpenseType: string
{
    case Need = 'Need';
    case Want = 'Want';
    case SavingDebt = 'SavingDebt';
}
