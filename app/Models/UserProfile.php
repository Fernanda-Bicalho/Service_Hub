<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\ProfileFactory;



class UserProfile extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'user_phone',
        'user_position'
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function newFactory()
    {
        return ProfileFactory::new();
    }

}
