<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('semester_id')->constrained()->onDelete('cascade');
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->boolean('finalized')->default(false)->comment('Apakah rapor sudah final atau masih bisa diedit');
            $table->text('note')->nullable()->comment('Catatan tambahan dari wali kelas atau pengelola rapor');
            $table->timestamps();
            $table->softDeletes();
            $table->unique(['student_id', 'semester_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_cards');
    }
};

