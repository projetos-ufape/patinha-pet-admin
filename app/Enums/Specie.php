<?php

namespace App\Enums;

enum Specie: string {
  case CAT = 'cat';
  case DOG = 'dog';

  public static function values(): array
  {
    return array_map(fn($case) => $case->value, self::cases());
  }
}