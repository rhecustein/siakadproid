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
        Schema::create('quran_readings', function (Blueprint $table) {
            $table->id();
            $table->date('recorded_at');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->string('surah');
            $table->string('ayat_start')->nullable();
            $table->string('ayat_end')->nullable();
            $table->enum('method', ['langsung', 'dengan guru', 'daring'])->default('langsung');
            $table->enum('status', ['hadir', 'tidak hadir', 'izin', 'sakit'])->default('hadir');
            $table->text('note')->nullable();
            $table->string('attachment_path')->nullable(); // optional proof (audio/image/video)
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quran_readings');
    }
};
