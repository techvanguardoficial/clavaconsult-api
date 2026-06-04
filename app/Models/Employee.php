<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

/**
 * @mixin IdeHelperEmployee
 */
class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'access_all_schedules'
    ];

    /**
     * @return MorphOne
     */
    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'profile', 'type');
    }

    public function csatResponses(): HasMany
    {
        return $this->hasMany(CsatReceptionistResponse::class);
    }
}
