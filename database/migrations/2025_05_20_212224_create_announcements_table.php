<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('announcements', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment
            $table->uuid('uuid')->unique(); // opsional untuk identifikasi publik

            $table->unsignedBigInteger('school_id')->nullable(); // FK ke schools
            $table->unsignedBigInteger('user_id');               // FK ke users (pembuat)

            $table->string('title');
            $table->text('content');

            $table->enum('category', ['informasi', 'jadwal', 'keuangan', 'darurat', 'lainnya'])->default('informasi');
            $table->enum('priority', ['normal', 'tinggi', 'mendesak'])->default('normal');
            $table->boolean('is_pinned')->default(false);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_public')->default(false);
            $table->enum('target', ['all', 'guru', 'ortu', 'siswa'])->default('all');

            $table->timestamp('published_at')->nullable();
            $table->timestamp('expired_at')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
