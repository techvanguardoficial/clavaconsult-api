<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_name',
        'street',
        'number',
        'complementary',
        'neighborhood',
        'city',
        'state',
        'zip_code'
    ];
}
