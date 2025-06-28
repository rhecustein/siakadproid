<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchoolYear extends Model
{
    protected $fillable = ['name', 'is_active'];

    public function semesters()
    {
        return $this->hasMany(Semester::class);
    }
}
