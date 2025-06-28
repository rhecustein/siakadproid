<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_files', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment
            $table->uuid('uuid')->unique(); // opsional untuk identitas publik/API

            $table->unsignedBigInteger('announcement_id'); // FK ke announcements.id

            $table->string('file_path');              // path ke storage
            $table->string('file_name')->nullable();  // nama asli file
            $table->string('mime_type')->nullable();  // pdf, jpg, docx, etc
            $table->integer('file_size')->nullable(); // ukuran file (KB)
            $table->string('file_type')->nullable();  // dokumen, gambar, video, lainnya

            $table->boolean('is_main')->default(false); // untuk thumbnail atau file utama
            $table->timestamps();

            // Foreign Key
            $table->foreign('announcement_id')
                ->references('id')->on('announcements')
                ->onDelete('cascade');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_files');
    }
};
