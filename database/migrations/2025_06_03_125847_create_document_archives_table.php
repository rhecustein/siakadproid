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
        Schema::create('document_archives', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('category')->nullable(); // e.g. surat izin, raport, SK, dll
            $table->text('description')->nullable();
            $table->string('file_path');
            $table->date('archived_at');
            $table->foreignId('uploaded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_archives');
    }
};
