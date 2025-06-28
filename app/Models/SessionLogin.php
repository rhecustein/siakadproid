<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionLogin extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'ip_address',
        'user_agent',
        'device',
        'city',
        'province',
        'latitude',
        'longitude',
        'success',
        'logged_in_at',
        'last_activity_at',
        'logged_out_at',
        'is_active',
    ];
}
