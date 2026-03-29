<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        return [
            'project_id' => Project::factory(),
            'user_id' => User::factory(),
            'ticket_title' => $this->faker->sentence(3),
            'ticket_description' => $this->faker->paragraph(),
            'ticket_status' => $this->faker->randomElement(['pending', 'processing', 'done', 'error']),
            'ticket_attachment' => $this->faker->optional()->filePath(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}