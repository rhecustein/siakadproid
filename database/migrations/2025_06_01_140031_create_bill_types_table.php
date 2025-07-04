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
       Schema::create('bill_types', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('name')->unique();
            $table->string('code')->unique();
            $table->string('description')->nullable();

            // --- KOLOM BARU YANG DITAMBAHKAN ---
            $table->boolean('is_online_payment')->default(false)->comment('Apakah tipe tagihan ini bisa dibayar online');
            $table->boolean('is_monthly')->default(false)->comment('Apakah tipe tagihan ini adalah tagihan bulanan');
            // --- AKHIR KOLOM BARU ---

            $table->boolean('is_active')->default(true); // Pastikan ini ada dan tetap

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_types');
    }
};
