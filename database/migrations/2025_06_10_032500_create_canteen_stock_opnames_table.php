<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCanteenStockOpnamesTable extends Migration
{
    public function up(): void
    {
        Schema::create('canteen_stock_opnames', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('canteen_products')->onDelete('cascade');
            $table->date('opname_date');
            $table->integer('system_stock'); // stok menurut sistem
            $table->integer('real_stock');   // stok nyata hasil cek fisik
            $table->integer('difference')->nullable(); // real - system
            $table->text('note')->nullable(); // keterangan perbedaan
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('canteen_stock_opnames');
    }
}

