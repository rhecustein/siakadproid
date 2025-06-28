<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
      Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique()->nullable();

            $table->string('name')->unique();           // e.g., admin, guru
            $table->string('display_name')->nullable(); // readable name
            $table->string('guard_name')->default('web');

            // Saran tambahan:
            $table->string('description')->nullable(); // menjelaskan peran lebih detail
            $table->json('scope')->nullable();         // jika ingin membatasi role ke unit tertentu (SD/SMP/SMA)

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
