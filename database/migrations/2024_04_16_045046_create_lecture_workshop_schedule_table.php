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
        Schema::create('lecture_workshop_schedule', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('offering_id');
            $table->foreign('offering_id')->references('id')->on('offerings');

            $table->time('lecture_start_time')->nullable();
            $table->time('lecture_end_time')->nullable();
            $table->time('workshop_start_time')->nullable();
            $table->time('workshop_end_time')->nullable();
            $table->string('lecture_day')->nullable();
            $table->string('workshop_day')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecture_workshop_schedule');
    }
};
