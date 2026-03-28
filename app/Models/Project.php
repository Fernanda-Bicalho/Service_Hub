<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $fillable = [

        'company_id',
        'project_title'
    ];


    public function company() : BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function tickets() : HasMany
    {
      return $this->hasMany(Ticket::class);
    }
}
