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
        Schema::create('bill_groups', function (Blueprint $table) {
            $table->id();

            $table->string('type'); // periode atau event
            $table->string('name');
            
            $table->unsignedBigInteger('level_id')->nullable();
            $table->unsignedBigInteger('grade_id')->nullable();
            $table->unsignedBigInteger('school_id');
            $table->unsignedBigInteger('academic_year_id');
            $table->unsignedBigInteger('bill_type_id'); // <-- PASTIKAN INI ADA

            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('tagihan_count')->default(1);
            $table->integer('amount_per_tagihan')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bill_groups');
    }
};
