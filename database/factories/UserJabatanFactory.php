<?php

namespace Database\Factories;

use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserJabatan>
 */
class UserJabatanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $jabatanIds = Jabatan::pluck('id')->toArray();
        $userIds = User::pluck('id')->toArray();

        return [
            'user_id' => $this->faker->randomElement($userIds),
            'jabatan_id' => $this->faker->randomElement($jabatanIds)
        ];
    }
}
