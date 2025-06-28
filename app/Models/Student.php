<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';

    protected $fillable = [
        'uuid',
        'user_id',
        'school_id',
        'grade_id',
        'parent_id',
        'nis',
        'nisn',
        'name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'address',
        'student_status',
        'admission_date',
        'graduation_date',
        'religion',
        'phone',
        'photo',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'date_of_birth'   => 'date',
        'admission_date'  => 'date',
        'graduation_date' => 'date',
        'is_active'       => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function ($student) {
            if (!$student->uuid) {
                $student->uuid = (string) Str::uuid();
            }
        });
    }

    // Relasi ke akun pengguna
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke orang tua utama
    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }

    // Relasi ke sekolah
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Relasi ke kelas akademik (grade level)
    public function grade()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_id');
    }

    // Relasi ke dompet (saldo siswa)
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    // Relasi ke kelas aktif (bisa berbeda dengan grade)
    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    // Relasi ke riwayat enroll kelas/tahun ajaran
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function bills()
    {
        return $this->hasMany(\App\Models\Bill::class);
    }

    //graduation
    
}
