<?php

namespace App\Http\Controllers;

use App\Models\ClassSchedule;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Offering;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function getClasses(Request $request){
        $year = (string) $request->query('year');
        $trimester = (string) $request->query('trimester');
        $academic_id = Auth::user()->academic->id;
        $classes = ClassSchedule::with('academic', 'offering', 'offering.course')
            ->whereHas('academic', function ($query) use ($academic_id) {
                $query->where('academics.id', $academic_id);
            })
            ->whereHas('offering', function ($query) use ($year, $trimester) {
                $query->where('year', $year)
                    ->where('trimester', $trimester);
            })
            ->get();
        // Transform the data into a suitable format, if necessary
        Log::debug('Classes:', $classes->toArray());

        return response()->json($classes); // Returns data as JSON response
    }

    public function getOfferings(Request $request){
        $year = (string) $request->query('year');
        $trimester = (string) $request->query('trimester');
        $academic_id = Auth::user()->academic->id;
        $offerings = Offering::with('course', 'academics')
            ->whereHas('academics', function ($query) use ($academic_id) {
                $query->where('id', $academic_id);
            })
            ->where('year', $year)
            ->where('trimester', $trimester)
            ->get();

        return response()->json($offerings); // Returns data as JSON response
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
        $menu1Options = ['offerings', 'classes'];
        $menu2Options = ['1', '2', '3'];
        $menu3Options = ['2022','2023','2024', '2025', '2026', '2027', '2028'];

        return view('home.index', compact('threshold_trimester', 'name', 'department', 'setting', 'menu1Options', 'menu2Options', 'menu3Options'));
    }
}
