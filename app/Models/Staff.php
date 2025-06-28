<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staffs';

    protected $fillable = [
        'uuid',
        'user_id',
        'school_id',
        'nip',
        'name',
        'gender',
        'marital_status',
        'religion',
        'phone',
        'email',
        'birth_date',
        'birth_place',
        'position',
        'department',
        'employment_status',
        'join_date',
        'end_date',
        'education_level',
        'last_education_institution',
        'address',
        'photo',
        'status',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'end_date' => 'date',
    ];

    // Relasi ke akun pengguna
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke unit sekolah
    public function school()
    {
        return $this->belongsTo(School::class);
    }
}
