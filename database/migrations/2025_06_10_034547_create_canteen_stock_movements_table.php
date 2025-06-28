<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanteenStockMovementsTable extends Migration
{
    public function up(): void
    {
        Schema::create('canteen_stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('canteen_product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out']);
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2); // harga satuan pada saat transaksi
            $table->string('reference_type')->nullable(); // 'purchase', 'sale', 'opname'
            $table->unsignedBigInteger('reference_id')->nullable(); // id dari transaksi terkait
            $table->timestamp('moved_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canteen_stock_movements');
    }
}
