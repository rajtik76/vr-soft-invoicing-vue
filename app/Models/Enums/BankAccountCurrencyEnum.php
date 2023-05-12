<?php

namespace App\Models\Enums;

enum BankAccountCurrencyEnum: string
{
    case EUR = 'EUR';

    public function symbol(): string
    {
        return match ($this) {
            self::EUR => '€'
        };
    }
}
