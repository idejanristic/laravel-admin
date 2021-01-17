<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = \App\Models\Permission::all();

        $admin = \App\Models\Role::whereName('Admin')->first();

        foreach($permissions as $permission)
        {
            DB::table('role_permission')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permission->id,
            ]);
        }

        $editor = \App\Models\Role::whereName('Editor')->first();

        foreach($permissions as $permission)
        {
            if(!\in_array($permission->name, ['edit_roles'])) {
                DB::table('role_permission')->insert([
                    'role_id' => $editor->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }

        $viewer = \App\Models\Role::whereName('Viewer')->first();

        $viewerRoles = [
            'view_users',
            'view_roles',
            'view_products',
            'view_orders',
        ];

        foreach($permissions as $permission)
        {
            if(!\in_array($permission->name, $viewerRoles)) {
                DB::table('role_permission')->insert([
                    'role_id' => $viewer->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }
    }
}
