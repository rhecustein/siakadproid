<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Canteen extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'branch_id', 'is_active'];

    public function products() {
        return $this->hasMany(CanteenProduct::class);
    }

    public function sales() {
        return $this->hasMany(CanteenSale::class);
    }

    public function users() {
        return $this->hasMany(CanteenUser::class);
    }
}