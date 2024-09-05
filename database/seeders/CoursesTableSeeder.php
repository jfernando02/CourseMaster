<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('Courses')->insert([
            'code'=>'1004ICT',
            'name'=>'Professional Practice in ICT',
            'prereq' => 'None',
            'transition' => 'New version of 1004ICT from 2024',
            'note' => '',
        ]);
        DB::table('Courses')->insert([
            'code'=>'1007ICT',
            'name'=>'Computer Systems and Cyber Security',
            'prereq' => 'None',
            'transition' => 'New version of 1007ICT from 2024',
            'note' => '',
        ]);
        DB::table('Courses')->insert([
            'code'=>'1805ICT',
            'name'=>'Human Computer Interaction',
            'prereq' => 'None',
            'transition' => 'Last offering in 2023. Students take 1022ENG instead.',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'7611ICT',
            'name'=>'Computer Systems and Networks',
            'prereq' => 'None',
            'transition' => '',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'1701ICT',
            'name'=>'Creative Coding',
            'prereq' => 'None',
            'transition' => '',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'1803ICT',
            'name'=>'Information Systems Foundations',
            'prereq' => 'None',
            'transition' => '',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'2810ICT',
            'name'=>'Software Technologies',
            'prereq' => '1811ICT/2807ICT Programming Principles',
            'transition' => 'Name change to Software Engineering from 2025',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'1621ICT',
            'name'=>'Web Technologies',
            'prereq' => '',
            'transition' => 'Last offer 2024. From 2025 students do 2008ICT Design Thinking in IT',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'7001ICT',
            'name'=>'Programming Principles 1',
            'prereq' => '',
            'transition' => '',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'7002ICT',
            'name'=>'Systems Development',
            'prereq' => '',
            'transition' => '',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'2814ICT',
            'name'=>'Data Management',
            'prereq' => '',
            'transition' => 'Last offered 2024. Becomes a 1st year course from 2025.',
            'note' => 'None',
        ]);
        DB::table('Courses')->insert([
            'code'=>'3410ICT',
            'name'=>'The Ethical Technologist',
            'prereq' => '',
            'transition' => 'Not offered from 2026. Students do 2007ICT Cyber Security Standards and Operations from 2026.',
            'note' => 'None',
        ]);
    }
}
