<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('levels', function (Blueprint $table) {
        $table->id();
        $table->uuid('uuid')->unique();

        $table->string('name');            // e.g. SD, SMP, SMA, Tahfidz
        $table->string('slug')->unique();  // e.g. sd, smp, sma
        $table->string('type')->nullable(); // e.g. formal, non-formal, pesantren

        $table->integer('min_grade')->nullable(); // e.g. 1 or 7
        $table->integer('max_grade')->nullable(); // e.g. 6 or 12

        $table->integer('order')->default(0); // for sorting
        $table->boolean('is_active')->default(true); // if level still used
        $table->text('description')->nullable();

        $table->timestamps();
    });

    }

    public function down(): void
    {
        Schema::dropIfExists('levels');
    }
};
