<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class ModelHasRoles extends Model
{
    use HasFactory;

    protected $table = 'model_has_roles'; // Nama tabel pivot
    protected $fillable = [
        'role_id',
        'model_type', // Contoh: 'App\\Models\\User'
        'model_id',   // ID dari user atau model lain
    ];

    // Relasi ke Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Relasi polimorfik ke model yang memiliki peran (misal: User)
    public function model()
    {
        return $this->morphTo();
    }
}
