<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Test Appointment History',
            'email' => 'test@appointment.com',
        ]);

        $customer = Customer::factory()->create([
            'user_id' => $user->id,
            'phone_number' => '87981058110',
        ]);

        Appointment::factory()->count(10)->create([
            'customer_id' => $customer->id,
        ]);

        $user2 = User::factory()->create([
            'name' => 'Test Appointment 2',
            'email' => 'test2@appointment.com',
        ]);

        $customer2 = Customer::factory()->create([
            'user_id' => $user2->id,
            'phone_number' => '87981058112',
        ]);

        Appointment::factory()->count(10)->create([
            'customer_id' => $customer2->id,
        ]);
    }
}
