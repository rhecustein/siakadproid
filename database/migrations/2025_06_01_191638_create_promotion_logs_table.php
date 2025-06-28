<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotion_logs', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('student_id');
        $table->unsignedBigInteger('from_classroom_id')->nullable(); // jika awal masuk, bisa null
        $table->unsignedBigInteger('to_classroom_id');
        $table->unsignedBigInteger('school_year_id');
        $table->unsignedBigInteger('semester_id')->nullable();
        $table->enum('type', ['naik_kelas', 'pindah_kelas'])->default('naik_kelas');

        $table->timestamp('promoted_at')->useCurrent();
        $table->timestamps();

        // Foreign Keys
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        $table->foreign('from_classroom_id')->references('id')->on('classrooms')->onDelete('set null');
        $table->foreign('to_classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('set null');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_logs');
    }
};
