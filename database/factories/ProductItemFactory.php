<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SaleItem;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductItem>
 */
class ProductItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			'sale_item_id' => SaleItem::factory(),
            'product_id' => Product::factory(),
			'quantity' => fake()->numberBetween(1, 10),
        ];
    }
}
