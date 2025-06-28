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
       Schema::create('bsi_va_logs', function (Blueprint $table) {
        $table->id();
        $table->string('type'); // inquiry, payment, advice
        $table->json('request_data')->nullable();
        $table->json('response_data')->nullable();
        $table->string('status')->default('pending'); // success, error, timeout
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bsi_va_logs');
    }
};
