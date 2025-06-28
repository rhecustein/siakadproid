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
        Schema::create('student_illnesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->date('reported_at');
            $table->string('illness_type');
            $table->string('severity')->nullable(); // e.g. mild, moderate, severe
            $table->text('symptoms')->nullable();
            $table->string('status')->default('under_treatment'); // under_treatment, recovered, referred
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_illnesses');
    }
};
