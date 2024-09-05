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
        Schema::dropIfExists('courses');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string("code");
            $table->string("name");
            $table->integer('academic_id')->nullable();
            $table->text('prereq')->nullable();
            $table->text('transition')->nullable();
            $table->text('supersededBy')->nullable();
            $table->text('course_level')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }
};
