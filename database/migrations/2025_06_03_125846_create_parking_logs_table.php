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
        Schema::create('parking_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->nullable()->constrained()->nullOnDelete();;
            $table->foreignId('parent_id')->nullable()->constrained('parents')->nullOnDelete();;
            $table->string('vehicle_number')->nullable();
            $table->string('rfid_tag')->nullable();
            $table->dateTime('entry_time');
            $table->dateTime('exit_time')->nullable();
            $table->decimal('fee', 10, 2)->default(0);
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_logs');
    }
};
