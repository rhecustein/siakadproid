<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'daily_assessment_id',
        'criteria_id',
        'score',
    ];

    public function dailyAssessment()
    {
        return $this->belongsTo(DailyAssessment::class);
    }

    public function criteria()
    {
        return $this->belongsTo(AssessmentCriteria::class);
    }
}
