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
        Schema::create('memorization_submissions', function (Blueprint $table) {
            $table->id();
            $table->date('recorded_at');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->string('surah');
            $table->string('ayat_start')->nullable();
            $table->string('ayat_end')->nullable();
            $table->enum('type', ['ziyadah', 'murojaah', 'tilawah'])->default('ziyadah');
            $table->enum('status', ['belum lancar', 'cukup', 'baik', 'sangat baik'])->default('cukup');
            $table->tinyInteger('score')->nullable();
            $table->text('note')->nullable();
            $table->string('attachment_path')->nullable();
            $table->foreignId('semester_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('validated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->boolean('is_validated')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('memorization_submissions');
    }
};
