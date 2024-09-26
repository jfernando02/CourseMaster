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
        Schema::create('academic_class_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_schedule_id');
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('offering_id');
            $table->timestamps();

            $table->foreign('class_schedule_id')->references('id')->on('classSchedule')->onDelete('cascade');
            $table->foreign(['academic_id', 'offering_id'])->references(['academic_id','offering_id'])->on('academic_offering')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_class_schedule');
    }
};
