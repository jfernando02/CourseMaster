<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdditionalCoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('courses')->insert([
            'code'=>'7812ICT',
            'name'=>'Agile Business Analysis',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online/On-campus Lecture, On-campus Workshop',
            'note' => '',
        ]);

        DB::table('courses')->insert([
            'code'=>'7031ICT',
            'name'=>'Applied Data Mining',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7103ICT',
            'name'=>'Business Analysis',
            'prereq' => '7812ICT Agile Business Analysis',
            'transition' => '',
            'tmethod' => 'Online Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7011CAL',
            'name'=>'Communication for IT Professionals',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, Online Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7130ICT',
            'name'=>'Data Analytics',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7004ICT',
            'name'=>'Data Communication',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7906ICT',
            'name'=>'Digital Investigations',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7302ICT',
            'name'=>'Enterprise Architecture Applications',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7301ICT',
            'name'=>'Enterprise Architecture Concepts',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7340AFE',
            'name'=>'Financial Crime Regulation and Compliance',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7152AFE',
            'name'=>'Forensic Accounting, Fraud and Investigation',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, Online Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7502ICT',
            'name'=>'Fundamentals of Blockchain and Distributed Ledger Technology',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture',
            'note' => 'Offered at Gold Coast',
        ]);
        DB::table('courses')->insert([
            'code'=>'7905ICT',
            'name'=>'Fundamentals of Cyber Security',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7506ICT',
            'name'=>'Industrial Applications of Blockchain',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7114IBA',
            'name'=>'Information Management and Control',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online/On-campus Lecture, On-campus Workshop',
            'note' => 'Offered at Nathan',
        ]);
        DB::table('courses')->insert([
            'code'=>'7006ICT',
            'name'=>'Introduction to Artificial Intelligence',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7030ICT',
            'name'=>'Introduction to Big Data Analytics',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online/On-campus Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7907ICT',
            'name'=>'IT and Cyber Security Governance, Policy, Ethics and Law',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7806ICT',
            'name'=>'IT Services Management',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7040IBA',
            'name'=>'Managing Digital Systems',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, Online Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7421ICT',
            'name'=>'Mobile Device Software Development',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7809ICT',
            'name'=>'Offensive Cyber Security',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online/On-campus Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7005ICT',
            'name'=>'Programming Principles 2',
            'prereq' => '7001ICT Programming Principles 1',
            'transition' => '',
            'tmethod' => 'Online Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7808ICT',
            'name'=>'Project and Cyber Security Management',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7113ICT',
            'name'=>'Research for IT Professionals',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online/On-campus Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7623ICT',
            'name'=>'Secure Development Operations',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7810ICT',
            'name'=>'Software Technologies',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7805ICT',
            'name'=>'System and Software Design',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'Online Lecture, Online/On-campus Workshop',
            'note' => '',
        ]);
        DB::table('courses')->insert([
            'code'=>'7055CCJ',
            'name'=>'Understanding and Preventing Cyber Fraud',
            'prereq' => 'None',
            'transition' => '',
            'tmethod' => 'On-campus Lecture',
            'note' => '',
        ]);
    }
}
