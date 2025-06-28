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
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('wallet_id');
            $table->enum('transaction_type', [
                'topup',         // top up dari admin/gateway
                'transfer_in',   // terima transfer
                'transfer_out',  // kirim ke wallet lain
                'payment',       // transaksi (kantin, spp, dll)
                'refund'         // pengembalian saldo
            ]);
            $table->decimal('amount', 12, 2);

            $table->enum('channel', ['manual', 'va_bank', 'gateway', 'system'])->default('manual');
            $table->enum('status', ['pending', 'success', 'failed'])->default('success');

            $table->string('reference_no')->nullable();
            $table->unsignedBigInteger('executed_by')->nullable();
            $table->timestamp('verified_at')->nullable();

            $table->string('description')->nullable();
            $table->json('meta')->nullable();

            $table->nullableMorphs('related'); // related_type dan related_id

            $table->timestamps();

            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
            $table->foreign('executed_by')->references('id')->on('users')->nullOnDelete();
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
