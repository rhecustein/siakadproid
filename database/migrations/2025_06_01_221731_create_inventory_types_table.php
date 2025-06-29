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
        Schema::create('inventory_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama tipe barang, contoh: Elektronik, Furniture
            $table->boolean('is_electronic')->default(false); // Apakah termasuk barang elektronik

            // --- KOLOM BARU YANG DITAMBAHKAN ---
            $table->boolean('is_consumable')->default(false)->comment('Apakah tipe inventaris ini habis pakai');
            // --- AKHIR KOLOM BARU ---

            $table->integer('economic_life')->nullable(); // Umur ekonomis default (tahun)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_types');
    }
};
