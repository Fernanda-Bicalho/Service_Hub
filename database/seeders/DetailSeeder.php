<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DetailSeeder extends Seeder{
    /**
     * Run the database seeds.
     * 
     */
    public function run(): void
{
    $tickets = \App\Models\Ticket::all();

    foreach ($tickets as $ticket) {
        \App\Models\TicketDetail::factory()->create([
            'ticket_id' => $ticket->id,
        ]);
    }
}
}