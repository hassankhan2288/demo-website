<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;


class PermissionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$ids = [];
    	$permissions = [
        	['name' => 'category-list', 'guard_name'=>'admin'],
        	['name' => 'category-add','guard_name'=>'admin'],
        	['name' => 'category-delete','guard_name'=>'admin'],

        	['name' => 'user-list','guard_name'=>'admin'],
        	['name' => 'user-add','guard_name'=>'admin'],
        	['name' => 'user-delete','guard_name'=>'admin'],

        	['name' => 'admin-list','guard_name'=>'admin'],
        	['name' => 'admin-add','guard_name'=>'admin'],
        	['name' => 'admin-delete','guard_name'=>'admin'],

        	['name' => 'role-list','guard_name'=>'admin'],
        	['name' => 'role-add','guard_name'=>'admin'],
        	['name' => 'role-delete','guard_name'=>'admin'],
        ];
        $all = Permission::count();
        if($all===0){
            foreach ($permissions as $permission) {
                $per = Permission::create($permission);
                if($per){
                    $ids[] = $per->id;
                }
            }
            $role = new Role;
            $role->name = "Super Admin";
            $role->guard_name = "admin";
            $role->save();
            $role->syncPermissions($ids);
        }
        
        $admins = Admin::count();
        if($admins===0){
            $admin = new Admin;
        
            $admin->name = "Super Admin";
            $admin->email = "admin@admin.com";
            $admin->password = Hash::make("admin123");
            $admin->save();
            $admin->assignRole($role->id);
        }
        
    }
}
