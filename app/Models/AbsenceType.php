<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbsenceType extends Model
{
    protected $fillable = ['name', 'label', 'group'];

    public function records()
    {
        return $this->hasMany(AbsenceRecord::class);
    }
}
