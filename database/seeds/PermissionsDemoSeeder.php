<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use App\Models\Admin;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //     'role-list',
        //    'role-create',
        //    'role-edit',
        //    'role-delete',
        // create permissions
        Permission::create(['name' => 'edit-user']);
        Permission::create(['name' => 'delete-user']);
        Permission::create(['name' => 'publish-user']);
        Permission::create(['name' => 'unpublish-user']);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => 'writers']);
        $role1->givePermissionTo('edit-user');
        $role1->givePermissionTo('delete-user');

        $role2 = Role::create(['name' => 'admins']);
        $role2->givePermissionTo('publish-user');
        $role2->givePermissionTo('unpublish-user');

        $role3 = Role::create(['name' => 'super-admins']);
        // gets all permissions via Gate::before rule; see AuthServiceProvider

        // create demo users
        $user = Admin::create([
            'name' => 'Example User',
            'email' => 'test@example.com',
            'password' => bcrypt('icbd@3813#')
        ]);
        $user->assignRole($role1);

        $user = Admin::create([
            'name' => 'Example Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('icbd@3813#')
        ]);
        $user->assignRole($role2);

        $user = Admin::create([
            'name' => 'Example Super-Admin User',
            'email' => 'superadmin@example.com',
            'password' => bcrypt('icbd@3813#')
        ]);
        $user->assignRole($role3);
    }
}
