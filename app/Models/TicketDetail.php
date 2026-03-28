<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TicketDetail extends Model
{
    protected $fillable = [

        'ticket_id',
        'technical_specs'
    ];

    public function ticket() : BelongsTo
    {
      return $this->belongsTo(Ticket::class);
    }
}
