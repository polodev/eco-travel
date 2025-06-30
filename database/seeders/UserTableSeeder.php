<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@example.com'], [
            'name' => 'Admin User',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);

        User::firstOrCreate(['email' => 'user@example.com'], [
            'name' => 'Regular User',
            'password' => bcrypt('password'),
            'role' => 'user'
        ]);
    }
}