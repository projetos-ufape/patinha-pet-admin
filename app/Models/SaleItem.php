<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SaleItem extends Model
{
    use HasFactory;

	protected $fillable = [
        'sale_id',
        'price',
    ];

	public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }

	public function productItem(): HasOne
    {
        return $this->hasOne(ProductItem::class);
    }

	public function appointmentItem(): HasOne
    {
        return $this->hasOne(AppointmentItem::class);
    }
}
