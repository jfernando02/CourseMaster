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
        Schema::table('offerings', function (Blueprint $table) {
            $table->unique(['course_id', 'year', 'trimester', 'campus']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropUnique(['course_id', 'year', 'trimester', 'campus']);
        });
    }
};
