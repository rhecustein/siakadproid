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
    // Asumsi: Wallet terhubung ke 'owner_id' dan 'owner_type' (polimorfik)
    public function wallet()
    {
        return $this->morphOne(Wallet::class, 'owner');
    }

    // Relasi ke riwayat enroll kelas/tahun ajaran (jika ini adalah enrollments)
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
     * Metode ini AKAN DI-EAGER LOAD.
     */
     public function currentClassroomAssignment()
    {
        // Pastikan 'student_id' adalah foreign key di tabel 'classroom_assignments'
        return $this->hasOne(ClassroomAssignment::class, 'student_id', 'id')
                    ->where('is_active', true) // Asumsi ClassroomAssignment punya kolom is_active
                    ->whereHas('academicYear', function ($query) {
                        $query->where('is_active', true); // Asumsi AcademicYear punya kolom is_active
                    });
    }

    /**
     * Accessor untuk mendapatkan objek Classroom yang aktif dari siswa.
     * Memungkinkan Anda mengakses kelas siswa dengan sintaks properti biasa: $student->currentClassroom->name
     * Accessor ini mengandalkan relasi `currentClassroomAssignment` yang sudah di-eager load.
     */
    public function getCurrentClassroomAttribute()
    {
        // Akses relasi `currentClassroomAssignment` (yang di-eager load di controller),
        // kemudian ambil objek `classroom` dari penugasan tersebut.
        // Gunakan `optional()` atau `?? null` untuk penanganan null yang aman.
        return optional($this->currentClassroomAssignment)->classroom;
    }

    // PENTING: Pastikan model-model berikut memiliki relasi baliknya dan kolom yang sesuai:
    // App\Models\ClassroomAssignment.php harus memiliki:
    // public function student() { return $this->belongsTo(Student::class); }
    // public function classroom() { return $this->belongsTo(Classroom::class); }
    // public function academicYear() { return $this->belongsTo(AcademicYear::class); }
    //
    // App\Models\Classroom.php harus memiliki:
    // public function level() { return $this->belongsTo(Level::class); } // Jika Anda mengakses level dari classroom
    //
    // App\Models\AcademicYear.php harus memiliki:
    // public function classroomAssignments() { return $this->hasMany(ClassroomAssignment::class); }
    // Pastikan juga kolom 'is_active' ada di tabel academic_years.
}