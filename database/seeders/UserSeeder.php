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
        	'name'        => 'Fahad Khan Ghouri', 
        	'email'       => 'fahadghouri@gmail.com',
            'profile_pic' => 'fahad.jpg',
            'contact_no'  => '03123599024',
            'description' => 'Nerds Root Project Manager',
        	'password'    => Hash::make('NerdsR00t!@#')
        ]);
  
        $role           = Role::create(['name' => 'Super-Admin']);
        $permissions    = Permission::pluck('id','id')->all();
  
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
