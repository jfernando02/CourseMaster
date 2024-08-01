<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MockofferingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('offerings')->insert([
            'course_id'=>'1',
            'year'=> 2023,
            'trimester' => 1,
            'campus' => 'Online',
            'academic_id' => 1,
            'Primary' => true,
            'note' => 'None',
        ]);
    }
}
