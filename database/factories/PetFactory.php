<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'name' => fake()->firstName,
            'gender' => fake()->randomElement(['female', 'male']),
            'specie' => fake()->randomElement(['cat', 'dog']),
            'race' => fake()->word,
            'height' => (float) fake()->randomFloat(2, 0.5, 1.5),
            'weight' => (float) fake()->randomFloat(2, 1.0, 10.0),
            'castrated' => fake()->boolean(),
            'birth' => fake()->date,
        ];
    }
}
