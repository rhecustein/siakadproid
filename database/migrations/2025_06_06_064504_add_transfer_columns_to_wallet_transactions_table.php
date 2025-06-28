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
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->string('transfer_type')->nullable()->after('transaction_type'); // tagihan, saldo_anak, donasi
            $table->unsignedBigInteger('target_id')->nullable()->after('transfer_type');
            $table->string('target_type')->nullable()->after('target_id'); // polymorphic type
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wallet_transactions', function (Blueprint $table) {
            $table->dropColumn(['transfer_type', 'target_id', 'target_type']);
        });
    }
};
