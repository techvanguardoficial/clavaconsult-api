<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin IdeHelperReportField
 */
class ReportField extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'columns'
    ];

    protected $casts = [
        'hidden' => 'boolean'
    ];

    public function reportTab(): BelongsTo
    {
        return $this->belongsTo(ReportTab::class);
    }

    public function reportFieldData(): HasMany
    {
        return $this->hasMany(ReportFieldData::class);
    }
}
