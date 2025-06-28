<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolePermission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'role_id',
        'permission',
        'allowed',
    ];

    protected $casts = [
        'allowed' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
