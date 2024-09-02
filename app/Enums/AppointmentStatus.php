<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Completed = 'completed';
    case Canceled = 'canceled';

    public static function values(): array
    {
        return array_map(fn ($case) => $case->value, self::cases());
    }
}
