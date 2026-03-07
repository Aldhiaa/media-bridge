<?php

namespace App\Enums;

enum Role: string
{
    case Admin = 'admin';
    case Company = 'company';
    case Agency = 'agency';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'مدير',
            self::Company => 'شركة',
            self::Agency => 'وكالة',
        };
    }
}
