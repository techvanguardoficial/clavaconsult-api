<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperReportTab
 */
class ReportTab extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function reportFields(): HasMany
    {
        return $this->hasMany(ReportField::class);
    }
}
