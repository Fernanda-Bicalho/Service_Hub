<?php


namespace App\Http\Controllers;


use App\Http\Requests\TickeRequests\StoreTicketRequest;
use App\Http\Requests\TickeRequests\UpdateTicketRequest;
use App\Models\Project;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class TicketController extends Controller
{

    public function __construct(protected TicketService $ticket_service){}


    public function index(Request $request)
    {
       return Inertia::render('Dashboard',[
         'tickets' => $this->ticket_service->list($request),
         'filters' => $request->only('search', 'status'),
         'projects' => Project::select('id', 'project_title')->get(),
       ]);
    }


    public function show(Ticket $ticket)
    {
        $ticket->load([
            'project.company',
            'user',
            'detail'
        ]);

        return Inertia::render('Tickets/Show', [
            'ticket' => $ticket
        ]);
    }


    public function store(StoreTicketRequest $request)
    {
        $ticket =  $this->ticket_service->store($request->validated());

        $tickets = $this->ticket_service->list($request);
    
        return Inertia::render('Dashboard', [
            'tickets' => $tickets,
            'filters' => $request->only('search', 'status'),
            'projects' => Project::select('id', 'project_title')->get(),
            'success' => 'Ticket criado com sucesso!',
        ]);
    }


    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->ticket_service->update($ticket,$request->validated());
        return redirect()->back()->with('success', 'Ticket atualizado com sucesso !');

        $msg = $request->ticket_status === 'concluido' 
           ? 'Ticket finalizado e arquivado!' 
           : 'Ticket atualizado com sucesso!';

    return redirect()->back()->with('success', $msg);
    }


    public function destroy(Ticket $ticket)
    {
       $this->ticket_service->delete($ticket);
       return redirect()->route('tickets.index')->with('success', 'Ticket deletado com sucesso !');
    }
}


