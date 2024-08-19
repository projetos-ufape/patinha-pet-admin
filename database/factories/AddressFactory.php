<?php

namespace Database\Factories;

use App\Enums\AddressState;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'state' => fake()->randomElement(AddressState::values()),
            'city' => substr(fake()->city(), 0, 50),
            'district' => substr(fake()->streetAddress(), 0, 50),
            'street' => substr(fake()->streetAddress(), 0, 50),
            'number' => substr(fake()->buildingNumber(), 0, 50),
            'complement' => substr(fake()->sentence(), 0, 50),
            'cep' => fake()->numerify('########'),
        ];
    }
}
