<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('majors', function (Blueprint $table) {
            $table->id(); // BIGINT auto-increment
            $table->string('uuid')->unique(); // Optional jika tetap mau UUID publik

            $table->unsignedBigInteger('level_id')->nullable();  // FK ke levels.id
            $table->unsignedBigInteger('school_id')->nullable(); // FK ke schools.id

            $table->string('name');
            $table->string('slug')->unique();
            $table->string('code')->nullable();
            $table->text('description')->nullable();

            $table->enum('type', ['academic', 'vocational', 'religious', 'special'])->default('academic');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);

            $table->timestamps();

            // Foreign keys
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('set null');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('majors');
    }
};
