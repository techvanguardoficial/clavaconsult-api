<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'key',
        'information',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
