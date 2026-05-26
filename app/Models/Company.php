<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'cnpj',
        'phone',
        'whatsapp',
        'email',
    ];

    public function unitAddresses(): HasMany
    {
        return $this->hasMany(UnitAddress::class);
    }
}
