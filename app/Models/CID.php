<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperCID
 */
class CID extends Model
{
    use HasFactory;

    protected $table = 'cid';

    protected $fillable = [
        'old_id',
        'description',
        'code'
    ];
}
