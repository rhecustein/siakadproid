<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PermissionSchool extends Model
{
    use HasFactory;

    protected $table = 'permission_schools';

    protected $fillable = [
        'uuid',
        'student_id',
        'leave_date',
        'return_date',
        'reason',
        'status',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
