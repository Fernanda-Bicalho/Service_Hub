<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TicketDetail>
 */
class DetailFactory extends Factory
{
    /**
     * O modelo correspondente à factory.
     */
    protected $model = TicketDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Associa a um Ticket existente ou cria um novo se necessário
            'ticket_id' => Ticket::factory(),
            
            // Dados enriquecidos (Serão convertidos em JSON pelo Model)
            'ticket_details_enriched_data' => [
                'os' => $this->faker->linuxProcessor(),
                'ram_usage' => $this->faker->numberBetween(10, 90) . '%',
                'error_log' => $this->faker->sentence(),
                'ip_address' => $this->faker->ipv4(),
                'priority_score' => $this->faker->randomDigit(),
                'user_agent' => $this->faker->userAgent(),
            ],
            
            // Datas formatadas corretamente
// No seu DetailFactory.php
            'ticket_details_processed_at' => now()->subMinutes($this->faker->numberBetween(1, 60)),
            'ticket_details_notified_at' => now(),
        ];
    }
}