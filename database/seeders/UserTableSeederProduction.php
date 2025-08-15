<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeederProduction extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TODO: Add production user seeding logic
        User::firstOrCreate(['email' => 'polodev10@gmail.com'], [
            'name' => 'Shibu Chandra Debnath',
            'password' => bcrypt('hello123$$'),
            'role' => 'developer'
        ]);
        User::firstOrCreate(['email' => 'polodev15@gmail.com'], [
            'name' => 'Shibu Chandra Debnath 2',
            'password' => bcrypt('hello123$$'),
            'role' => 'admin'
        ]);

        User::firstOrCreate(['email' => 'ecotravelsbangladesh@gmail.com'], [
            'name' => 'Eco Travel Bangladesh',
            'password' => bcrypt('VsjWQPjBCLdL$'),
            'role' => 'admin'
        ]);
    }
}