<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}
