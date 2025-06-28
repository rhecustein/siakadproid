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
        Schema::create('grade_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_input_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained();
            $table->float('score');
            $table->text('note')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_details');
    }
};
