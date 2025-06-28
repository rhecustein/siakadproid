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
     Schema::create('absence_records', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('student_id');
        $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');

        $table->unsignedBigInteger('absence_type_id'); // fix: jika Anda pakai UUID
        $table->foreign('absence_type_id')->references('id')->on('absence_types')->onDelete('restrict');

        $table->date('date');
        $table->string('time_segment')->nullable(); // contoh: subuh, futhur, asya
        $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa', 'pulang', 'ghoib']);
        $table->text('remarks')->nullable();

        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absence_records');
    }
};
