<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Permission::create([
            'name' => 'view_permissions_list'
        ]);

        Permission::create([
            'name' => 'view_roles_list'
        ]);

        Permission::create([
            'name' => 'give_permission_to_role'
        ]);

        Permission::create([
            'name' => 'view_users_list'
        ]);

        Permission::create([
            'name' => 'view_user'
        ]);

        Permission::create([
            'name' => 'edit_user'
        ]);

        Permission::create([
            'name' => 'delete_user'
        ]);

        Permission::create([
            'name' => 'invite_user'
        ]);

        Permission::create([
            'name' => 'login_via_anther_user'
        ]);

        Permission::create([
            'name' => 'role_create_update_delete'
        ]);
    }
}


