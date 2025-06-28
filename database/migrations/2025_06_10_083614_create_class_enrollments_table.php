<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('class_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_id')->constrained()->onDelete('cascade');
            $table->foreignId('level_id')->constrained()->onDelete('cascade');
            $table->foreignId('grade_level_id')->constrained()->onDelete('cascade'); // Tingkat (X, XI, XII)
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');    // Kelas (A, B, C)
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade'); // Tahun Ajaran
            $table->foreignId('semester_id')->nullable()->constrained()->onDelete('set null'); // Semester
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('class_enrollments');
    }
};
