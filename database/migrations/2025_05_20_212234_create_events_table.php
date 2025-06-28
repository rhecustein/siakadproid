<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->unsignedBigInteger('school_id')->nullable();
            $table->unsignedBigInteger('event_type_id')->nullable(); // jenis acara
            $table->string('title');
            $table->text('description')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->boolean('is_holiday')->default(false);
            $table->boolean('is_public')->default(true); // untuk semua user atau internal
            $table->timestamps();

            $table->foreign('school_id')->references('id')->on('schools')->onDelete('set null');
            $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
