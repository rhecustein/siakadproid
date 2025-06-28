<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // optional: string, boolean, image, etc.
            $table->string('group')->nullable(); // misal: general, email, ui, academic
            $table->text('description')->nullable(); // tooltip/penjelasan admin
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configs');
    }
};
