<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\ClassSchedule;


class classesScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        ClassSchedule::factory()->count(30)->create();

        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'50',
        //     'academic_id' => 57,
        //     'class_type' => 'Lecture',
        //     'start_time' => '13:00',
        //     'end_time' => '14:50',
        //     // 'campus' => 'Online',
        //     'class_day' => 'Wednesday',
        //     'numberofstudents' => 20,
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'50',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 57,
        //     // 'campus' => 'Nathan',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Thursday',
        //     'start_time' => '15:00',
        //     'end_time' => '16:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'50',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 57,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Friday',
        //     'start_time' => '15:00',
        //     'end_time' => '16:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'51',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 71,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Thursday',
        //     'start_time' => '12:00',
        //     'end_time' => '13:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'51',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 60,
        //     // 'campus' => 'Nathan',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Friday',
        //     'start_time' => '14:00',
        //     'end_time' => '15:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'51',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 54,
        //     // 'campus' => 'Online',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Wednesday',
        //     'start_time' => '12:00',
        //     'end_time' => '13:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'52',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 59,
        //     // 'campus' => 'Online',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Monday',
        //     'start_time' => '10:30',
        //     'end_time' => '12:20',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'52',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 51,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Tuesday',
        //     'start_time' => '08:00',
        //     'end_time' => '09:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'52',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 71,
        //     // 'campus' => 'Nathan',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Wednesday',
        //     'start_time' => '14:00',
        //     'end_time' => '15:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'53',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 73,
        //     // 'campus' => 'Online',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Monday',
        //     'start_time' => '14:00',
        //     'end_time' => '15:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'53',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 73,
        //     // 'campus' => 'Online',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Monday',
        //     'start_time' => '16:00',
        //     'end_time' => '17:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'54',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 11,
        //     // 'campus' => 'Online',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Monday',
        //     'start_time' => '16:00',
        //     'end_time' => '18:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'54',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 75,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Tuesday',
        //     'start_time' => '17:00',
        //     'end_time' => '18:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'55',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 56,
        //     // 'campus' => 'Nathan',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Friday',
        //     'start_time' => '13:00',
        //     'end_time' => '14:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'55',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 71,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Tuesday',
        //     'start_time' => '08:00',
        //     'end_time' => '09:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'55',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 71,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Wednesday',
        //     'start_time' => '15:00',
        //     'end_time' => '16:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'55',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 54,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Leture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Thursday',
        //     'start_time' => '14:00',
        //     'end_time' => '16:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'56',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 55,
        //     // 'campus' => 'Online',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Wednesday',
        //     'start_time' => '12:00',
        //     'end_time' => '13:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'56',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 61,
        //     // 'campus' => 'Nathan',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Friday',
        //     'start_time' => '12:00',
        //     'end_time' => '13:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'56',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 64,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Thursday',
        //     'start_time' => '12:00',
        //     'end_time' => '13:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'56',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 72,
        //     // 'campus' => 'Nathan',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Tuesday',
        //     'start_time' => '12:00',
        //     'end_time' => '13:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'56',
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 73,
        //     // 'campus' => 'Nathan',
        //     'class_type' => 'Lecture',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Friday',
        //     'start_time' => '21:00',
        //     'end_time' => '22:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'57',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 58,
        //     // 'campus' => 'Online',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Monday',
        //     'start_time' => '11:00',
        //     'end_time' => '14:50',
        //     // 'note' => 'None',
        // ]);
        // DB::table('classesSchedule')->insert([
        //     'offering_id'=>'57',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 53,
        //     // 'campus' => 'Gold Coast',
        //     'class_type' => 'Workshop',
        //     'numberofstudents' => 20,
        //     'class_day' => 'Tuesday',
        //     'start_time' => '11:00',
        //     'end_time' => '14:50',
        //     // 'note' => 'None',
        // ]);

    }
    
}
