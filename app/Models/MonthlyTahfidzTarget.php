<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyTahfidzTarget extends Model
{
    protected $fillable = ['student_id', 'year', 'month', 'target_juz', 'achieved_juz', 'note'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
