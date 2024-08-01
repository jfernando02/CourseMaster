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
        Schema::create('offerings', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('course_id');
            $table->integer('year');
            $table->integer('trimester');
            $table->string('campus');
            $table->bigInteger('academic_id')->nullable();
            $table->boolean('primary')->nullable();
            $table->boolean('tcount')->nullable();
            $table->integer('nstudents')->nullable();
            $table->integer('nlectures')->nullable();
            $table->integer('nworkshops')->nullable();
            $table->integer('TAThours')->nullable();
            $table->text('note')->nullable();
            $table->string('reserved')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropColumn('lecture_start_time');
            $table->dropColumn('lecture_end_time');
            $table->dropColumn('workshop_start_time');
            $table->dropColumn('workshop_end_time');
        });
    }

};
