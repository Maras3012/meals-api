<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Backend User
        DB::table('users')->insert([
            'name' => 'Backend',
            'email' => 'backend@factory.com',
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Frontend User
        DB::table('users')->insert([
            'name' => 'Frontend',
            'email' => 'frontend@factory.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Client User
        DB::table('users')->insert([
            'name' => 'Client',
            'email' => 'client@factory.com',
            'password' => Hash::make('password'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}

