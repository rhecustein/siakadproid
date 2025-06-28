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
      Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('owner_type'); // morph: class name
            $table->unsignedBigInteger('owner_id'); // morph: entity id (bisa student/parent)
            
            $table->decimal('balance', 12, 2)->default(0);
            $table->enum('status', ['active', 'suspended', 'closed'])->default('active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->unique(['owner_type', 'owner_id']); // ✅ hanya 1 wallet per entitas
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
