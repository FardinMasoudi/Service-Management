<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'user_id' => User::factory(),
            'title' => fake()->title,
            'description' => fake()->paragraph,
            'status' => fake()->randomElement(Ticket::STATUSES)
        ];
    }
}
