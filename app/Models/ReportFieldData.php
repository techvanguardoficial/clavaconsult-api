<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperReportFieldData
 */
class ReportFieldData extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_field_id',
        'report_id',
        'value'
    ];

    public function reportField(): BelongsTo
    {
        return $this->belongsTo(ReportField::class);
    }

    public function report(): BelongsTo
    {
        return $this->belongsTo(MedicalReport::class);
    }
}
