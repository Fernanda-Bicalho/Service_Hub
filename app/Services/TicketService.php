<?php

namespace App\Services;

use App\Models\Ticket;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketService
{
    /**
     * Lista os tickets com paginação e filtros básicos.
     * * @param array $filters
     * @return LengthAwarePaginator
     */
    public function list($data): LengthAwarePaginator
    {

        $perPage = 10;

        return Ticket::with(['project', 'user'])


        ->when(
            filled($data->search) && str($data->search)->length() >= 3,
                fn($query) => $query->where('ticket_subject', 'like', "%{$data->search}%")

        )

        ->when(
            $data->status ?? null,
            fn($query, $status) => $query->where('ticket_status', $status)
        )
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * Cria um novo ticket vinculando ao usuário logado.
     */

        public function store(array $data): Ticket
        {
            return Ticket::create($data);
        }

        public function update(Ticket $ticket, array $data): Ticket
        {
            $ticket->update($data);
            return $ticket;
        }

        public function delete(Ticket $ticket): void
        {
            $ticket->delete();


        }
}