<?php

namespace App\Http\Controllers;

use App\Models\Offering;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Academic;
use App\Models\Course;


class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $year = $request->input('year');
        $term = $request->input('term');

        // $academics = list of teachgin staff
        $courses = Course::all();   


        $query = DB::table('offerings')
                    ->join('courses', 'offerings.course_id', '=', 'courses.id')
                    ->join('academics', 'offerings.academic_id', '=', 'academics.id')
                    ->select('offerings.year AS Year', 'offerings.trimester AS Term', 'courses.code AS Course_Code', 
                    'courses.name AS Course_Name', 'academics.firstname AS Academic_Name', 'offerings.campus AS Campus',)
                    ->groupBy('offerings.year', 'offerings.trimester', 'courses.code', 'courses.name')
                    ->where('courses.id', 1);


        if ($year) {
            $query->where('offerings.year', $year);
        }

        if ($term) {
            $query->where('offerings.trimester', $term);
        }

        $reports = $query->get();

        return view('reports.index', compact('courses', 'reports'));
    }


     /* Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Report for Academic Workload per campus.
     */
    public function reportbycampus(string $id)
    {
        $offerings = Offering::groupBy('year')->orderBy('year','DESC')->groupBy('trimester')->orderBy('trimester','DESC')->groupBy('campus')->orderBy('campus','DESC')->get();
        $years = Offering::distinct()->orderBy('year', 'DESC')->pluck('year');
        $trimesters = Offering::distinct()->orderBy('trimester', 'DESC')->pluck('trimester');
        $campuses = Offering::distinct()->orderBy('campus', 'DESC')->pluck('campus');
        return view('reports.campusreport')->with('offerings',$offerings)->with('years',$years)->with('trimesters',$trimesters)->with('campuses',$campuses);
    }

    /**
     * Generate a report for Teaching Load.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportTeachingLoad() {
        $offerings = Offering::all();
        return view('reports.teachingloadtable', ['offerings' => $offerings]);
    }

    /**
     * Generate a report for Teaching Staff History.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function teachingStaffHistory (Request $request)
    {

        // dd($request);
        // $academicID = $request->input('academic_id');
        // $campus = $request->input('campus');

        // $offerings = Offering::where('academic_id', $academicID)
        //     ->where('campus', $campus)
        //     ->get();

        $query = DB::table('offerings')
        ->join('courses', 'offerings.course_id', '=', 'courses.id')
        ->join('academics', 'offerings.academic_id', '=', 'academics.id')
        ->select('offerings.year AS Year', 'offerings.trimester AS Term', 'courses.code AS Course_Code', 
        'courses.name AS Course_Name', 'academics.firstname AS Academic_Name', 'offerings.campus AS Campus',)
        ->groupBy('offerings.year', 'offerings.trimester', 'courses.code', 'courses.name')
        ->where('courses.id', 1);
        // dd($query->get());

        return redirect()->route('reports.index')->with('success', 'Academics updated successfully!')->with('reports', $query->get());


    }
}
