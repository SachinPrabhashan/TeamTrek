<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'role'],
            ['name' => 'admin'],
            ['name' => 'employee'],
            ['name' => 'client'],
        ];

        // Insert data into 'roles' table
        DB::table('roles')->insert($roles);
    }
}
