<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperSpecialty
 */
class Specialty extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'actuation',
    ];

    /**
     * @return HasMany
     */
    public function doctors(): HasMany
    {
        return $this->hasMany(Doctor::class);
    }
}
