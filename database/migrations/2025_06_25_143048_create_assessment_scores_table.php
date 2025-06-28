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
        Schema::create('assessment_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('daily_assessment_id');
            $table->unsignedBigInteger('criteria_id');
            $table->decimal('score', 5, 2)->nullable();
            $table->timestamps();

            $table->foreign('daily_assessment_id')->references('id')->on('daily_assessments')->onDelete('cascade');
            $table->foreign('criteria_id')->references('id')->on('assessment_criteria')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assessment_scores');
    }
};
