<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data Admin
        DB::table('users')->insert([
            'name' => 'Admin Travel',
            'email' => 'admin@travel.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Data Penumpang
        DB::table('users')->insert([
            'name' => 'Penumpang Travel',
            'email' => 'penumpang@travel.com',
            'password' => Hash::make('password'), // Password: password
            'role' => 'penumpang',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
