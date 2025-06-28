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
        Schema::create('canteen_product_stocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canteen_product_id')->constrained()->onDelete('cascade');
            $table->integer('stock_in')->default(0);
            $table->integer('stock_out')->default(0);
            $table->enum('stock_type', ['initial', 'purchase', 'sale', 'adjustment']);
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canteen_product_stocks');
    }
};
