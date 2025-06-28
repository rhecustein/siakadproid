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
        Schema::create('bill_groups', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'periode' atau 'event'
            $table->string('name'); // Contoh: "SPP SD Semester 1", "Study Tour 2025"
            $table->foreignId('level_id')->nullable()->constrained('levels')->nullOnDelete(); // jenjang sekolah
            $table->foreignId('grade_id')->nullable()->constrained('grade_levels')->nullOnDelete(); // kelas
            $table->foreignId('school_id')->nullable()->constrained('schools')->nullOnDelete(); // sekolah terkait
            $table->string('academic_year')->nullable();   // Format: 2024-2025
            $table->enum('gender', ['male', 'female'])->nullable(); // Filter berdasarkan jenis kelamin
            $table->integer('tagihan_count')->nullable(); // untuk periode (6/12 tagihan)
            $table->decimal('amount_per_tagihan', 12, 2)->nullable(); // default per tagihan
            $table->date('start_date')->nullable(); // awal periode tagihan
            $table->date('end_date')->nullable();   // akhir periode tagihan
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_groups');
    }
};
