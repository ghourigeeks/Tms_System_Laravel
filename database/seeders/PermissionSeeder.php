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

            'province-list',
            'province-create',
            'province-edit',
            'province-delete',

            'city-list',
            'city-create',
            'city-edit',
            'city-delete',

            'people-list',
            'people-create',
            'people-edit',
            'people-delete',

            'complaint_tag-list',
            'complaint_tag-create',
            'complaint_tag-edit',
            'complaint_tag-delete',

            'complaint-list',
            'complaint-create',
            'complaint-edit',
            'complaint-delete',

            'rating-list',
            'rating-create',
            'rating-edit',
            'rating-delete',

            'reason-list',
            'reason-create',
            'reason-edit',
            'reason-delete',

            'status-list',
            'status-create',
            'status-edit',
            'status-delete',

            
            'payment_methods-list',
            'payment_methods-create',
            'payment_methods-edit',
            'payment_methods-delete',


            'package-list',
            'package-create',
            'package-edit',
            'package-delete',

            'category-list',
            'category-create',
            'category-edit',
            'category-delete'


            

        ];

        foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
        }
     }
}
