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
        Schema::create('bank_accounts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('account_number')->unique();
            $table->string('account_holder');
            $table->string('bank_name');
            $table->string('bank_code')->nullable();
            
            $table->unsignedBigInteger('school_id');
            $table->foreign('school_id')->references('id')->on('schools')->onDelete('cascade');

            $table->boolean('online_payment')->default(false);
            $table->boolean('for_students')->default(false);
            $table->boolean('for_teachers')->default(false);
            $table->boolean('for_male')->default(false);
            $table->boolean('for_female')->default(false);

            $table->boolean('can_pay_bills')->default(false);
            $table->boolean('can_save')->default(false);
            $table->boolean('can_donate')->default(false);

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_accounts');
    }
};
