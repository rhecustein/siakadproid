<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Grade extends Model
{
    use HasFactory;

    protected $table = 'grades';

    protected $fillable = [
        'uuid',
        'student_id',
        'nilai_tugas',
        'nilai_uts',
        'nilai_uas',
        'rata_rata',
        'status_lulus',
    ];

    protected $casts = [
        'nilai_tugas'   => 'float',
        'nilai_uts'     => 'float',
        'nilai_uas'     => 'float',
        'rata_rata'     => 'float',
        'status_lulus'  => 'boolean',
    ];

    /**
     * Boot method to auto-generate UUID if not set.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /**
     * Relasi ke model Student
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classroom() { 
        return $this->belongsTo(Classroom::class); 
    }

    public function subject() {
         return $this->belongsTo(Subject::class); 
     }
}
