<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'uuid',
        'tenant_id',
        'name',
        'username',
        'email',
        'phone_number',
        'email_verified_at',
        'password',
        'role_id',
        'detail_id',
        'avatar',
        'fingerprint',
        'village_id',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'role_id' => 'integer',
    ];

    // Relasi ke Role (satu user punya satu role)
    public function role()
    {
        return $this->belongsTo(\App\Models\Role::class, 'role_id');
    }

    // Accessor: avatar URL fallback
    public function getAvatarUrlAttribute()
    {
        return $this->avatar
            ? asset('storage/avatars/' . $this->avatar)
            : asset('images/avatar.png');
    }

    // Jika perlu nama role langsung (opsional)
    public function getRoleNameAttribute()
    {
        return $this->role?->name ?? 'Tidak diketahui';
    }

    public function parent()
    {
        return $this->hasOne(StudentParent::class, 'user_id', 'id');
    }
    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'user_id', 'id');
    }

    public function canteens()
    {
        return $this->belongsToMany(\App\Models\Canteen::class, 'canteen_users')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function fingerprintTemplates()
    {
        return $this->hasMany(FingerprintTemplate::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

     public function student()
    {
        return $this->hasOne(Student::class, 'user_id');
    }
}
