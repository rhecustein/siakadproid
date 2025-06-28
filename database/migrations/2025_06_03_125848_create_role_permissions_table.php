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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->string('permission');      // nama izin: e.g., 'absensi.view'
            $table->boolean('allowed')->default(true);

            // Saran tambahan:
            $table->string('context')->nullable();     // misal: 'siswa', 'kantin', 'admin' (opsional)
            $table->json('conditions')->nullable();    // misal: batas hari, waktu, dsb (opsional)

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['role_id', 'permission']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
