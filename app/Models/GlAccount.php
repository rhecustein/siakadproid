<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlAccount extends Model
{
    protected $fillable = [
        'code', 'name', 'type', 'category_id', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(GlCategory::class, 'category_id');
    }
}
