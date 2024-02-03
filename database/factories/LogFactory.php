<?php
// Corrected LogFactory class
namespace Database\Factories;

use App\Models\Log;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LogFactory extends Factory
{
    protected $model = Log::class;

    public function definition()
    {
        $userIds = User::pluck('id')->toArray();
        shuffle($userIds);
        return [
            'action' => 'LOGIN',
            'user_id' => $this->faker->randomElement($userIds),
            'description' => 'Login To System',
        ];
    }
}

