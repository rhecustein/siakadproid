<?php

namespace App\Http\Controllers\Academic;

use App\Http\Controllers\Controller;
use App\Models\GradePromotion;

class GradePromotionController extends Controller
{
    public function index()
    {
        $promotions = GradePromotion::with(['student', 'fromClassroom', 'toClassroom'])->get();
        return view('academics.grade_promotions.index', compact('promotions'));
    }
}
