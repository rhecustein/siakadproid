<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
     Schema::create('teachers', function (Blueprint $table) {
        $table->id(); // BIGINT auto-increment (default PK)
        $table->uuid('uuid')->unique(); // opsional untuk identitas publik (URL, API, dsb)

        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('school_id');

        $table->string('nip')->nullable();
        $table->string('nuptk')->nullable();
        $table->string('nidn')->nullable();
        $table->string('name');

        $table->enum('gender', ['L', 'P'])->nullable();
        $table->string('place_of_birth')->nullable();
        $table->date('date_of_birth')->nullable();

        $table->string('position')->nullable();
        $table->string('employment_status')->nullable();
        $table->string('type')->nullable();
        $table->date('join_date')->nullable();

        $table->string('phone')->nullable();
        $table->string('email')->nullable();
        $table->text('address')->nullable();
        $table->string('photo')->nullable();

        $table->boolean('is_active')->default(true);
        $table->timestamps();

        // Foreign Keys
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
