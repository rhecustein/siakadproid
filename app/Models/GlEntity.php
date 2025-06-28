<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlEntity extends Model
{
    protected $fillable = [
        'entity_type', 'entity_id', 'label',
    ];
}
