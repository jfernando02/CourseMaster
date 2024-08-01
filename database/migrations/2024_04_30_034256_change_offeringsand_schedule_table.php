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
        //
        // remove nstudents and nlectures from offeringstable
        Schema::table('offerings', function (Blueprint $table) {
            $table->dropColumn('nstudents');
            $table->dropColumn('nlectures');
            $table->dropColumn('TAThours');
            $table->dropColumn('nworkshops');
            $table->dropColumn('lecture_start_time');
            $table->dropColumn('lecture_end_time');
            $table->dropColumn('workshop_start_time');
            $table->dropColumn('workshop_end_time');
            // remove tcount and primary
            $table->dropColumn('tcount');
            $table->dropColumn('Primary');

        });

        // remove workshop lecture table
        Schema::dropIfExists('lecture_workshop_schedule');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
