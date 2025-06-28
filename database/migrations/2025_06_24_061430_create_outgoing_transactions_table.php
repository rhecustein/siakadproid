<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('outgoing_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete(); // Wallet sumber dana
            $table->decimal('amount', 15, 2);
            $table->string('method', 50); // tunai, transfer, pembayaran, refund, dll
            $table->string('recipient'); // Nama penerima dana (vendor/unit)

            $table->string('reference_number')->nullable(); // Referensi transfer/invoice
            $table->text('note')->nullable();

            $table->foreignId('issued_by')->nullable()->constrained('users')->nullOnDelete(); // Operator/admin

            $table->nullableMorphs('source'); // Polymorphic: source_type + source_id
            $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('outgoing_transactions');
    }
};
