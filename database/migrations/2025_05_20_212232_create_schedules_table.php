<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('schedules', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique();

        $table->foreignId('teacher_id')->constrained()->onDelete('cascade');
        $table->foreignId('school_id')->constrained()->onDelete('cascade');
        $table->foreignId('subject_id')->constrained()->onDelete('cascade');
        $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
        $table->foreignId('room_id')->nullable()->constrained()->onDelete('set null');
        $table->foreignId('lesson_time_id')->constrained()->onDelete('cascade');

        $table->enum('day', ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']);
        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};