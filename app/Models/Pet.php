<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enum\Gender;
use App\Enum\Specie;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'gender',
        'specie',
        'race',
        'height', 
        'weight',
        'birth'
    ];

    protected $casts = [
        'gender' => Gender::class,
        'specie' => Specie::class,
    ];
}
