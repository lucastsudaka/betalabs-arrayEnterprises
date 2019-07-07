<?php

use App\User;
use App\Role;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleBasicUser = new Role();
        $roleBasicUser->name = 'basic';
        $roleBasicUser->description = 'new users';
        $roleBasicUser->save();       
        
        $roleAdminUser = new Role();
        $roleAdminUser->name = 'admin';
        $roleAdminUser->description = 'supper acount users';
        $roleAdminUser->save();
        
        
        $roleAdmin = Role::where('name', 'admin')->first();
        $createAdmin = new User();
        $createAdmin->name = 'Admin';
        $createAdmin->email = 'admin@mail.com';
        $createAdmin->password = bcrypt('admin');
        $createAdmin->save();
        $createAdmin->roles()->attach($roleAdmin);
        
        
        
        
    }
}
