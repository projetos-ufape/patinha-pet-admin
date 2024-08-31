<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Employee;
use App\Models\Pet;
use App\Models\Service;
use App\Enums\AppointmentStatus;
use App\Models\Customer;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'customer_id' => Customer::factory(),
            'pet_id' => Pet::factory(),
            'service_id' => Service::factory(),
            'status' => fake()->randomElement(AppointmentStatus::values()),
            'start_time' => fake()->dateTime('Y-m-d H:i:s'),
            'end_time' => null, 
        ];
    }
}
