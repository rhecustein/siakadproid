<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('grade_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();
            $table->foreignId('to_classroom_id')->nullable()->constrained('classrooms')->nullOnDelete();
            $table->timestamp('promoted_at')->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('grade_promotions');
    }
};
