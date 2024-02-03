<?php

namespace Database\Seeders;

use App\Models\Log;
use Database\Factories\LoginLogFactory;
use Illuminate\Database\Seeder;

class LoginLogSeeder extends Seeder
{
    public function run()
    {
        Log::factory(200)->create();
    }
}