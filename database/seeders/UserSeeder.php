<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        // Create a single custom user
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => bcrypt('password'),
            'join_date' => now(),
            'unit_id' => 1,
        ]);
    }
}
