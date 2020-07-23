<?php

use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Create Users Permissions
        Permission::create(['name' => 'add-users']);
        Permission::create(['name' => 'edit-users']);
        Permission::create(['name' => 'view-users']);
        Permission::create(['name' => 'delete-users']);

//        Create Roles Permissions
        Permission::create(['name' => 'add-roles']);
        Permission::create(['name' => 'edit-roles']);
        Permission::create(['name' => 'view-roles']);
        Permission::create(['name' => 'delete-roles']);

//        Create Urls Permissions
        Permission::create(['name' => 'add-urls']);
        Permission::create(['name' => 'edit-urls']);
        Permission::create(['name' => 'view-urls']);
        Permission::create(['name' => 'delete-urls']);


//        Create Posts Permissions
        Permission::create(['name' => 'add-posts']);
        Permission::create(['name' => 'edit-posts']);
        Permission::create(['name' => 'view-posts']);
        Permission::create(['name' => 'delete-posts']);
    }
}
