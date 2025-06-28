<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('curriculums', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');                  // e.g. Kurikulum Merdeka, K13
            $table->string('code')->nullable();      // e.g. K13, K-MDK
            $table->text('description')->nullable(); // General explanation
            $table->year('start_year')->nullable();  // year it starts
            $table->year('end_year')->nullable();    // null = still active
            $table->boolean('is_active')->default(false);
            $table->enum('level_group', ['sd', 'smp', 'sma', 'ponpes'])->nullable(); // untuk menyaring per jenjang
            $table->json('applicable_grades')->nullable(); // daftar kelas yang berlaku (misal: ["1","2","3","4"])
            $table->string('reference_document')->nullable(); // link / file referensi kurikulum
            $table->string('regulation_number')->nullable(); // no. SK Dinas/Pemerintah (jika resmi)

            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('curriculums');
    }
};
