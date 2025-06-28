<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_years', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment
            $table->uuid('uuid')->unique(); // Untuk identifikasi publik (API/QR/etc)

            $table->string('name');            // Contoh: "2023/2024"
            $table->year('start_year');        // 2023
            $table->year('end_year');          // 2024
            $table->boolean('is_active')->default(false); // Menandai tahun aktif

            $table->timestamps();
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('school_years');
    }
};
