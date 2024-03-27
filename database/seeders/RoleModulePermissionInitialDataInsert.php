<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleModulePermissionInitialDataInsert extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'Root'],
            ['name' => 'Admin'],
            ['name' => 'Employee'],
            ['name' => 'Client'],
        ];

        // Insert data into 'roles' table
        DB::table('roles')->insert($roles);

        $modules = [
            ['name' => 'Dashboard'],
            ['name' => 'User Management'],
            ['name' => 'SC Handling'],
            ['name' => 'SC Instance Handling'],
            ['name' => 'SC Access Granting'],
            ['name' => 'SC Task Monitor'],
            ['name' => 'SC Reports'],
            ['name' => 'SC Analysis View'],
            ['name' => 'Employee Performance'],
            ['name' => 'Financial Health'],
            ['name' => 'Resource Utilization'],
            ['name' => 'Permissions'],
            ['name' => 'Module'],
            ['name' => 'Module Permission'],
        ];
        // Insert data into 'modules' table
        DB::table('modules')->insert($modules);

        $permissions = [
            ['name' => 'Add'],
            ['name' => 'Edit'],
            ['name' => 'Delete'],
            ['name' => 'View'],
        ];

        // Insert data into 'permissions' table
        DB::table('permissions')->insert($permissions);
    }
}



// To RUN seeder file
// 1st File
// php artisan db:seed --class=RoleModulePermissionInitialDataInsert
