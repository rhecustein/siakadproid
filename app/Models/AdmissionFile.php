<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdmissionFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'admission_id',
        'file_type',
        'file_path',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}
