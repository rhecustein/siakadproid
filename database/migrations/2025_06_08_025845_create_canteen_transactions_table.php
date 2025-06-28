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
       Schema::create('canteen_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('canteen_id')->constrained()->onDelete('cascade'); // unit kantin
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade'); // santri yang bertransaksi
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // jika ada akun user non-santri

            $table->enum('type', ['sale', 'topup', 'refund', 'expense', 'income']);
            $table->dateTime('transaction_date')->useCurrent();
            $table->decimal('amount', 12, 2); // nominal transaksi
            $table->decimal('total_amount', 12, 2)->nullable(); // bisa digunakan untuk penjualan multi-item

            $table->text('items')->nullable(); // JSON array of items
            $table->text('note')->nullable();

            $table->foreignId('processed_by')->nullable()->constrained('users')->nullOnDelete(); // kasir
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete(); // sistem/admin

            $table->timestamps();
            $table->softDeletes();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('canteen_transactions');
    }
};
