<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Academic;
use App\Models\Course;
use App\Models\Cotaught;
use App\Models\Program;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CoursesImport;
use App\Exports\CoursesExport;

/**
 * Class CourseController
 *
 * This controller handles the management of courses in the application.
 */
class CourseController extends Controller
{
/**
     * Display a listing of the courses.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::orderBy('id')->get();;
        return view('course.index')->with('courses', $courses);
    }

    /**
     * Show the form for creating a new course.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('course.add_course')->with('programs', program::all());
    }

    /**
     * Store a newly created course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'code' => 'required|max:255',
        ]);
//        dd($request['BIT']);
        $course = new Course();
        $course->code = $request->code;
        $course->name = $request->name;
        $course->prereq = $request->prereq;
        $course->transition = $request->transition;
        $course->tmethod = $request->tmethod;
        $course->note = $request->note;
        $course->save();
        $programs = program::all();
        $program_ids = [];
        foreach($programs as $program){
            if ($request[$program->name]){
                array_push($program_ids, $request[$program->name]);
            }
        }
        if ($program_ids) $course->programs()->attach($program_ids);

        return redirect("course");
    }

    /**
     * Display the specified course.
     *
     * This method retrieves the course with the given id from the database.
     * It then retrieves the offerings and cotaughts associated with the course.
     * It organizes the offerings into an array grouped by year and trimester.
     * Finally, it returns a view of the course details page, passing the course, cotaughts, and offerings to the view.
     *
     * @param  string  $id  The id of the course to display.
     * @return \Illuminate\View\View  The course details view.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        // dd($course->programs);
        $offerings = $course->offerings;

        $cotaughts = $course->cotaught();

        // Create a data structure like:
        // ["2023"=> ["1" => [{offering1}, {offering2}], "2"=>[], "3"=>[]],
        //  "2024"=>["1" => [{offering3},{offering4}], "2"=> [], "3"=>[]] ]
        $offerings_arr = [];
        foreach ($offerings as $offering){
            $year = strval($offering->year);
            $trimester = strval($offering->trimester);
            $offering->academic = $offering->convenor;
            if (!array_key_exists($year, $offerings_arr)) {
                $offerings_arr[$year]['1']= [];
                $offerings_arr[$year]['2']= [];
                $offerings_arr[$year]['3']= [];
            }
            array_push($offerings_arr[$year][$trimester], $offering);
        }

        krsort($offerings_arr);
        return view('course.show')->with('course', $course)->with('years_offerings', $offerings_arr)->with("cotaughts", $cotaughts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(string $id)
    {
        $courses = course::all();
        return view('course.edit')->with('courses', $courses);
    //     $course = Course::findOrFail($id);
    //    // dd($course->tmethod);
    //     $coursePrograms = [];
    //     foreach ($course->programs as $program){
    //         array_push($coursePrograms, $program->name);
    //     }
    //     return view('course.edit')->with('course', $course)->with('programs', program::all())->with('coursePrograms', $coursePrograms);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'code' => 'required|max:255',
        ]);
        $course = Course::findOrFail($id);
        $course->code = $request->code;
        $course->name = $request->name;
        $course->prereq = $request->prereq;
        $course->transition = $request->transition;
        $course->tmethod = $request->tmethod;
        $course->note = $request->note;
        $course->save();
        DB::table('program_course')->where('course_id', $course->id)->delete();
        $programs = program::all();
        $program_ids = [];
        foreach($programs as $program){
            if ($request[$program->name]){
                array_push($program_ids, $request[$program->name]);
            }
        }
        if ($program_ids) $course->programs()->attach($program_ids);

        return redirect("course/$course->id");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);

        if ($course->offerings->isEmpty()) {
            DB::table('program_course')->where('course_id', $course->id)->delete();
            $course->delete();
            return redirect("course");
        } else return redirect("course/$course->id")->with('error', 'Course NOT deleted! There are offerings for this course. Delete all offering before you can delete this course.');

    }

    /**
     * Show the form for adding a cotaught course.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function add_cotaught(string $id){
        $courses = course::all();
        $this_course = Course::findOrFail($id);
        return view('course.add_cotaught')->with('courses', $courses)->with('this_course', $this_course);
    }

    /**
     * Store a newly created cotaught course in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function store_cotaught(Request $request, string $id){
        $cotaught = new Cotaught();
        $cotaught->course_id = $id;
        $cotaught->co_taught_id = $request->co_taught;
        $cotaught->save();

        $cotaught = new Cotaught();
        $cotaught->course_id = $request->co_taught;
        $cotaught->co_taught_id = $id;
        $cotaught->save();

        return redirect("course/$id");
    }

    /**
     * Execute the search function from the top bar.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request){
    //    dd("here");
        $searchStr = $request->search;
        $length = strlen($searchStr);
        if ($length >= 1 && $length <= 255) {
            $coursesCode = Course::where("code", 'LIKE', "%$searchStr%")->get();
            $coursesName = Course::where("name", 'LIKE', "%$searchStr%")->get();
            $courses = $coursesCode->concat($coursesName)->unique();

            $academicFirstname = Academic::where("firstname", 'LIKE', "%$searchStr%")->get();
            $academicLastname = Academic::where("lastname", 'LIKE', "%$searchStr%")->get();
            $academics = $academicFirstname->concat($academicLastname)->unique();
            return view('searchResult')->with('courses', $courses)->with('academics', $academics);
        } else return view('searchError');
    }

    /**
     * Save the courses after editing.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function saveCourses(Request $request)
    {
        $ids = $request->input('id');  // Getting IDs to find each course
        $codes = $request->input('code');
        $names = $request->input('name');
        // $prereqs = $request->input('prereq');
        $courseLevel = $request->input('courseLevel');
        $transitions = $request->input('transition');
        $tmethods = $request->input('tmethod');
        $notes = $request->input('note');


        foreach ($ids as $index => $id) {
            $course = Course::find($id);
            if ($course) {
                $course->code = $codes[$index];
                $course->name = $names[$index];
                // $course->prereq = $prereqs[$index];
                $course->course_level = $courseLevel[$index];
                $course->transition = $transitions[$index];
                $course->note = $notes[$index];
                $course->save();
            }
        }

        return redirect()->route('course.index')->with('success', 'Courses updated successfully!');
    }

    /**
     * Import courses from an Excel file.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try {
            $import = new CoursesImport;
            Excel::import($import, $request->file('file'));
            return redirect()->route('course.index')->with('success', 'Courses Batch updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return back()->withFailures($failures);
        }
    }

    /**
     * Export courses to an Excel file.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function export(string $id)
    {
        return Excel::download(new CoursesExport, 'courses.xlsx');
    }

}
