<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Programs')->insert([
            'name'=>'BIT',
            'fullname'=> 'Bachelor of Information Technology',
            'code' => '1538',
            'note' => 'None',
        ]);
        DB::table('Programs')->insert([
            'name'=>'BCS',
            'fullname'=> 'Bachelor of Computer Science',
            'code' => '15XX',
            'note' => 'None',
        ]);

    }
}
