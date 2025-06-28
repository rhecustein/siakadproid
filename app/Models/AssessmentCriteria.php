<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentCriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'title',
        'weight',
        'description',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
