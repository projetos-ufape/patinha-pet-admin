<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class Employee extends Model
{
    use HasFactory, HasRoles;

    protected $fillable = [
        'user_id',
        'admission_date',
        'salary',
    ];

    protected function casts(): array
    {
        return [
            'admission_date' => 'date',
            'salary' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
