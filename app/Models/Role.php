<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'uuid',
        'name',
        'display_name',
        'guard_name',
    ];

    protected static function booted()
    {
        static::creating(function ($role) {
            if (empty($role->uuid)) {
                $role->uuid = (string) Str::uuid();
            }
        });
    }

    // Relasi: satu role bisa dimiliki banyak user
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
