<?php

namespace App\Jobs;

use App\Models\Ticket;
use App\Models\TicketDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;


class ProcessTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Ticket $ticket;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // 🔵 Atualiza status para processing
        $this->ticket->update([
            'ticket_status' => 'processing'
        ]);
    
        try {
    
            // 📎 Lê o arquivo
            $content = Storage::get($this->ticket->ticket_attachment);
    
            // 🧠 Processamento simples (pode evoluir depois)
            $result = [
                'lines' => substr_count($content, "\n"),
                'words' => str_word_count($content),
                'characters' => Str::length($content),
            ];
    
            // 💾 Salva ou atualiza TicketDetail
            TicketDetail::updateOrCreate(
                ['ticket_id' => $this->ticket->id],
                [
                    'ticket_details_enriched_data' => json_encode($result),
                    'ticket_details_processed_at' => now(),
                ]
            );
    
            // 🟢 Sucesso
            $this->ticket->update([
                'ticket_status' => 'done'
            ]);
    
        } catch (\Throwable $e) {
    
            // 🔴 Erro
            $this->ticket->update([
                'ticket_status' => 'error'
            ]);
    
            // opcional: log
            \Log::error($e->getMessage());
        }
    }
}
