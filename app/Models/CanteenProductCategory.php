<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CanteenProductCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    public function products()
    {
        return $this->hasMany(CanteenProduct::class, 'category_id');
    }

    public function category()
{
    return $this->belongsTo(CanteenProductCategory::class, 'category_id');
}
}
