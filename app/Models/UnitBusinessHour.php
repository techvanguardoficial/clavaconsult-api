<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UnitBusinessHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_address_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_closed',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_closed'   => 'boolean',
    ];

    public function unitAddress(): BelongsTo
    {
        return $this->belongsTo(UnitAddress::class);
    }
}
