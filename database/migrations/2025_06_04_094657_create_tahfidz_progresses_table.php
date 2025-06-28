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
        Schema::create('tahfidz_progresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->integer('juz')->nullable();              // contoh: 1 - 30
            $table->string('surah')->nullable();             // contoh: Al-Baqarah
            $table->string('ayat_start')->nullable();        // contoh: 1
            $table->string('ayat_end')->nullable();          // contoh: 20
            $table->date('date')->nullable();                // kapan dituntaskan
            $table->enum('status', ['belum', 'proses', 'hafal'])->default('belum');
            $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahfidz_progresses');
    }
};
