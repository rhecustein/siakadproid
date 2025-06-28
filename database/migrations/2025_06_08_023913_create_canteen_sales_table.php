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
        Schema::create('canteen_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canteen_id')->constrained()->onDelete('cascade');
            $table->enum('buyer_type', ['student', 'parent', 'guest']);
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->enum('payment_method', ['wallet', 'cash']);
            $table->enum('auth_method', ['rfid', 'fingerprint', 'manual']);
            $table->decimal('total_amount', 10, 2);
            $table->boolean('paid')->default(true);
            $table->unsignedBigInteger('cashier_id')->nullable();
            $table->timestamp('transaction_time')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canteen_sales');
    }
};
