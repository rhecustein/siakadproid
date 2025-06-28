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
      Schema::create('gl_categories', function (Blueprint $table) {
        $table->id(); // Penting! -> PRIMARY & unsignedBigInteger
        $table->string('code')->unique();
        $table->string('name');
        $table->enum('type', ['asset', 'liability', 'equity', 'income', 'expense']);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gl_categories');
    }
};
