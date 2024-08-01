<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CotaughtsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Cotaughts')->insert([
            'course_id'=> 2,
            'co_taught_id'=> 4,
        ]);
        DB::table('Cotaughts')->insert([
            'course_id'=> 4,
            'co_taught_id'=> 2,
        ]);
    }
}
