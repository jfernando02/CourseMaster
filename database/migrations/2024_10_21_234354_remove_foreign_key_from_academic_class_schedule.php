<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RemoveForeignKeyFromAcademicClassSchedule extends Migration
{
    public function up(): void
    {
        // Rename the existing table
        Schema::rename('academic_class_schedule', 'academic_class_schedule_old');

        // Create new table with same schema
        Schema::create('academic_class_schedule', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_schedule_id');
            $table->unsignedBigInteger('academic_id');
            $table->timestamps();

            $table->foreign('class_schedule_id')->references('id')->on('classSchedule')->onDelete('cascade');
            $table->foreign('academic_id')->references('id')->on('academics')->onDelete('cascade');
        });

        Schema::drop('academic_class_schedule_old');
    }

    public function down()
    {
        // Just in case things go wrong,
        // add a way to revert the changes made in up()
    }
}
