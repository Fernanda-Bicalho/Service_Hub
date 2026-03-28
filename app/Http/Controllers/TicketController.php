<?php


namespace App\Http\Controllers;


use App\Http\Requests\TickeRequests\StoreTicketRequest;
use App\Http\Requests\TickeRequests\UpdateTicketRequest;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketController extends Controller
{

    public function __construct(protected TicketService $ticket_service){}



    public function index(Request $request)
    {
       return Inertia::render('Tickets/Tickets',[
         'ticket' => $this->ticket_service->list($request),
         'filters' => $request->only('search')
       ]);
    }

    public function store(StoreTicketRequest $request)
    {
      $this->ticket_service->store($request->validated());
      return redirect()->back()->with('success', 'Ticket criado com sucesso !');
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->ticket_service->update($ticket,$request->validated());
        return redirect()->back()->with('success', 'Ticket atualizado com sucesso !');
    }

    public function destroy(Ticket $ticket)
    {
       $this->ticket_service->delete($ticket);
       return redirect()->back()->with('success', 'Ticket deletado com sucesso !');
    }
}


