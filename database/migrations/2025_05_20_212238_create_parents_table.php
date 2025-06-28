<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('user_id');  // Akun login
            $table->string('nik')->nullable();      // NIK atau ID wali (opsional nasional)
            $table->string('name');                 // Nama orang tua/wali
            $table->enum('gender', ['L', 'P'])->nullable(); // Jenis kelamin
            $table->enum('relationship', ['ayah', 'ibu', 'wali'])->nullable(); // Peran terhadap siswa
            $table->string('phone')->nullable();    // No HP utama
            $table->string('email')->nullable();    // Email login atau info
            $table->text('address')->nullable();
            $table->boolean('is_active')->default(true); // Untuk nonaktifkan wali jika perlu
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};
