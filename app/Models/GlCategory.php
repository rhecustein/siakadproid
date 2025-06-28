<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlCategory extends Model
{
    protected $fillable = [
        'code', 'name', 'type',
    ];

    public function accounts()
    {
        return $this->hasMany(GlAccount::class, 'category_id');
    }
}
