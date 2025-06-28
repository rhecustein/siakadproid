<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Tabel template fingerprint
        Schema::create('fingerprint_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('finger_position')->nullable(); // contoh: right_thumb, left_index
            $table->text('template_data'); // bisa diubah ke binary jika pakai SDK khusus
            $table->enum('device_type', ['absensi', 'kantin', 'lainnya'])->default('absensi');
            $table->timestamps();
        });

        // Tabel log hasil scan fingerprint
        Schema::create('fingerprint_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('scanned_at')->useCurrent();
            $table->enum('scan_type', ['absensi', 'pembayaran', 'parkir', 'lainnya'])->default('absensi');
            $table->string('device_id')->nullable();
            $table->enum('status', ['sukses', 'gagal', 'tidak dikenali'])->default('sukses');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fingerprint_logs');
        Schema::dropIfExists('fingerprint_templates');
    }
};
