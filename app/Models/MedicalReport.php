<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperMedicalReport
 */
class MedicalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'duration',
        'status',
        'doctor_id',
        'patient_id',
        'old_id'
    ];

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }

    public function fieldData(): HasMany
    {
        return $this->hasMany(ReportFieldData::class, 'report_id');
    }
}
