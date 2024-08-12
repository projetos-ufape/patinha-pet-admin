<?php

namespace Database\Factories;

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
            'name' => fake()->firstName,
            'gender' => fake()->randomElement(['female', 'male']),
            'specie' => fake()->randomElement(['cat', 'dog']),
            'race' => fake()->word,
            'height' => fake()->randomFloat(2, 0.5, 1.5),
            'weight' => fake()->randomFloat(2, 1.0, 10.0),
            'castrated' => fake()->boolean(),
            'birth' => fake()->date,
        ];
    }
}
