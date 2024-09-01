<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppointmentItem extends Model
{
    use HasFactory;

	protected $fillable = [
        'sale_id',
        // 'appointment_id',
    ];

	public function saleItem(): BelongsTo
    {
        return $this->belongsTo(SaleItem::class);
    }

	// public function appointment(): BelongsTo
    // {
    //     return $this->belongsTo(Appointment::class);
    // }
}
