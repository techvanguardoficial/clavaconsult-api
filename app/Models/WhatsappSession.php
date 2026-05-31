<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhatsappSession extends Model
{
    protected $fillable = [
        'phone',
        'step',
        'mode',
        'data',
        'history',
    ];

    protected $casts = [
        'data'    => 'array',
        'history' => 'array',
    ];
}
