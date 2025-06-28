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
        Schema::create('monthly_tahfidz_targets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->year('year');
            $table->tinyInteger('month'); // 1-12
            $table->integer('target_juz')->default(0);
            $table->integer('achieved_juz')->default(0);
            $table->text('note')->nullable();
            $table->timestamps();

            $table->unique(['student_id', 'year', 'month']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_tahfidz_targets');
    }
};
