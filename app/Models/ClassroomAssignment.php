<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassroomAssignment extends Model
{
    use HasFactory;

    // Pastikan nama tabel ini sesuai dengan migrasi Anda
    // Jika nama tabelnya 'homeroom_assignments' atau 'class_assignments', sesuaikan di sini
    // protected $table = 'classroom_assignments'; // Biasanya Laravel akan menebak 'classroom_assignments' dari 'ClassroomAssignment'

    protected $fillable = [
        'student_id', // PENTING: Tambahkan ini
        'classroom_id', // ID dari Classroom (ruangan fisik)
        'academic_year_id', // PENTING: Tambahkan ini
        'teacher_id', // Ini mungkin homeroom_teacher_id, sesuaikan dengan nama kolom di tabel
        'is_active', // PENTING: Tambahkan ini
        'note', // Kolom catatan jika ada
        // 'grade_level_id', // Kolom ini mungkin tidak diperlukan di sini jika kelas sudah menentukannya
        // 'name', // Kolom ini juga mungkin tidak diperlukan di sini jika nama diambil dari Classroom
        // 'homeroom_teacher_id', // Gunakan teacher_id untuk konsistensi dengan Teacher model
        // 'class_enrollments_id', // Relasi ini mungkin lebih tepat berada di ClassEnrollment
    ];

    protected $casts = [
        'is_active' => 'boolean', // Penting untuk filter is_active
    ];

    // Relasi balik ke Student (Siswa yang ditugaskan ke kelas ini)
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Relasi ke Kelas (objek Classroom fisik)
    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroom_id');
    }

    // Relasi ke Guru (wali kelas)
    // Asumsi: kolom foreign key di tabel ini adalah 'teacher_id' atau 'homeroom_teacher_id'
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id'); // Menggunakan 'teacher_id'
    }

    // Relasi ke Tahun Ajaran
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class, 'academic_year_id');
    }

    // Relasi ke GradeLevel (jika classroom_assignments punya grade_level_id langsung)
    // Jika grade_level ditentukan oleh Classroom, maka relasi ini ada di model Classroom
    public function gradeLevel()
    {
        return $this->belongsTo(GradeLevel::class, 'grade_level_id');
    }

    // Relasi ke ClassEnrollment (jika diperlukan koneksi langsung)
    // Ini mungkin one-to-one atau one-to-many tergantung desain Anda.
    // public function classEnrollment()
    // {
    //     return $this->belongsTo(ClassEnrollment::class, 'class_enrollments_id');
    // }
}