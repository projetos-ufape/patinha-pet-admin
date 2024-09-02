<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Stock>
 */
class StockFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->numberBetween(0, 100),
            'quantity' => $this->faker->numberBetween(-10, 100),
            'justification' => $this->faker->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-1 day'),
        ];
    }
}
