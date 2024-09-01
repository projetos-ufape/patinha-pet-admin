<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'brand',
        'category',
        'price',
        'quantity',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class);
    }

	public function productItems(): HasMany
    {
        return $this->hasMany(ProductItem::class);
    }
}
