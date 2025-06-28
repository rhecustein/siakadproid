<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan jika menggunakan SoftDeletes

class Student extends Model
{
    use HasFactory;
    // use SoftDeletes; // Uncomment this line if you use SoftDeletes on Student model

    protected $table = 'students';

    protected $fillable = [
        'uuid',
        'user_id',
        'school_id',
        'grade_id', // grade_level_id
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
        'phone_number', // Mengubah 'phone' menjadi 'phone_number' sesuai dengan controller
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
    // Jika Wallet memang morphOne, pastikan tabel wallets punya kolom owner_type dan owner_id
    // Jika Wallet terhubung ke user_id: return $this->hasOne(Wallet::class, 'user_id', 'user_id');
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    // Relasi ke riwayat enroll kelas/tahun ajaran (jika ini adalah enrollments, bukan penugasan langsung)
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    // Relasi ke tagihan
    public function bills()
    {
        return $this->hasMany(\App\Models\Bill::class);
    }

    /**
     * Relasi untuk mendapatkan penugasan kelas aktif siswa saat ini.
     * Ini adalah penugasan spesifik siswa ke sebuah kelas di tahun ajaran tertentu.
     */
    public function currentClassroomAssignment()
    {
        return $this->hasOne(ClassroomAssignment::class, 'student_id')
                    ->where('is_active', true) // Asumsi ClassroomAssignment punya is_active
                    ->whereHas('academicYear', function ($query) {
                        $query->where('is_active', true); // Hanya tahun ajaran aktif
                    })
                    ->with(['classroom.level', 'academicYear']); // Eager load classroom (dengan level) dan academicYear
    }

    /**
     * Accessor untuk mendapatkan objek Classroom aktif siswa.
     * Menggunakan relasi currentClassroomAssignment yang sudah ada.
     * Ini adalah cara yang lebih aman daripada hasOneThrough jika relasi perantara kompleks.
     */
    public function getCurrentClassroomAttribute()
    {
        // Jika currentClassroomAssignment sudah di-eager load, gunakan itu.
        // Jika tidak, bisa di-load di sini, tapi akan menyebabkan N+1 problem jika tidak di-eager load.
        // Asumsi eager loading sudah dilakukan di controller.
        return $this->currentClassroomAssignment->classroom ?? null;
    }

    // PENTING: Pastikan model-model berikut memiliki relasi baliknya dan kolom yang sesuai:
    // ClassroomAssignment -> belongsTo(Student::class)
    // ClassroomAssignment -> belongsTo(Classroom::class)
    // ClassroomAssignment -> belongsTo(AcademicYear::class)
    // Classroom -> hasMany(ClassroomAssignment::class, 'classroom_id')
    // Classroom -> belongsTo(Level::class) // Jika 'level' diakses dari classroom
}