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
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama barang (Meja, Kursi, Proyektor)
            $table->string('code')->unique(); // Kode inventaris unik
            $table->foreignId('room_id')->constrained()->onDelete('cascade'); // Relasi ke ruangan
            $table->foreignId('inventory_type_id')->constrained()->onDelete('restrict'); // Tipe barang
            $table->foreignId('inventory_condition_id')->nullable()->constrained()->onDelete('set null'); // Kondisi barang
            $table->integer('quantity')->default(1); // Jumlah unit
            $table->boolean('is_electronic')->default(false); // Apakah elektronik
            $table->date('acquired_at')->nullable(); // Tanggal perolehan
            $table->integer('economic_life')->nullable(); // Umur ekonomis aktual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
