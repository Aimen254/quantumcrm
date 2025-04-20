<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $permissions = ['create user', 'create contact', 'create admin'];

        // foreach ($permissions as $permission) {
        //     Permission::firstOrCreate(['name' => $permission]);
        // }
        if (!Role::where('name', 'Contact')->exists()) {
            Role::create(['name' => 'Contact']);
        }
        // $admin = Role::firstOrCreate(['name' => 'Admin']);
        // $owner = Role::firstOrCreate(['name' => 'Owner']);
        // $SalesPerson = Role::firstOrCreate(['name' => 'Sales Person']);
        // $Contact = Role::firstOrCreate(['name' => 'Contact']);
        // $admin->givePermissionTo(['create user', 'create contact']);
        // $owner->givePermissionTo(Permission::all());
    }
}
