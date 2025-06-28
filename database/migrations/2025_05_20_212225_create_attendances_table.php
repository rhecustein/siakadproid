<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable(); // classroom/divisi
            $table->unsignedBigInteger('academic_year_id')->nullable();

            $table->string('role_type')->default('siswa'); // bebas isi: siswa, guru, staff, dll
            $table->enum('type', ['masuk', 'pulang'])->default('masuk');
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alfa'])->default('hadir');

            $table->date('date');
            $table->time('time')->nullable();
            $table->string('device')->nullable();
            $table->string('location')->nullable();
            $table->text('notes')->nullable();

            $table->boolean('is_manual')->default(false);

            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'date']);
            $table->index(['school_id', 'role_type']);

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
            $table->foreign('unit_id')->references('id')->on('units')->onDelete('set null');
            $table->foreign('academic_year_id')->references('id')->on('academic_years')->onDelete('set null');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
