<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperDoctor
 */
class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'cpf',
        'council_type',
        'council_number',
        'specialty_id',
    ];

    /**
     * @return MorphOne
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile', 'type');
    }

    /**
     * @return BelongsTo
     */
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }

    /**
     * @return HasMany
     */
    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }

    /**
     * @return HasManyThrough
     */
    public function appointments(): HasManyThrough
    {
        return $this->hasManyThrough(Appointment::class, Event::class);
    }

    public function reportTabs(): HasMany
    {
        return $this->hasMany(ReportTab::class);
    }

    public function reportFields(): HasManyThrough
    {
        return $this->hasManyThrough(ReportField::class, ReportTab::class);
    }
}
