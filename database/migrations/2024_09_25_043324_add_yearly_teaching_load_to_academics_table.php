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
        Schema::table('academics', function (Blueprint $table) {
            Schema::table('academics', function (Blueprint $table) {
                $table->integer('yearly_teaching_load')->default(0);
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academics', function (Blueprint $table) {
            $table->dropColumn('yearly_teaching_load');
        });
    }
};
