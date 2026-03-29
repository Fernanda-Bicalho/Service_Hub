<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\DetailFactory; // <-- Verifique se este import existe

class TicketDetail extends Model
{
    use HasFactory;

    // Se você não tem colunas created_at e updated_at, mantenha como false
    public $timestamps = false; 

    protected $fillable = [
        'ticket_id',
        'ticket_details_enriched_data',
        'ticket_details_processed_at',
        'ticket_details_notified_at',
    ];

    /**
     * No Laravel 11, o padrão recomendado é usar o método casts() 
     * em vez da propriedade $casts para evitar erros de inicialização.
     */
    protected function casts(): array
    {
        return [
            'ticket_details_enriched_data' => 'array',
            'ticket_details_processed_at' => 'datetime',
            'ticket_details_notified_at' => 'datetime',
        ];
    }

    protected static function newFactory()
    {
        // Se a classe se chama DetailFactory, o retorno deve ser este:
        return DetailFactory::new();
    }


    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
}

