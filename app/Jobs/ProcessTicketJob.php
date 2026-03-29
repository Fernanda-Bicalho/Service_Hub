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
use App\Notifications\TicketProcessedNotification;


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
        $this->ticket->update([
            'ticket_status' => 'processing'
        ]);
    
        try {
    
            $content = Storage::get($this->ticket->ticket_attachment);
    
            $result = [
                'lines' => substr_count($content, "\n"),
                'words' => str_word_count($content),
                'characters' => Str::length($content),
            ];
    
            TicketDetail::updateOrCreate(
                ['ticket_id' => $this->ticket->id],
                [
                    'ticket_details_enriched_data' => json_encode($result),
                    'ticket_details_processed_at' => now(),
                ]
            );
    
            $this->ticket->update([
                'ticket_status' => 'done'
            ]);


          $this->ticket->detail()->update([
         'ticket_details_notified_at' => now()
        ]);
    
        } catch (\Throwable $e) {
    
            $this->ticket->update([
                'ticket_status' => 'error'
            ]);
    
            \Log::error($e->getMessage());
        }
    }
}
