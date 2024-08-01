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
        Schema::create('classSchedule', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->unsignedBigInteger('offering_id');
            $table->foreign('offering_id')->references('id')->on('offerings');

            $table->unsignedBigInteger('academic_id');
            $table->foreign('academic_id')->references('id')->on('academics')->nullable();

            $table->string('class_type')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('class_day')->nullable();

            $table->integer('numberOfStudents')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classSchedule');
    }
};
