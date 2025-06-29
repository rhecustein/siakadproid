<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique(); // Nama izin (e.g., 'create_user', 'edit_profile')
            $table->string('guard_name'); // 'web', 'api', dll.
            $table->text('description')->nullable(); // Deskripsi izin
            $table->string('category')->nullable()->index(); // Untuk mengelompokkan izin di UI
            $table->timestamps();
        });
    
    }

    public function down(): void
    {
        $tableNames = config('permission.table_names');
        Schema::dropIfExists($tableNames['permissions'] ?? 'permissions');
    }
};
