<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bills', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('bill_group_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('bill_type_id')->constrained('bill_types')->onDelete('restrict'); // relasi ke bill_types

            $table->string('title');
            $table->decimal('total_amount', 12, 2);
            $table->date('start_date')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('status', ['unpaid', 'partial', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
