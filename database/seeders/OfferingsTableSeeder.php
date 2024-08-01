<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Offering;

class OfferingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Offering::factory()->count(100)->create();

        // DB::table('Offerings')->insert([
        //     'course_id'=>'1',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'campus' => 'GC',
        //     'academic_id' => 1,
        //     // 'Primary' => true,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'1',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 1,
        //     'campus' => 'OL',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'1',
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 2,
        //     'campus' => 'NA',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);

        // DB::table('Offerings')->insert([
        //     'course_id'=>'1',
        //     'year'=> 2024,
        //     'trimester' => 1,
        //     'campus' => 'GC',
        //     'academic_id' => 1,
        //     // 'Primary' => true,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'1',
        //     'year'=> 2024,
        //     'trimester' => 1,
        //     'academic_id' => 1,
        //     'campus' => 'OL',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'1',
        //     'year'=> 2024,
        //     'trimester' => 1,
        //     'academic_id' => 2,
        //     'campus' => 'NA',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'2',  // Computer Systems and Cyber
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 6,
        //     'campus' => 'GC',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'2',  // Computer Systems and Cyber
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 3,
        //     'campus' => 'NA',
        //     // 'Primary' => true,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'2',  // Computer Systems and Cyber
        //     'year'=> 2023,
        //     'trimester' => 1,
        //     'academic_id' => 3,
        //     'campus' => 'OL',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);

        // DB::table('Offerings')->insert([
        //     'course_id'=>'3',  // HCI
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 1,
        //     'campus' => 'GC',
        //     // 'Primary' => true,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'3',  // HCI
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 1,
        //     'campus' => 'OL',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);
        // DB::table('Offerings')->insert([
        //     'course_id'=>'3',  // HCI
        //     'year'=> 2023,
        //     'trimester' => 2,
        //     'academic_id' => 5,
        //     'campus' => 'NA',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);

        // DB::table('Offerings')->insert([
        //     'course_id'=>'2',  // Computer Systems and Cyber
        //     'year'=> 2023,
        //     'trimester' => 3,
        //     'academic_id' => 6,
        //     'campus' => 'NA',
        //     // 'Primary' => true,
        //     'notes' => 'None',
        // ]);

        // DB::table('Offerings')->insert([
        //     'course_id'=>'2',  // Computer Systems and Cyber
        //     'year'=> 2023,
        //     'trimester' => 3,
        //     'academic_id' => 6,
        //     'campus' => 'OL',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);

        // DB::table('Offerings')->insert([
        //     'course_id'=>'2',  // Computer Systems and Cyber
        //     'year'=> 2023,
        //     'trimester' => 3,
        //     'academic_id' => 7,
        //     'campus' => 'GC',
        //     // 'Primary' => false,
        //     'notes' => 'None',
        // ]);
    }
}
