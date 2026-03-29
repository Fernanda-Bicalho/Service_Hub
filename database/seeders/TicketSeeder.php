<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        // Cria 50 tickets com dados aleatórios
        Ticket::factory()->count(50)->create();
    }
}
