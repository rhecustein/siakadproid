<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('semesters', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment
            $table->uuid('uuid')->unique(); // Optional: identitas publik

            $table->unsignedBigInteger('school_year_id'); // FK BIGINT yang cocok
            $table->string('name'); // Ganjil, Genap, dst
            $table->enum('type', ['ganjil', 'genap'])->default('ganjil');
            $table->boolean('is_active')->default(false);

            $table->timestamps();

            // Foreign Key
            $table->foreign('school_year_id')->references('id')->on('school_years')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('semesters');
    }
};
