<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'registration_number',
        'full_name',
        'nisn',
        'gender',
        'birth_date',
        'birth_place',
        'previous_school',
        'phone',
        'email',
        'address',
        'status',
    ];

    public function files()
    {
        return $this->hasMany(AdmissionFile::class);
    }

    public function selection()
    {
        return $this->hasOne(AdmissionSelection::class);
    }

    //payments
    public function payments()
    {
        return $this->hasMany(AdmissionPayment::class);
    }
}
