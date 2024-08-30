<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic;
use App\Models\Course;
use App\Models\Offering;
use App\Models\Setting;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OfferingsImport;
use App\Exports\OfferingsExport;
use App\Models\ClassSchedule;

class OfferingController extends Controller
{
    /**
     * Display a listing of the offerings.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $offerings = Offering::whereHas('course')->orderBy('id')->get();
        return view('offering.index')->with('offerings', $offerings);
    }

    /**
     * Show the form for editing offerings in bulk.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit_bulk()
    {
        $current_year = Setting::latest()->first()->current_year;
        $current_trimester = Setting::latest()->first()->current_trimester;
        // $offerings = Offering::orderBy('id')->get();
        $offerings = Offering::whereHas('course')->orderBy('id')->get();

        // dd($offerings);
        $academics = Academic::all()->unique('id')->sortBy('firstname');
        $campuses = Setting::latest()->first()->campuses;
        $campuses = json_decode($campuses, true);
        return view('offering.edit_bulk', compact('campuses', 'offerings', 'academics'));
    }


    // public function edit_bulk()
    // {
    //     $offerings = Offering::orderBy('year', 'desc')->orderBy('trimester')->orderBy('campus')->get();
    //     return view('offering.edit_bulk')->with('offerings', $offerings);
    // }

    /**
     * Show the form for creating a new offering.
     *
     * @param  int  $course_id
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd($course_id);
        $academics = Academic::orderBy('lastname')->get();
        $course = Course::orderBy('code')->get();
        return view('offering.create')->with('course', $course)->with('academics', $academics);
    }

    /**
     * Check if the offering with the same course_id, year, trimester, campus exists.
     *
     * @param  int  $course_id
     * @param  int  $year
     * @param  int  $trimester
     * @param  string  $campus
     * @return bool
     */
    function checkExist($course_id, $year, $trimester, $campus){
        $offerings = Offering::where('course_id', $course_id)
                            ->where('year', $year)
                            ->where('trimester', $trimester)
                            ->where('campus', $campus)->get();
        if ($offerings->isEmpty()) return false;
        else return true;
    }

    /**
     * Store a newly created offering in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'year' => 'required',
            'trimester' => 'required|integer|between:1,3',
            'campus' => 'required',
/*             'nstudents' => 'integer',
            'nlectures' => 'integer',
            'nworkshops' => 'integer' */
        ]);
        // validation: need to ensure trimester is an integer betweeen 1 and 3
        $offering = new Offering();
        if ($this->checkExist($id, $request->year, $request->trimester, $request->campus))
            return redirect("course/$id")->with('error', 'Offering NOT added! This offering already exists!');
        $offering->course_id = $id;
        $offering->year = $request->year;
        $offering->trimester = $request->trimester;
        $offering->campus = $request->campus;
        $offering->academic_id = $request->convenor;

        $offering->note = $request->note;


        $offering->save();
        return redirect("course/".$id);
    }

    /**
     * Roll over offering from a year to another year.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function copy(Request $request){
        $from_year = $request->from_year;
        $to_year = $request->to_year;

        $offerings = Offering::where('year', $from_year)->get();
        foreach ($offerings as $offering){
            $new = $offering->replicate();
            $new->year = $to_year;
            $new->save();
        }
        return redirect('/');

    }

    /**
     * Display the specified offering.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $offering = Offering::findOrFail($id);
        $academic = Academic::findOrFail($offering->academic_id);
        $course = Course::findOrFail($offering->course_id);
        $classes = ClassSchedule::where('offering_id', $id)
                        ->with('academic')
                        ->get();

        return view('offering.show', compact('offering', 'academic', 'course', 'classes'));
    }

    /**
     * Show the form for editing the specified offering.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $offering = Offering::findOrFail($id);
        return view('offering.edit')->with('offering', $offering)
                                    ->with('course', $offering->course)
                                    ->with('academics', Academic::orderBy('lastname')->get());
    }

    /**
     * Update the specified offering in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'year' => 'required',
            'trimester' => 'required|integer|between:1,3',
            'campus' => 'required',
/*             'nstudents' => 'integer',
            'nlectures' => 'integer',
            'nworkshops' => 'integer' */
        ]);
        // validation: need to ensure trimester is an integer betweeen 1 and 3
        $offering = Offering::findOrFail($id);
//        if ($this->checkExist($id, $request->year, $request->trimester, $request->campus))
//            return redirect("course/$id")->with('error', 'Offering NOT added! This offering already exists!');
        $offering->year = $request->year;
        $offering->trimester = $request->trimester;
        $offering->campus = $request->campus;
        $offering->academic_id = $request->convenor;
        $offering->primary = $request->primary;
        $offering->tcount = $request->tcount;
        $offering->nstudents = $request->nstudents;
        $offering->nlectures = $request->nlectures;
        $offering->nworkshops = $request->nworkshops;
        $offering->TAThours = $request->nlectures + $request->nworkshops;
        $offering->note = $request->note;

        $offering->lecture_day = $request->lectureday;
        $offering->lecture_start_time = $request->lecturestarttime;
        $offering->lecture_end_time = $request->lectureendtime;
        $offering->workshop_day = $request->workshopday;
        $offering->workshop_start_time = $request->workshopstarttime;
        $offering->workshop_end_time = $request->workshopendtime;

        $offering->save();
        return redirect("offering/".$id);


    }

    /**
     * Remove the specified offering from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $offering = Offering::findOrFail($id);
        $course_id = $offering->course->id;
        $offering->delete();
        return redirect("course/".$course_id);
    }

    /**
     * Save offerings in bulk.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveOfferings(Request $request){

        $offering_ids = $request->input('id');
        $years = $request->input('year');
        $trimesters = $request->input('trimester');
        $campuses = $request->input('campus');
        $academic_ids = $request->input('academic_id');
        $notes = $request->input('note');

        foreach ($offering_ids as $index => $id) {
            $offering = Offering::findOrFail($id);
            $offering->year = $years[$index];
            $offering->trimester = $trimesters[$index];
            $offering->campus = $campuses[$index];
            $offering->academic_id = $academic_ids[$index];
            $offering->note = $notes[$index];
            if (!$offering->save()) {
                dd("Save failed!");
            }
        }

        // return redirect('edit_bulk');
        return redirect()->route('offering.edit_bulks')->with('success', 'Academics updated successfully!');
    }


    /**
     * Import offerings from a file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try{
            $import = new OfferingsImport();
            Excel::import($import, $request->file('file'));
            return back()->with('success', 'Offerings imported successfully!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withFailures($failures);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Export offerings to a file.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function export(string $id)
    {
        return Excel::download(new OfferingsExport, 'offerings.xlsx');
    }
}
