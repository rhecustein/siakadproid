<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PerformanceReview extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'staff_id',
        'review_date',
        'score',
        'strengths',
        'weaknesses',
        'suggestions',
        'reviewed_by',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
