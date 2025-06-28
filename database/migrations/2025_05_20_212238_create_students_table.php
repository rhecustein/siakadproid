<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('user_id');        // akun login siswa
            $table->unsignedBigInteger('school_id');      // sekolah induk
            $table->unsignedBigInteger('grade_id')->nullable(); // kelas siswa
            $table->unsignedBigInteger('parent_id')->nullable(); // wali utama

            // Identitas
            $table->string('nis')->unique()->nullable();   // Nomor Induk Sekolah
            $table->string('nisn')->unique()->nullable();  // Nomor Nasional
            $table->string('name');
            $table->enum('gender', ['L', 'P'])->nullable();
            $table->string('place_of_birth')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->text('address')->nullable();

            // Status dan masuk
            $table->string('student_status')->default('aktif');
            $table->date('admission_date')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('religion')->nullable();
            $table->string('phone')->nullable();
            $table->string('photo')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Foreign Keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
            $table->foreign('grade_id')->references('id')->on('grade_levels')->onDelete('cascade');
            $table->foreign('parent_id')->references('id')->on('parents')->onDelete('set null');
        });


    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
