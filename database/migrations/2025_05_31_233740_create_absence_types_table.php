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
        Schema::create('absence_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();     // contoh: sholat, tidur_malam
            $table->string('label')->nullable();  // nama yang ditampilkan
            $table->string('group')->nullable();  // kategori: sekolah, asrama, ibadah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absence_types');
    }
};
