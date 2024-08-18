<?php

namespace App\Enums;

enum ProductCategory: string
{
    case Fashion = 'fashion';
    case Health = 'health';
    case Hygiene = 'hygiene';
    case Toy = 'toy';
    case Food = 'food';

    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }
}
