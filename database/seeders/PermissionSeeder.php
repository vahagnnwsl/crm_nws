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

        Permission::create([
            'name' => 'order_create_update_delete'
        ]);

        Permission::create([
            'name' => 'order_update_status'
        ]);

        Permission::create([
            'name' => 'view_order_and_orders_list'
        ]);

        Permission::create([
            'name' => 'order_person_create_update_delete'
        ]);

        Permission::create([
            'name' => 'view_order_person_and_order_people_list'
        ]);

        Permission::create([
            'name' => 'agent_create_update_delete'
        ]);

        Permission::create([
            'name' => 'view_agent_and_agents_list'
        ]);

        Permission::create([
            'name' => 'developer_create_update_delete'
        ]);

        Permission::create([
            'name' => 'view_developer_and_developers_list'
        ]);
    }
}


