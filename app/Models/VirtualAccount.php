<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VirtualAccount extends Model
{
    protected $fillable = ['user_id', 'payment_number', 'va_number', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}