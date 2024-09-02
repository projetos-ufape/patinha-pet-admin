<?php

namespace App\Enums;

enum EmployeeType: string
{
    case ADMIN = 'admin';
    case BASIC = 'basic';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::BASIC => 'Regular',
        };
    }
}
