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
       Schema::create('model_has_roles', function (Blueprint $table) {
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');

            $table->morphs('model'); // Menambahkan model_type (string) dan model_id (unsignedBigInteger)
            // Contoh: model_type = 'App\Models\User', model_id = 1

            $table->unique(['role_id', 'model_id', 'model_type']); // Compound unique key
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('model_has_roles');
    }
};
