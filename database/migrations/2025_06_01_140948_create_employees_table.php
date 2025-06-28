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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('school_id')->nullable()->constrained('schools')->onDelete('set null');
            $table->string('nip')->unique()->nullable();
            $table->string('name')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('marital_status')->nullable(); // Menikah/Belum
            $table->string('religion')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique()->nullable();
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();
            $table->date('join_date')->nullable();
            $table->date('end_date')->nullable(); // jika nonaktif/resign
            $table->string('education_level')->nullable(); // SMA/S1/S2 dll
            $table->string('last_education_institution')->nullable();
            $table->text('address')->nullable();
            $table->text('photo')->nullable(); // simpan path file jika ada upload
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
