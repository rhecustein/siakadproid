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
    Schema::create('lesson_times', function (Blueprint $table) {
        $table->id();
        $table->unsignedInteger('order'); // jam ke-1, 2, ...
        $table->time('start_time');
        $table->time('end_time');
        $table->boolean('is_break')->default(false); // opsional: penanda jam istirahat

        // Untuk filter per sekolah/tahun ajaran
        $table->foreignId('school_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('academic_year_id')->nullable()->constrained()->onDelete('cascade');

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_times');
    }
};
