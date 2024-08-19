<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                'name' => 'Test App',
                'email' => 'test@app.com',
            ])
            ->customer()
            ->create([
                'phone_number' => '87981058105',
            ]);

        User::factory()->hasCustomer()->count(30)->create();
    }
}
