<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment
            $table->uuid('uuid')->unique(); // opsional untuk kebutuhan publik/API

            $table->foreignId('grade_level_id')->nullable()->constrained()->onDelete('set null');
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('academic_year_id')->nullable();
            $table->unsignedBigInteger('curriculum_id')->nullable();

            $table->string('name');              // e.g. X IPA 1
            $table->string('alias')->nullable(); // Optional short name
            $table->string('room')->nullable();  // Room info

            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Foreign keys (semua menggunakan BIGINT)
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
            $table->foreign('curriculum_id')->references('id')->on('curriculums')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};

