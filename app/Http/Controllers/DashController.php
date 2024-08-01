<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic;
use App\Models\Course;
use App\Models\Cotaught;
use App\Models\Offering;

class DashController extends Controller
{
    /**
     * Display a list of courses for a specific year and trimester.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function courses(Request $request)
    {
        $year = (int)$request->year;
        $tri = (int)$request->trimester;
        $offerings = Offering::where('year', $year)->where('trimester', $tri)->get();

        // Create a data structure as follows:
        // ['course_id':[offering1, offering2], 'course_id':[offering3, offering4]]
        $offerings_arr = [];
        foreach ($offerings as $offering){
            $course_id = strval($offering->course_id);
            $offering->academic = $offering->convenor;
            if (array_key_exists($course_id, $offerings_arr)) {
                // dd($offerings_arr[$year]);
                array_push($offerings_arr[$course_id], $offering);
            } else {
                $offerings_arr[$course_id] = array($offering);
            }  
        }

        return view('dash.courses')->with('year', $year)->with('tri', $tri)->with('courses_offerings', $offerings_arr);
    }

    /**
     * Display a list of academics for a specific year.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function academics(Request $request){
        $year = (int)$request->year;
        $offerings = Offering::where('year', $year)->get();

        // Create a data structure as follows:
        // ['academic_id1':[offering1, offering2], 'academic_id2':[offering3, offering4]]
        $academics_arr = [];

        // V2
        // ['academic_id1": academic_dash_obj1, 'academic_id2": academic_dash_obj2]
        // academic_dash_arr is ['academic' = academic_obj, 'tcount' = ' ', 
        //                        'T1' = [offering_obj, ...], 'T2' = [offering_obj, ...], 'T3' = [offering_obj, ...]]
        foreach ($offerings as $offering){
            if (isset($offering->convenor)){
                $academic_id = strval($offering->academic_id);
                $offering->academic = $offering->convenor;
                if (!array_key_exists($academic_id, $academics_arr)) {
                    $academic_dash_arr['academic'] = $offering->convenor;
                    $academic_dash_arr['tcount'] = 0;
                    $academic_dash_arr['nstudents'] = 0;
                    $academic_dash_arr['T1'] = [];
                    $academic_dash_arr['T2'] = [];
                    $academic_dash_arr['T3'] = [];

                    $academics_arr[$academic_id] = $academic_dash_arr;
                }
            
               // dd($academics_arr[$academic_id]);
                if ($offering->trimester == 1) array_push($academics_arr[$academic_id]['T1'], $offering);
                else if ($offering->trimester == 2) array_push($academics_arr[$academic_id]['T2'], $offering);
                else if ($offering->trimester == 3) array_push($academics_arr[$academic_id]['T3'], $offering);
                if ($offering->tcount) $academics_arr[$academic_id]['tcount']++;
                $academics_arr[$academic_id]['nstudents'] += $offering->nstudents;
            }
        }
        return view('dash.academics')->with('year', $year)->with('academics', $academics_arr);
    }
}
