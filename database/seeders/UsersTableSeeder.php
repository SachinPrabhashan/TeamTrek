<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Create the root user
        DB::table('users')->insert([
            'name' => 'TeamTrek-ROOT',
            'email' => 'teamtrek@root.com',
            'password' => Hash::make('12345678'),
            'created_at' => now(),
            'updated_at' => now(),
            // Add any other necessary fields
        ]);
    }
}


// To RUN seeder file
// 2nd File
// php artisan db:seed --class=UsersTableSeeder
