<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperImport
 */
class Import extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_id',
        'doctor_id',
        'last_patient_id'
    ];
}
