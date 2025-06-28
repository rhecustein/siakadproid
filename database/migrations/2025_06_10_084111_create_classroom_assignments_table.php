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
        // Ganti nama tabel jika 'classroom_assignments' sebelumnya digunakan untuk hal lain
        // Jika tabel sebelumnya sudah ada dan fungsinya berbeda, buat migrasi baru dengan nama yang lebih tepat
        // seperti 'student_class_assignments' atau 'student_classroom_enrollments'
        Schema::create('classroom_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Siswa yang ditugaskan
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade'); // Kelas (ruangan fisik/logical)
            $table->foreignId('academic_year_id')->constrained()->onDelete('cascade'); // Tahun ajaran penugasan
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->onDelete('set null'); // Wali kelas untuk penugasan ini (opsional)

            $table->string('status')->default('active'); // e.g., 'active', 'inactive', 'transferred'
            $table->boolean('is_active')->default(true); // Status aktif penugasan
            $table->text('notes')->nullable(); // Catatan tambahan
            $table->timestamp('assigned_at')->useCurrent(); // Kapan penugasan dilakukan

            // Unique constraint: Seorang siswa hanya bisa di satu kelas di satu tahun ajaran
            $table->unique(['student_id', 'academic_year_id']);

            // Opsional: Satu kelas hanya bisa punya satu wali kelas di satu tahun ajaran
            // Jika homeroom_teacher_id adalah wali kelas untuk kelas itu secara umum, bukan hanya untuk siswa ini
            // $table->unique(['classroom_id', 'academic_year_id', 'teacher_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_assignments');
    }
};
