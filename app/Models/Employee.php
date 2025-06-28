<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $table = 'employees'; // pastikan ini sesuai tabel di migration

    protected $fillable = [
        'user_id',
        'nip',
        'name',
        'position',
        'department',
        'gender',
        'marital_status',
        'religion',
        'phone',
        'email',
        'birth_date',
        'birth_place',
        'join_date',
        'end_date',
        'education_level',
        'last_education_institution',
        'address',
        'photo',
        'status',
        'school_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'join_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * Relasi ke user (akun login, jika ada)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke absensi
     */
    public function attendances()
    {
        return $this->hasMany(EmployeeAttendance::class, 'employee_id');
    }

    /**
     * Relasi ke penilaian kinerja
     */
    public function performanceReviews()
    {
        return $this->hasMany(PerformanceReview::class, 'employee_id');
    }

    /**
     * Relasi ke data gaji/payroll
     */
    public function payrolls()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    //school
    public function school()
    {   
        return $this->belongsTo(School::class);
    }
}

