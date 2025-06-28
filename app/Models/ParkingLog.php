<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ParkingLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_id',
        'parent_id',
        'vehicle_number',
        'rfid_tag',
        'entry_time',
        'exit_time',
        'fee',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function parent()
    {
        return $this->belongsTo(ParentModel::class); // ganti dengan model orang tua jika bukan `Parent`
    }
}
