<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\Gender;
use App\Enums\Specie;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'specie',
        'race',
        'castrated',
        'height', 
        'weight',
        'birth'
    ];

    protected $casts = [
        'gender' => Gender::class,
        'specie' => Specie::class,
    ];
}
