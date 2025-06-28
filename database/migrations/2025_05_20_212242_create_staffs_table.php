<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('school_id');

            $table->string('nip')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('marital_status')->nullable(); // Menikah/Belum
            $table->string('religion')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();

            $table->string('position')->nullable();    
            $table->string('department')->nullable();
            $table->string('employment_status')->nullable(); // Honorer, Tetap, Kontrak
            $table->date('join_date')->nullable();
            $table->date('end_date')->nullable(); // jika nonaktif/resign

            $table->string('education_level')->nullable(); // SMA/S1/S2
            $table->string('last_education_institution')->nullable();
            $table->text('address')->nullable();
            $table->text('photo')->nullable(); // path foto
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};
