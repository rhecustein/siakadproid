<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('session_logins', function (Blueprint $table) {
            $table->id();

            // Relasi ke pengguna
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Info sesi login
            $table->string('session_id')->nullable();           // Laravel session ID atau UUID
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();           // Info browser/device
            $table->string('device')->nullable();               // Contoh: "mobile", "desktop"

            // Lokasi login
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->decimal('latitude', 10, 6)->nullable();      // Koordinat lokasi
            $table->decimal('longitude', 10, 6)->nullable();

            // Status login
            $table->boolean('success')->default(false);         // Berhasil login atau tidak

            // Waktu aktif
            $table->timestamp('logged_in_at')->nullable();       // Saat login berhasil/gagal
            $table->timestamp('last_activity_at')->nullable();   // Diupdate saat aktivitas user
            $table->timestamp('logged_out_at')->nullable();      // Logout manual/otomatis

            // Status sesi login
            $table->boolean('is_active')->default(true);         // false jika logout/manual/auto

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_logins');
    }
};
