<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class CanteenUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'canteen_id', 'role'];

    public function canteen() {
        return $this->belongsTo(Canteen::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}