<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RoleSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $admin = Role::create([
            'name' => 'Admin',
            'icon' => 'fa fa-user-secret',
        ]);

        $permissions = Permission::pluck('id')->toArray();

        $admin->syncPermissions($permissions);

        Role::create([
            'name' => 'Office manager',
            'icon' => 'fa fa-users-cog',

        ]);

        Role::create([
            'name' => 'Sales manager',
            'icon' => 'fa fa-user-ninja',
        ]);
    }
}


