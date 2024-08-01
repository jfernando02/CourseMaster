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
            // Add a unique constraint
            $table->unique(['course_id', 'year', 'trimester','campus'], 'course_year_trimester_unique');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('offerings', function (Blueprint $table) {
            // Drop the unique constraint if needed
            $table->dropUnique('course_year_trimester_unique');
        });
    }
};
