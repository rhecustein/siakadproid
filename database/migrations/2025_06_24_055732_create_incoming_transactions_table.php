<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('incoming_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained()->cascadeOnDelete(); // tujuan dana masuk
            $table->decimal('amount', 15, 2);
            $table->string('method', 50); // tunai, transfer, topup, donasi, dll
            $table->string('reference_number')->nullable(); // optional bukti / nomor VA
            $table->text('note')->nullable();

            $table->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete(); // user/operator

            $table->nullableMorphs('source'); // polymorphic: source_type + source_id
            $table->enum('status', ['pending', 'confirmed', 'failed'])->default('pending');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('incoming_transactions');
    }
};

