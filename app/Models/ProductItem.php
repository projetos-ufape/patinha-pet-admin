<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductItem extends Model
{
    use HasFactory;

	protected $fillable = [
        'sale_id',
        'product_id',
		'quantity',
    ];

	public function saleItem(): BelongsTo
    {
        return $this->belongsTo(SaleItem::class);
    }

	public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
