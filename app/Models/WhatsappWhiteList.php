<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhatsappWhiteList extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'name',
        'description',
    ];
}
