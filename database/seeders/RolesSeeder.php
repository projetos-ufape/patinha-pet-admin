<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminEmployee = Role::firstOrCreate(['name' => 'admin']);
        $basicEmployee = Role::firstOrCreate(['name' => 'basic']);

        $permissions = Permission::all();

        $adminEmployee->syncPermissions($permissions);

        $basicEmployee->givePermissionTo([
            'manage customers',
            'manage pets',
            'manage sales',
            'associate services_sales',
            'manage payments',
        ]);
    }
}
