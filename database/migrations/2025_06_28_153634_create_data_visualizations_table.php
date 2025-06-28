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
        Schema::create('data_visualizations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // e.g., 'diagram', 'chart', 'statistic'
            $table->json('data_source')->nullable(); // Store the data used for visualization
            $table->string('image_path')->nullable(); // Path to the generated image file
            $table->text('description')->nullable();
            $table->foreignId('conversation_id')->nullable()->constrained('conversations')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_visualizations');
    }
};
