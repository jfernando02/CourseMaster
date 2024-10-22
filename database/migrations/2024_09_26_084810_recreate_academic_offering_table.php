<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasTable('academic_offering')) {
            Schema::rename('academic_offering', 'old_academic_offering');
        }
        Schema::create('academic_offering', function (Blueprint $table) {
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('offering_id');
            $table->timestamps();

            $table->primary(['academic_id', 'offering_id']);
            $table->foreign('academic_id')->references('id')->on('academics')->onDelete('cascade');
            $table->foreign('offering_id')->references('id')->on('offerings')->onDelete('cascade');
        });

        if (Schema::hasTable('academic_offering')) {
            Schema::drop('old_academic_offering');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
