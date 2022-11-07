<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::findOrCreate('employee');
        Role::findOrCreate('admin');
        Role::findOrCreate('super-admin');
        Permission::findOrCreate('dashboard');
        Permission::findOrCreate('dashboard.view');
        // Permission for users
        Permission::findOrCreate('user.index');
        Permission::findOrCreate('user.create');
        Permission::findOrCreate('user.show');
        Permission::findOrCreate('user.edit');
        Permission::findOrCreate('user.delete');
        // Permission for roles
        Permission::findOrCreate('role.index');
        Permission::findOrCreate('role.create');
        Permission::findOrCreate('role.show');
        Permission::findOrCreate('role.edit');
        Permission::findOrCreate('role.delete');
        // Permission for permission
        Permission::findOrCreate('permission.index');
        Permission::findOrCreate('permission.create');
        Permission::findOrCreate('permission.show');
        Permission::findOrCreate('permission.edit');
        Permission::findOrCreate('permission.delete');
        // Permission for employee
        Permission::findOrCreate('employee.index');
        Permission::findOrCreate('employee.create');
        Permission::findOrCreate('employee.show');
        Permission::findOrCreate('employee.edit');
        Permission::findOrCreate('employee.delete');

        Permission::findOrCreate('setting.index');
        Permission::findOrCreate('setting.create');
        Permission::findOrCreate('setting.show');
        Permission::findOrCreate('setting.edit');
        Permission::findOrCreate('setting.delete');

        /*

        Permission::findOrCreate('.index');
        Permission::findOrCreate('.create');
        Permission::findOrCreate('.show');
        Permission::findOrCreate('.edit');
        Permission::findOrCreate('.delete');

        */

    }
}
