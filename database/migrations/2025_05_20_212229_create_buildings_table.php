<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('buildings', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->string('name');
            $table->string('code')->unique()->nullable(); // kode unik bangunan
            $table->string('type')->nullable(); // asrama, kelas, kantor, lab, dll
            $table->integer('floor_count')->nullable(); // jumlah lantai
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('buildings');
    }
};
