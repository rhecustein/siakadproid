<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class StudentParent extends Model
{
    protected $table = 'parents'; // 👈 penting: tetap pakai 'parents' sebagai nama tabel

    protected $fillable = [
        'uuid', 'user_id', 'name', 'gender', 'relationship', 'phone', 'email', 'address', 'is_active'
    ];

    // relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }

    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    public function children()
    {
        return $this->hasMany(Student::class, 'parent_id', 'id');
        // Atau jika 'user_id' di tabel students mengacu ke 'user_id' di student_parents:
        // return $this->hasMany(Student::class, 'user_id', 'user_id');
    }
}
