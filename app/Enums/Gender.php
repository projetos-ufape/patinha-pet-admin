<?php

namespace App\Enums;

enum Gender: string {
  case FEMALE = 'female';
  case MALE = 'male';

  public static function values(): array
  {
    return array_map(fn($case) => $case->value, self::cases());
  }
}