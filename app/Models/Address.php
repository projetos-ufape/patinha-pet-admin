<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'state',
        'city',
        'district',
		'street',
		'number',
		'complement',
		'cep',
		'user_id',
    ];

	public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
