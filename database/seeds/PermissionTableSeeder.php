<?php


use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [
            'admin-list',
            'admin-create',
            'admin-edit',
            'admin-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'role-list',
            'role-create',
            'course-list',
            'course-create',
            'course-edit',
            'course-delete',
            'batch-list',
            'batch-create',
            'batch-edit',
            'batch-delete',
            'student-list',
            'student-create',
            'student-edit',
            'student-delete',
            'session-list',
            'session-create',
            'session-edit',
            'session-delete',
            'registration-list',
            'registration-create',
            'registration-edit',
            'registration-delete',
            'fees-log',
            'fees-list',
            'fees-create',
            'fees-edit',
            'fees-delete',
            'stuff-list',
            'stuff-create',
            'stuff-edit',
            'stuff-delete',
            'expanse-list',
            'expanse-create',
            'expanse-edit',
            'expanse-delete',
            'expanse-categoris-list',
            'expanse-categoris-create',
            'expanse-categoris-edit',
            'expanse-categoris-delete',
            'slider-list',
            'slider-create',
            'slider-edit',
            'slider-delete',
            'success-story-list',
            'success-story-create',
            'success-story-edit',
            'success-story-delete',
        ];
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}