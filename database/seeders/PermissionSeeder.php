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
            'name' => 'roles_edit_delete_update'
        ]);

        Permission::create([
            'name' => 'view_user_and_users_list'
        ]);

        Permission::create([
            'name' => 'user_edit_delete_update'
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


