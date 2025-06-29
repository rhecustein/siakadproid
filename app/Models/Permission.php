<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'guard_name', // Biasanya 'web' atau 'api'
        'description', // Tambahkan kolom deskripsi jika diinginkan
        'category', // Untuk mengelompokkan permissions (misal: 'users', 'finance', 'academic')
    ];

    // Relasi many-to-many ke Roles
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions', 'permission_id', 'role_id');
    }

    // Relasi many-to-many ke User (melalui tabel pivot model_has_permissions)
    public function users()
    {
        return $this->morphedByMany(User::class, 'model', 'model_has_permissions', 'permission_id', 'model_id');
    }

    // Contoh: Ambil semua role yang memiliki permission ini
    // public function rolePermissions()
    // {
    //     return $this->hasMany(RolePermission::class, 'permission_id');
    // }
}