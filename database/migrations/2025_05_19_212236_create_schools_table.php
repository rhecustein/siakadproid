<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade')->nullable();
            $table->string('name');              // Nama sekolah (SD Al-Bahjah)
            $table->string('slug')->unique();    // slug untuk URL (sd-albahjah)
            $table->string('npsn')->nullable();  // Nomor Pokok Sekolah Nasional
            $table->string('type')->nullable();  // formal, diniyah, pondok, dll
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
