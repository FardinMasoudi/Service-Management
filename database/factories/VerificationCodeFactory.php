<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VerificationCode>
 */
class VerificationCodeFactory extends Factory
{
    /**
     * Define the model's default state.users
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'code' => $this->faker->randomDigit(),
            'driver' => $this->faker->randomElements(['email', 'sms'])
        ];
    }
}
