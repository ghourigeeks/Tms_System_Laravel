<?php

namespace Database\Seeders;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        
        $permissions = [

            'user-list',
            'user-create',
            'user-edit',
            'user-delete',

            'role-list',
            'role-create',
            'role-edit',
            'role-delete',

            'order-list',
            'order-create',
            'order-edit',
            'order-delete',

            'category-list',
            'category-create',
            'category-edit',
            'category-delete',

            'client-list',
            'client-create',
            'client-edit',
            'client-delete',

            'feedback-list',
            'feedback-create',
            'feedback-edit',
            'feedback-delete',

            'revision-list',
            'revision-create',
            'revision-edit',
            'revision-delete',

            'contest-list',
            'contest-create',
            'contest-edit',
            'contest-delete',

            'leave-list',
            'leave-create',
            'leave-edit',
            'leave-delete',

        ];

        foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
        }
     }
}
