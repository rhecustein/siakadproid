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
        Schema::create('tahfidz_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('recorded_at');
            $table->integer('juz'); // 1-30
            $table->string('from_surah')->nullable();
            $table->string('to_surah')->nullable();
            $table->string('from_verse')->nullable();
            $table->string('to_verse')->nullable();
            $table->text('remarks')->nullable();

            // ✅ Penambahan disarankan:
            $table->enum('status', ['belum', 'proses', 'hafal'])->default('proses');
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_final')->default(false);

            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tahfidz_progress');
    }
};
