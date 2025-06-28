<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionSelection extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admission_id',
        'selection_date',
        'result',
        'notes',
        'assessed_by',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }

    public function assessor()
    {
        return $this->belongsTo(User::class, 'assessed_by');
    }
}
