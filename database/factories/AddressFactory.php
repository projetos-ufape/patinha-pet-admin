<?php

namespace Database\Factories;

use App\Enums\AddressState;
use App\Models\User;
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
			'city' => fake()->city(),
			'district' => fake()->streetAddress(),
			'street' => fake()->streetAddress(),
			'number' => fake()->buildingNumber(),
			'complement' => fake()->sentence(),
			'cep' => fake()->postcode(),
			'user_id' => User::factory(),
        ];
    }
}
