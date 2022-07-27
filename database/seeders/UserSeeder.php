<?php
namespace Database\Seeders;

use Hash;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        
        $user           = User::create([
        	'name'      => 'admin', 
        	'email'     => 'admin@gmail.com',
        	'password'  => Hash::make('rootroot')
        ]);
  
        $role           = Role::create(['name' => 'Super-Admin']);
        $permissions    = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
