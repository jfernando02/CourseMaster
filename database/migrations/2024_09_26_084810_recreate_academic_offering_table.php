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
        Schema::create('academic_offering', function (Blueprint $table) {
            $table->unsignedBigInteger('academic_id');
            $table->unsignedBigInteger('offering_id');
            $table->timestamps();

            $table->primary(['academic_id', 'offering_id']);
            $table->foreign('academic_id')->references('id')->on('academics')->onDelete('cascade');
            $table->foreign('offering_id')->references('id')->on('offerings')->onDelete('cascade');
        });

        $data = DB::table('old_academic_offering')->select('academic_id', 'offering_id')->get()->toArray();

        foreach ($data as $row) {
            // Insert each row to new table
            DB::table('academic_offering')->insert(get_object_vars($row));
        }

        Schema::drop('old_academic_offering');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_offering');
    }
};
