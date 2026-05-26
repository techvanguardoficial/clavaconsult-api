<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UnitRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_address_id',
        'name',
        'description',
    ];

    public function unitAddress(): BelongsTo
    {
        return $this->belongsTo(UnitAddress::class);
    }

    public function workTimes(): HasMany
    {
        return $this->hasMany(WorkTime::class);
    }
}
