<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');

            // FK ke classrooms.id (pastikan classrooms.id = uuid)
            $table->unsignedBigInteger('classroom_id');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');

            // FK ke academic_years
            $table->unsignedBigInteger('academic_year_id');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');

            // FK ke students
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

            $table->enum('semester', ['ganjil', 'genap']);

            $table->timestamps();

            $table->unique(['student_id', 'subject_id', 'academic_year_id', 'semester'], 'unique_enrollment');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
