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
        Schema::create('homeroom_assignments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('teacher_id');
            $table->unsignedBigInteger('classroom_id');
            $table->unsignedBigInteger('academic_year_id');

            // 🔽 Tambahan yang disarankan
            $table->date('assigned_at')->nullable();       // tanggal mulai menjadi wali
            $table->text('note')->nullable();              // catatan internal atau alasan penugasan
            $table->boolean('is_active')->default(true);   // bisa menonaktifkan wali tanpa hapus data

            $table->timestamps();

            $table->unique(['classroom_id', 'academic_year_id']); // HANYA 1 wali per kelas per tahun ajaran

            // FK
            $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homeroom_assignments');
    }
};
