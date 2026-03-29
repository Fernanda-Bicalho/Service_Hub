<?php

namespace App\Services;

use App\Jobs\ProcessTicketJob;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        return Ticket::with(['project.company', 'user'])
            ->when(
                !empty($data->search) && str($data->search)->length() >= 3,
                fn($query) => $query->where('ticket_title', 'like', "%{$data->search}%")
            )
            ->when(
                !empty($data->status),
                fn($query) => $query->where('ticket_status', $data->status)
            )
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

  
     public function store(array $data): Ticket
     {
         
         if (
             isset($data['ticket_attachment']) &&
             $data['ticket_attachment'] instanceof UploadedFile
         ) {
            $data['ticket_attachment'] = $data['ticket_attachment']->store('tickets', 'public');
            $data['ticket_status'] = 'pending';
         }else{
            $data['ticket_status'] = 'done';
         }

        
         $data['user_id'] = Auth::id();
 
         $ticket = Ticket::create($data);
 

         if (!empty($ticket->ticket_attachment)) {
             ProcessTicketJob::dispatch($ticket);
         }
 
         return $ticket;
     }

        public function update(Ticket $ticket, array $data): Ticket
        {
   
            if (
                isset($data['ticket_attachment']) &&
                $data['ticket_attachment'] instanceof UploadedFile
            ) {
                if ($ticket->ticket_attachment) {
                    Storage::delete($ticket->ticket_attachment);
                }
    
                $data['ticket_attachment'] = $data['ticket_attachment']->store('tickets');
    
                $data['ticket_status'] = 'pending';
    
                ProcessTicketJob::dispatch($ticket);
            }
    
            $ticket->update($data);
    
            return $ticket;
        }


        public function delete(Ticket $ticket): void
        {

            if ($ticket->ticket_attachment) {
                Storage::delete($ticket->ticket_attachment);
            }
    
            $ticket->delete();
        }
}