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

            'complaint-list',
            'complaint-create',
            'complaint-edit',
            'complaint-delete',
            
            'payment_methods-list',
            'payment_methods-create',
            'payment_methods-edit',
            'payment_methods-delete',

            'package-list',
            'package-create',
            'package-edit',
            'package-delete',

            'region-list',
            'region-create',
            'region-edit',
            'region-delete',

            'country-list',
            'country-create',
            'country-edit',
            'country-delete',

            'category-list',
            'category-create',
            'category-edit',
            'category-delete',
            
            'client-list',
            'client-create',
            'client-edit',
            'client-delete',
                
            'product-list',
            'product-create',
            'product-edit',
            'product-delete',
                
            'box-list',
            'box-create',
            'box-edit',
            'box-delete',
                
            'ibeacon-list',
            'ibeacon-create',
            'ibeacon-edit',
            'ibeacon-delete',

            'faq-list',
            'faq-create',
            'faq-edit',
            'faq-delete',

        ];

        foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
        }
     }
}
