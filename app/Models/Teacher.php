<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'uuid',
        'user_id',
        'school_id',
        'nip',
        'nuptk',
        'nidn',
        'name',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'position',
        'employment_status',
        'type',
        'join_date',
        'phone',
        'email',
        'address',
        'photo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'join_date' => 'date',
        'date_of_birth' => 'date',
    ];

    protected static function booted()
    {
        static::creating(function ($teacher) {
            $teacher->uuid = (string) Str::uuid();
        });
    }

    // Relasi ke akun user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke sekolah induk
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // Relasi ke penugasan wali kelas
    public function homeroomAssignments()
    {
        return $this->hasMany(HomeroomAssignment::class);
    }

    // Ambil wali kelas aktif tahun ini
    public function activeHomeroomAssignment()
    {
        return $this->homeroomAssignments()
                    ->where('is_active', true)
                    ->latest('academic_year_id');
    }

    public function classroomSubjects()
    {
        return $this->hasManyThrough(Subject::class, ClassroomSubject::class, 'teacher_id', 'id', 'id', 'subject_id');
    }

}
