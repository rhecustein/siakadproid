<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('memorization_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('date');
            $table->string('surah')->nullable();
            $table->string('ayat_start')->nullable();
            $table->string('ayat_end')->nullable();
            $table->integer('juz')->nullable();
            $table->text('note')->nullable();
            $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->timestamps();
        });

    }

    public function down(): void {
        Schema::dropIfExists('memorization_reports');
    }
};
