<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cep',
        'street',
        'number',
        'complement',
        'district',
        'state',
        'city',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
