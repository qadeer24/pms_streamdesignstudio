<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'projects-list',
            'projects-create',
            'projects-edit',
            'projects-delete',

            'comments-list',
            'comments-create',
            'comments-edit',
            'comments-delete',

            'categories-list',
            'categories-create',
            'categories-edit',
            'categories-delete',

            'frameworks-list',
            'frameworks-create',
            'frameworks-edit',
            'frameworks-delete',

            'client-feedback-list',
            'client-feedback-create',
            'client-feedback-edit',
            'client-feedback-delete',

            'tasks-list',
            'tasks-create',
            'tasks-edit',
            'tasks-delete',

            'team-members-list',
            'team-members-create',
            'team-members-edit',
            'team-members-delete',

         ];
         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
     }
}
