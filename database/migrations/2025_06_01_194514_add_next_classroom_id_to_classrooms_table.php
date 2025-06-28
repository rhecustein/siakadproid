<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->unsignedBigInteger('next_classroom_id')->nullable()->after('curriculum_id');

            $table->foreign('next_classroom_id')
                ->references('id')
                ->on('classrooms')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropForeign(['next_classroom_id']);
            $table->dropColumn('next_classroom_id');
        });
    }
};
