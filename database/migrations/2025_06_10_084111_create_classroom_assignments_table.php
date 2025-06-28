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
        Schema::create('classroom_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grade_level_id')->constrained()->onDelete('cascade'); // X, XI, XII
            $table->foreignId('class_enrollments_id')->constrained()->onDelete('cascade'); // Class Enrollments
            $table->foreignId('classroom_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "A", "B"
            $table->foreignId('homeroom_teacher_id')->nullable()->constrained('teachers')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_assignments');
    }
};
