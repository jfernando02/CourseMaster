<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Academics')->insert([
            'firstname'=>'John',
            'lastname'=>'Smith',
            'teaching_load' => 40,
            'area' => 'Data Analytics, HCI',
            'note' => '',
            'email'=>'john@smith.com',
        ]);
        DB::table('Academics')->insert([
            'firstname'=>'Evelyn',
            'lastname'=>'Hart',
            'teaching_load' => 40,
            'area' => 'Cyber Security, Ethics',
            'note' => '',
            'email'=>'evelyn@hart.com',
        ]);
        DB::table('Academics')->insert([
            'firstname'=>'Amelia',
            'lastname'=>'Ford',
            'teaching_load' => 40,
            'area' => 'Computer Networks',
            'note' => '',
            'email'=>'amelia@ford.com',
        ]);
        DB::table('Academics')->insert([
            'firstname'=>'Ethan',
            'lastname'=>'Long',
            'teaching_load' => 40,
            'area' => 'Computer Networks, Block Chain',
            'note' => '',
            'email'=>'ethan@long.com',
        ]);
        DB::table('Academics')->insert([
            'firstname'=>'Sophia',
            'lastname'=>'Ross',
            'teaching_load' => 60,
            'area' => 'Programming, algorithms',
            'note' => '',
            'email'=>'sophia@ross.com',
        ]);
        DB::table('Academics')->insert([
            'firstname'=>'Noah',
            'lastname'=>'Price',
            'teaching_load' => 40,
            'area' => 'VR',
            'note' => '',
            'email'=>'noah@price.com',
        ]);
        DB::table('Academics')->insert([
            'firstname'=>'Emma',
            'lastname'=>'Brooks',
            'teaching_load' => 40,
            'area' => '',
            'note' => '',
            'email'=>'emma@brooks.com',
        ]);
        DB::table('Academics')->insert([
            'firstname'=>'Mason',
            'lastname'=>'Wells',
            'teaching_load' => 40,
            'area' => '',
            'note' => '',
            'email'=>'mason@wells.com',
        ]);

        DB::table('Academics')->insert([
            'firstname'=>'Teach-a-lot',
            'lastname'=>'0',
            'teaching_load' => 100,
            'area' => '',
            'note' => '',
            'email'=>'teachalot@email.com',
        ]);

        DB::table('Academics')->insert([
            'firstname'=>'Joseph',
            'lastname'=>'Fernando',
            'teaching_load' => 60,
            'area' => '',
            'note' => '',
            'email'=>'jfernando020202@gmail.com',
        ]);

        DB::table('Academics')->insert([
            'firstname'=>'Test',
            'lastname'=>'User',
            'teaching_load' => 60,
            'area' => '',
            'note' => '',
            'email'=>'joseph.fernando@griffithuni.edu.au',
        ]);
    }
}
