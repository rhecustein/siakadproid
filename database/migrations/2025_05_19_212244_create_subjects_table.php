<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('subjects', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment
            $table->uuid('uuid')->unique(); // boleh tetap untuk kebutuhan publik

            // Ganti semua FK ke unsignedBigInteger
            $table->unsignedBigInteger('curriculum_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('major_id')->nullable();

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->enum('type', ['wajib', 'pilihan'])->default('wajib');
            $table->boolean('is_religious')->default(false);

            $table->integer('order')->default(0);
            $table->text('description')->nullable();
            $table->integer('kkm')->nullable();
            $table->string('group')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // Foreign keys ke ID BIGINT
            $table->foreign('curriculum_id')->references('id')->on('curriculums')->onDelete('set null');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
            $table->foreign('major_id')->references('id')->on('majors')->onDelete('set null');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
