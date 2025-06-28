<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('announcement_id');
            $table->unsignedBigInteger('user_id');

            $table->boolean('is_read')->default(false);  // status dibaca
            $table->timestamp('read_at')->nullable();    // waktu dibaca

            // 🔽 Tambahan yang disarankan
            $table->boolean('is_notified')->default(false); // apakah notifikasi pernah dikirim
            $table->timestamp('notified_at')->nullable();   // kapan notifikasi dikirim (email, WA, dll)

            $table->timestamps();

            $table->foreign('announcement_id')
                ->references('id')->on('announcements')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->unique(['announcement_id', 'user_id']);
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('announcement_users');
    }
};
