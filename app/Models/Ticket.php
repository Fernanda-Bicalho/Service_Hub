<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ticket extends Model
{
    protected $fillable = [

        'project_id',
        'user_id',
        'ticket_subject',
        'ticket_status'
    ];

    public function project() : BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user() : BelongsTo
    {
      return $this->belongsTo(User::class);
    }

    public function details() : HasOne
    {
        return $this->hasOne(Ticket::class);
    }
}
