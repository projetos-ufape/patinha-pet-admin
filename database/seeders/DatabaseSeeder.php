<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,
            ProductSeeder::class,
            AppointmentSeeder::class,
            PermissionsSeeder::class,
            RolesSeeder::class,
        ]);

        $employee = User::factory()
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ])
            ->employee()
            ->create([
                'admission_date' => date('Y-m-d'),
                'salary' => rand(1000, 5000),
            ]);

        $employee->assignRole('admin');
    }
}
