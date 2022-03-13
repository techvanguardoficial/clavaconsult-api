<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @mixin IdeHelperAppointment
 */
class Appointment extends Model
{
    use HasFactory, SoftDeletes;

    protected $attributes = [
        'status' => 1
    ];

    protected $fillable = [
        'patient_id',
        'plan_id',
        'type',
        'comment',
        'status'
    ];

    protected static function booted()
    {
        static::deleting(function (Appointment $appointment) {
            $appointment->event->delete();

            foreach ($appointment->payments()->get() as $payment) {
                $payment->delete();
            }
        });
    }

    /**
     * @return MorphOne
     */
    public function event(): MorphOne
    {
        return $this->morphOne(Event::class, 'event', 'type');
    }

    /**
     * @return BelongsTo
     */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    /**
     * @return BelongsTo
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return HasOne
     */
    public function medicalReport(): HasOne
    {
        return $this->hasOne(MedicalReport::class);
    }

    /**
     * @return HasMany
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
