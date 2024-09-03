<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Offering;

class HomeController extends Controller
{
    public function getClasses(Request $request){
        $year = (string) $request->query('year');
        $trimester = (string) $request->query('trimester');
        $classes = ClassSchedule::with('offering', 'offering.course')->whereHas('offering', function ($query) use ($year, $trimester) {
            $query->where('year', $year)
                ->where('trimester', $trimester);
        })->get();
        // Transform the data into a suitable format, if necessary

        return response()->json($classes); // Returns data as JSON response
    }

    public function getOfferings(Request $request){
        $year = (string) $request->query('year');
        $trimester = (string) $request->query('trimester');
        $offerings = Offering::with('course')->where('year', $year)
                ->where('trimester', $trimester)->get();
        // Transform the data into a suitable format, if necessary

        return response()->json($offerings); // Returns data as JSON response
    }

    public function getCourses(){
        $courses = Course::all();
        // Transform the data into a suitable format, if necessary

        return response()->json($courses); // Returns data as JSON response
    }
    public function showHome()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $name = $user->name;
            $academic_id = DB::table('academics')->where('email',$user->email)->first();
            if($academic_id) {
                $academic_id = $academic_id->id;
            } else {
                $academic_id = DB::table('academics')->inRandomOrder()->first()->id;
            }
        }

        // get setting through model
        $setting = \App\Models\Setting::latest()->first();
        $department = $setting ? $setting->department : null;
        $threshold_trimester = $setting ? $setting->threshold_trimester : null;
        $trimester = $setting->current_trimester;
        $year = $setting->current_year;
        $menu1Options = ['courses', 'offerings', 'classes'];
        $menu2Options = ['1', '2', '3'];
        $menu3Options = ['2022','2023','2024', '2025', '2026', '2027', '2028'];

        // filter offering based on academic id
        $offerings = DB::table('offerings')
            ->join('courses', 'offerings.course_id', '=', 'courses.id')
            ->select('offerings.year AS Year', 'offerings.trimester AS Term', 'courses.code AS Course_Code', 'courses.name AS Course_Name')
            ->where('offerings.academic_id', $academic_id) // Filter by academic ID
            ->where('offerings.year', $year) // Filter by year
            ->where('offerings.trimester', $trimester) // Filter by trimester
            ->groupBy('offerings.year', 'offerings.trimester', 'courses.code', 'courses.name')
            ->get();
        return view('home.index', compact('threshold_trimester', 'name', 'offerings', 'department', 'setting', 'menu1Options', 'menu2Options', 'menu3Options'));
    }
}
