<?php

namespace App\Enums;

enum UserStatus: string
{
    case Active = 'active';
    case Suspended = 'suspended';
    case Pending = 'pending';

    public function label(): string
    {
        return match ($this) {
            self::Active => 'نشط',
            self::Suspended => 'موقوف',
            self::Pending => 'قيد المراجعة',
        };
    }
}
